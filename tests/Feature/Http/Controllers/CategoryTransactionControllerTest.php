<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CategoryTransactionController
 */
final class CategoryTransactionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('category-transactions.create'));

        $response->assertOk();
        $response->assertViewIs('category.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryTransactionController::class,
            'store',
            \App\Http\Requests\CategoryTransactionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('category-transactions.store'));

        $response->assertRedirect(route('category.index'));
        $response->assertSessionHas('category.id', $category->id);

        $this->assertDatabaseHas(categories, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $categoryTransaction = CategoryTransaction::factory()->create();

        $response = $this->get(route('category-transactions.show', $categoryTransaction));

        $response->assertOk();
        $response->assertViewIs('category.show');
        $response->assertViewHas('category');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $categoryTransaction = CategoryTransaction::factory()->create();

        $response = $this->get(route('category-transactions.edit', $categoryTransaction));

        $response->assertOk();
        $response->assertViewIs('category.edit');
        $response->assertViewHas('category');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryTransactionController::class,
            'update',
            \App\Http\Requests\CategoryTransactionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $categoryTransaction = CategoryTransaction::factory()->create();

        $response = $this->put(route('category-transactions.update', $categoryTransaction));

        $categoryTransaction->refresh();

        $response->assertRedirect(route('category.index'));
        $response->assertSessionHas('category.id', $category->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $categoryTransaction = CategoryTransaction::factory()->create();
        $categoryTransaction = Category::factory()->create();

        $response = $this->delete(route('category-transactions.destroy', $categoryTransaction));

        $response->assertRedirect(route('category.index'));

        $this->assertModelMissing($categoryTransaction);
    }
}
