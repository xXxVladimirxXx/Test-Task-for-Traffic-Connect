<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\{Site};

class SitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Site::factory(3)->create()->each(function ($site) use ($faker){
            $site->credential()->create([
                'login' => $faker->userName,
                'password' => $faker->password,
            ]);
        });
    }
}
