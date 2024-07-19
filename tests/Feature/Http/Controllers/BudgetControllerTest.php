<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Budget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BudgetController
 */
final class BudgetControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $budgets = Budget::factory()->count(3)->create();

        $response = $this->get(route('budgets.index'));

        $response->assertOk();
        $response->assertViewIs('budget.index');
        $response->assertViewHas('budgets');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('budgets.create'));

        $response->assertOk();
        $response->assertViewIs('budget.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetController::class,
            'store',
            \App\Http\Requests\BudgetStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = $this->faker->sentence(4);
        $amount = $this->faker->randomFloat(/** double_attributes **/);
        $is_pined = $this->faker->numberBetween(-8, 8);
        $created_at = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('budgets.store'), [
            'title' => $title,
            'amount' => $amount,
            'is_pined' => $is_pined,
            'created_at' => $created_at->toDateTimeString(),
        ]);

        $budgets = Budget::query()
            ->where('title', $title)
            ->where('amount', $amount)
            ->where('is_pined', $is_pined)
            ->where('created_at', $created_at)
            ->get();
        $this->assertCount(1, $budgets);
        $budget = $budgets->first();

        $response->assertRedirect(route('budget.index'));
        $response->assertSessionHas('budget.id', $budget->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budgets.show', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.show');
        $response->assertViewHas('budget');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->get(route('budgets.edit', $budget));

        $response->assertOk();
        $response->assertViewIs('budget.edit');
        $response->assertViewHas('budget');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BudgetController::class,
            'update',
            \App\Http\Requests\BudgetUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $budget = Budget::factory()->create();
        $title = $this->faker->sentence(4);
        $amount = $this->faker->randomFloat(/** double_attributes **/);
        $is_pined = $this->faker->numberBetween(-8, 8);
        $created_at = Carbon::parse($this->faker->dateTime());

        $response = $this->put(route('budgets.update', $budget), [
            'title' => $title,
            'amount' => $amount,
            'is_pined' => $is_pined,
            'created_at' => $created_at->toDateTimeString(),
        ]);

        $budget->refresh();

        $response->assertRedirect(route('budget.index'));
        $response->assertSessionHas('budget.id', $budget->id);

        $this->assertEquals($title, $budget->title);
        $this->assertEquals($amount, $budget->amount);
        $this->assertEquals($is_pined, $budget->is_pined);
        $this->assertEquals($created_at->timestamp, $budget->created_at);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $budget = Budget::factory()->create();

        $response = $this->delete(route('budgets.destroy', $budget));

        $response->assertRedirect(route('budget.index'));

        $this->assertModelMissing($budget);
    }
}
