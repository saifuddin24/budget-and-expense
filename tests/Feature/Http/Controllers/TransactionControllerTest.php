<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TransactionController
 */
final class TransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $transactions = Transaction::factory()->count(3)->create();

        $response = $this->get(route('transactions.index'));

        $response->assertOk();
        $response->assertViewIs('transaction.index');
        $response->assertViewHas('transactions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('transactions.create'));

        $response->assertOk();
        $response->assertViewIs('transaction.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'store',
            \App\Http\Requests\TransactionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = $this->faker->sentence(4);
        $account_profile_id = $this->faker->numberBetween(-10000, 10000);
        $cash_amount = $this->faker->randomFloat(/** double_attributes **/);
        $bank_amount = $this->faker->randomFloat(/** double_attributes **/);
        $created_at = Carbon::parse($this->faker->dateTime());

        $response = $this->post(route('transactions.store'), [
            'title' => $title,
            'account_profile_id' => $account_profile_id,
            'cash_amount' => $cash_amount,
            'bank_amount' => $bank_amount,
            'created_at' => $created_at->toDateTimeString(),
        ]);

        $transactions = Transaction::query()
            ->where('title', $title)
            ->where('account_profile_id', $account_profile_id)
            ->where('cash_amount', $cash_amount)
            ->where('bank_amount', $bank_amount)
            ->where('created_at', $created_at)
            ->get();
        $this->assertCount(1, $transactions);
        $transaction = $transactions->first();

        $response->assertRedirect(route('transaction.index'));
        $response->assertSessionHas('transaction.id', $transaction->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.show', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.show');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.edit', $transaction));

        $response->assertOk();
        $response->assertViewIs('transaction.edit');
        $response->assertViewHas('transaction');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TransactionController::class,
            'update',
            \App\Http\Requests\TransactionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $transaction = Transaction::factory()->create();
        $title = $this->faker->sentence(4);
        $account_profile_id = $this->faker->numberBetween(-10000, 10000);
        $cash_amount = $this->faker->randomFloat(/** double_attributes **/);
        $bank_amount = $this->faker->randomFloat(/** double_attributes **/);
        $created_at = Carbon::parse($this->faker->dateTime());

        $response = $this->put(route('transactions.update', $transaction), [
            'title' => $title,
            'account_profile_id' => $account_profile_id,
            'cash_amount' => $cash_amount,
            'bank_amount' => $bank_amount,
            'created_at' => $created_at->toDateTimeString(),
        ]);

        $transaction->refresh();

        $response->assertRedirect(route('transaction.index'));
        $response->assertSessionHas('transaction.id', $transaction->id);

        $this->assertEquals($title, $transaction->title);
        $this->assertEquals($account_profile_id, $transaction->account_profile_id);
        $this->assertEquals($cash_amount, $transaction->cash_amount);
        $this->assertEquals($bank_amount, $transaction->bank_amount);
        $this->assertEquals($created_at->timestamp, $transaction->created_at);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete(route('transactions.destroy', $transaction));

        $response->assertRedirect(route('transaction.index'));

        $this->assertModelMissing($transaction);
    }
}
