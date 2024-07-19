<?php

namespace App\Http\Controllers;

use App\CategoryTransaction;
use App\Http\Requests\CategoryTransactionStoreRequest;
use App\Http\Requests\CategoryTransactionUpdateRequest;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BudgetTransactionController extends Controller
{
    public function create(Request $request, Budget $budget): View|Response|Array|String
    {
        
        $categories = Category::get();

        $store_route = route( 'budgets.transactions.store', $budget->id );

        $year_month = date('Y-m');
        if( old('year') && old('month') ) {
            $year_month = old('year').'-'.old('month');
        }

        $total_cash_transaction = $budget->total_cash_transaction($year_month);
        $total_bank_transaction = $budget->total_bank_transaction($year_month);

        return view('transaction.create', 
            compact( 
                'budget',
                'categories',
                'store_route',
                'total_cash_transaction', 
                'total_bank_transaction',
            )
        );

    }

    public function store(CategoryTransactionStoreRequest $request, Budget $budget)
    {
        $transaction = $budget->transactions()->create( $request->validated()  );

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route( 'budgets.show', $budget->id );
    }

    public function show(Request $request, Category $category, Transaction $transaction): View|Response|Array|String
    {
        return view('transaction.show', compact('category'));
    }

    public function edit(Request $request, Category $category, Transaction $transaction): View|Response|Array|String
    {
        return view('transaction.edit', compact('category'));
    }

    public function update(CategoryTransactionUpdateRequest $request, Category $category, Transaction $transaction)
    {
        $category->transactions()->update($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('transactions.index');
    }

    public function destroy(Request $request, Category $category, Transaction $transaction)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
