<?php

namespace App\Services;

use App\Models\{Site, Server, Cdn};
use Faker\Factory as Faker;
use Illuminate\Support\Facades\{DB, Crypt, Http};
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SiteService
{
    public function store(Request $request)
    {

        $data = $request->only(['name', 'url', 'server_id', 'cdn_id']);
        $faker = Faker::create();

        DB::transaction(function () use ($request, $data, $faker, &$site) {
            if ($request->boolean('create_server')) {
                $server = Server::create([
                    'name' => $faker->domainWord() . '-server',
                    'ip'   => $faker->ipv4(),
                    'port' => $faker->randomNumber(4, true),
                ]);
                $data['server_id'] = $server->id;

                $server->credential()->create([
                    'login' => $faker->userName,
                    'password' => $faker->password,
                ]);
            }

            if ($request->boolean('create_cdn')) {
                $cdn = Cdn::create([
                    'name'     => strtoupper($faker->domainWord()) . ' CDN',
                    'provider' => $faker->company(),
                    'api_key'  => Str::random(32)
                ]);
                $data['cdn_id'] = $cdn->id;

                $cdn->credential()->create([
                    'login' => $faker->userName,
                    'password' => $faker->password,
                ]);
            }

            $site = Site::create($data);

            $cred = $request->input('credential', null);
            if ($cred && (filled($cred['login']) || filled($cred['password']))) {
                $site->credential()->create([
                    'login' => $cred['login'] ?? $faker->userName,
                    'password' => Crypt::encryptString($cred['password']) ?? $faker->password,
                ]);
            }
        });
    }

    public function update(Request $request, Site $site) {

        $data = $request->only(['name', 'url', 'server_id', 'cdn_id']);
        $faker = Faker::create();

        DB::transaction(function () use ($request, $data, $site, $faker) {
            if ($request->boolean('create_server')) {
                $server = Server::create(['name' => $faker->company]);
                $data['server_id'] = $server->id;

                $server->credential()->create([
                    'login' => $faker->userName,
                    'password' => $faker->password,
                ]);
            }

            if ($request->boolean('create_cdn')) {
                $cdn = Cdn::create(['name' => $faker->domainName]);
                $data['cdn_id'] = $cdn->id;

                $cdn->credential()->create([
                    'login' => $faker->userName,
                    'password' => $faker->password,
                ]);
            }

            $site->update($data);

            $cred = $request->input('credential', null);
            if ($cred && (filled($cred['login']) || filled($cred['password']))) {
                if ($site->credential) {
                    $site->credential()->update([
                        'login' => $cred['login'] ?? $site->credential->login,
                        'password' => Crypt::encryptString($cred['password']) ?? $site->credential->password,
                    ]);
                } else {
                    $site->credential()->create([
                        'login' => $cred['login'] ?? $faker->userName,
                        'password' => Crypt::encryptString($cred['password']) ?? $faker->password,
                    ]);
                }
            }
        });
    }


    public function checkAuth(Site $site): array
    {
        try {
            $cred = $site->credential;

            $response = Http::withBasicAuth($cred->login, $cred->password)
                ->timeout(5)
                ->get($site->url);

            return [
                'status' => $response->successful(),
                'code' => $response->status(),
                'message' => $response->successful()
                    ? 'Success auth'
                    : 'Error auth: ' . $response->status(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => false,
                'code' => null,
                'message' => 'Error check: ' . $e->getMessage(),
            ];
        }
    }

}
