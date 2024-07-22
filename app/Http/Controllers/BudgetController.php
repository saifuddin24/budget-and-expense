<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetStoreRequest;
use App\Http\Requests\BudgetUpdateRequest;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(Request $request): Response|View|LengthAwarePaginator
    {
        // return 


        $budgets = Budget::query();
        $budgets = $budgets->with('category');
 
        $budgets->when($request->get('category-id'), function( $budgets, $category_id ){
            $budgets->where('category_id',$category_id);
        });
        
        $budgets = $budgets->orderBy( 'frequency','ASC' );
        $budgets = $budgets->orderBy( 'title','DESC' );

        $budgets = $budgets->paginate($request->get('perPage', 15));

        $budgets->withQueryString();

        $categories = Category::get();

        return view('budget.index', compact('budgets','categories'));
    }

    public function create(Request $request): Response|View
    {
         
        $categories = Category::get();

        $frequencies = collect([
            'monthly' => 'Monthly',
        ]);

        return view('budget.create', compact('categories','frequencies'));
    }

    public function store(BudgetStoreRequest $request)
    {
        $budget = Budget::create($request->validated());

        $request->session()->flash('budget.id', $budget->id);

        return redirect()->route('budgets.index');
    }

    public function show(Request $request, Budget $budget): Response|View|String
    {
        $transactions = $budget->cash_transactions();

        $input_year_month = date('Y-m');
        if( $request->get('year') && $request->get('month') ) {
            $input_year_month = $request->get('year')."-".$request->get('month');
        }

         
        $selected_year_month = Carbon::make($input_year_month);

        $transactions->when(
            $budget->frequency == 'monthly' && $selected_year_month, 
            function($transactions) use( $selected_year_month ){
                $transactions->where( 'year_month', $selected_year_month->format('Y-m') );
            }
        );

        $transactions = $transactions->paginate(50);

        $total_cash_transaction = $transactions->sum(function($transaction){
            return $transaction->cash_credit_amount - $transaction->cash_debit_amount;
        });

        $total_bank_transaction = $transactions->sum(function($transaction){
            return $transaction->bank_credit_amount - $transaction->bank_debit_amount;
        });

         
        $budget_amount_remaining = $budget->amount - abs($total_cash_transaction) - abs($total_bank_transaction);


        return view('budget.show', 
            compact(
                'budget',
                'transactions',
                'total_cash_transaction',
                'total_bank_transaction',
                'budget_amount_remaining',
                'selected_year_month'
            )
        );
    }

    public function edit(Request $request, Budget $budget): Response|View
    {
        
        $categories = Category::get();

        $frequencies = collect([
            'monthly' => 'Monthly',
        ]);

        return view('budget.edit', compact( 'categories','frequencies','budget'));
    }

    public function update(BudgetUpdateRequest $request, Budget $budget)
    {
        $budget->update($request->validated());

        //$request->session()->flash('budget.id', $budget->id);

        return redirect()->route('budgets.index');
    }

    public function destroy(Request $request, Budget $budget)
    {

        $request->validate([
            'delete-key' => 'required|in:"DELETE"'
        ]);
        
        $budget->delete();

        if( $request->wantsJson() ) {
            return response([
                'success'=> true,
                'message' => "Successfully deleted!",
                'r' =>$request->all()
            ]);
        }

        return redirect()->route('budgets.index');
    }
}
