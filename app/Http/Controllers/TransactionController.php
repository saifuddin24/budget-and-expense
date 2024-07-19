<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Budget;
use App\Models\CashTransaction;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): Response|View|LengthAwarePaginator|String
    {
         
         
        $transactions = CashTransaction::query();
        $transactions = $transactions->with('category','budget');
 
        $transactions->when($request->get('category-id'), function( $transactions, $category_id ){
            $transactions->where('category_id',$category_id);
        });
        
        $transactions = $transactions->orderBy('created_at','DESC')->paginate($request->get('perPage', 15));

        $transactions->withQueryString();


        $categories = Category::get();
        $budgets = Budget::get();

        return view('transaction.index', compact('transactions','categories','budgets'));
    }

    public function create(Request $request): Response|View
    {

        $budgets = null;

        if( !$request->has('cash') && !$request->has('transaction') ) {

            $budgets = Budget::query()->orderBy('frequency','DESC')->get([
                'id',
                DB::raw('IFNULL( CONCAT(frequency,"-",title), title) as title')
            ]);
        }



        $store_route = route('transactions.store');

        return view('transaction.create', compact('budgets','store_route'));
    }

    public function store(TransactionStoreRequest $request)
    {

        Validator::validate(
            $request->only('mode','bank_withdrawal'),
            [
                'mode' => ['nullable', 'in:cash-add,transaction'],
                'bank_withdrawal' => ['nullable'],
            ]
        );

        $validated_data = $request->validated();

        switch( $request->get('mode')) {
            case 'cash-add':
                $validated_data['cash_trx_type'] = 'credit';
                if( $request->bank_withdrawal == 'on' ) {
                    $validated_data['bank_trx_type'] =  'debit';                    
                    $validated_data['bank_amount'] = $validated_data['cash_amount'];
                }
                break;
             


        }


        $transaction = Transaction::create( $validated_data );

        $request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transactions.index');
    }

    public function show(Request $request, Transaction $transaction): Response|View
    {
        return view('transaction.show', compact('transaction'));
    }

    public function edit(Request $request, Transaction $transaction): Response|View
    {
        return view('transaction.edit', compact('transaction'));
    }

    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        //$request->session()->flash('transaction.id', $transaction->id);

        return redirect()->route('transaction.index');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaction.index');
    }
}
