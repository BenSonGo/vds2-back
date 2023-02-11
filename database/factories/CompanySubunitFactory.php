<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanySubunitFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::query()->first()->id,
            'name' => $this->faker->unique()->sentence(2),
        ];
    }
}
