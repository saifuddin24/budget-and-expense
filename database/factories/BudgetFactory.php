<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Budget;

class BudgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budget::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'is_pined' => $this->faker->randomDigitNotNull(),
            'frequency' => $this->faker->randomElement(["monthly","daily","weekly","yearly"]),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'deleted_at' => $this->faker->dateTime(),
        ];
    }
}
