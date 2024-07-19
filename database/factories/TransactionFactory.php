<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AccountProfile;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'account_profile_id' => AccountProfile::factory(),
            'category_id' => Category::factory(),
            'budget_id' => Budget::factory(),
            'cash_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'cash_trx_type' => $this->faker->randomElement(["debit","credit"]),
            'bank_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'bank_trx_type' => $this->faker->randomElement(["debit","credit"]),
            'created_at' => $this->faker->dateTime(),
            'deleted_at' => $this->faker->dateTime(),
        ];
    }
}
