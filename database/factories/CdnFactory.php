<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\{Cdn};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cdn>
 */
class CdnFactory extends Factory
{
    protected $model = Cdn::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper($this->faker->domainWord()) . ' CDN',
            'provider' => $this->faker->company(),
            'api_key' => Str::random(32)
        ];
    }
}
