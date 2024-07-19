<?php

namespace App\Http\Controllers;

use App\CategoryTransaction;
use App\Http\Requests\CategoryTransactionStoreRequest;
use App\Http\Requests\CategoryTransactionUpdateRequest;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryTransactionController extends Controller
{
    public function create(Request $request, Category $category): View|Response|Array|String
    {
        
        $budgets = Budget::query()->orderBy('frequency','DESC')->get([
            'id',
            DB::raw('IFNULL( CONCAT(frequency,"-",title), title) as title')
        ]);


        $store_route = route('categories.transactions.store', $category->id);

        return view('transaction.create', compact('category' ,'budgets','store_route'));
    }

    public function store(CategoryTransactionStoreRequest $request, Category $category)
    {
        $transaction = $category->transactions()->create($request->validated() + ['account_profile_id' => 2]);

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transactions.index');
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
