<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\CashTransaction;
use App\Models\Category;
use App\Models\Scopes\TransactionAccountHolderScope;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        // return 
        $year_months = Transaction::getYearMonth();

        $transactions = CashTransaction::orderBy('created_at', 'DESC')->paginate(5);
        return view('dashboard.index', compact( 'transactions','year_months'));
    }

    public function categories(Request $request ){

        $categories = $this->categories_query( $request->year_month )->get();
        return view('dashboard.categories', compact(  'categories' ));
    }
   
    public function budgets(Request $request ){

        $monthly_budgets = $this->budgets_query( $request->year_month )->get();
        return view('dashboard.monthly-budgets', compact(  'monthly_budgets' ));
    }

    public function overview(Request $request ){

        
        $transaction_revenue =   Transaction::query()->select(DB::raw("
                SUM( 
                    case 
                        when cash_trx_type = 'credit'
                        then  cash_amount  - if( bank_trx_type = 'debit' AND cash_amount > 0, bank_amount, 0)
                        ELSE 0 
                    end 
                ) AS total_cash_revenue
            "),
            DB::raw("
                SUM( 
                    case 
                        when bank_trx_type = 'credit'
                        then  bank_amount  - if( cash_trx_type = 'debit' AND bank_amount > 0, cash_amount, 0)
                        ELSE 0 
                    end 
                ) AS total_bank_revenue
            ")
        )->when($request->year_month, function($query, $year_month){

            $ex = explode('-', $year_month);
            $query->where('trx_year', $ex[0]);
            $query->where('trx_month', $ex[1]);
            
        })->first();

        
        $transaction_expenses =   Transaction::query()->select(DB::raw("
                SUM( 
                    case 
                        when cash_trx_type = 'debit'
                        then  cash_amount  - if( bank_trx_type = 'credit' AND cash_amount > 0, bank_amount, 0)
                        ELSE 0 
                    end 
                ) AS total_cash_expense
            "),
            DB::raw("
                SUM( 
                    case 
                        when bank_trx_type = 'debit'
                        then  bank_amount  - if( cash_trx_type = 'credit' AND bank_amount > 0, cash_amount, 0)
                        ELSE 0 
                    end 
                ) AS total_bank_expense
            ")
        )->when($request->year_month, function($query, $year_month){

            $ex = explode('-', $year_month);
            $query->where('trx_year', $ex[0]);
            $query->where('trx_month', $ex[1]);

        })->first();


        $total_revenue = $transaction_revenue->total_cash_revenue + $transaction_revenue->total_bank_revenue;

        $total_expense = $transaction_expenses->total_cash_expense + $transaction_expenses->total_bank_expense;

        $balance = $total_revenue - $total_expense;
        
        return view('dashboard.overview', compact(  'total_revenue', 'total_expense', 'balance' ));
    }

    protected function categories_query($year_month = null){
        $categories = Category::tableAs('c');
        // $categories->leftJoin('cash_transactions AS t', 'c.id', 't.category_id');

        $categories->leftJoin('cash_transactions AS t', function(JoinClause $categories) use($year_month) {
            $categories->on('c.id', 't.category_id');
            $categories->where( "t.account_profile_id", TransactionAccountHolderScope::getAccountProfileID() );
            
            $categories->when( $year_month, function(JoinClause $categories, $year_month ){
                $categories->where( "t.year_month",  $year_month  );
            });
        });

        $categories->select( "c.*" );
        $categories->selectRaw("IFNULL( SUM( `cash_debit_amount` ), 0) as `total_cash_expense`" );
        $categories->selectRaw("IFNULL( SUM( `bank_debit_amount` ), 0) AS `total_bank_expense`" );
        return  $categories->groupBy( "c.id" );
    }

    protected function budgets_query( $year_month = null ){
        $budgets = Budget::tableAs('b');
        
        $budgets->leftJoin('cash_transactions AS t', function($budgets) use($year_month) {
            $budgets->on('b.id', 't.budget_id');
            $budgets->where( "t.account_profile_id", TransactionAccountHolderScope::getAccountProfileID() );
            
            $budgets->when( $year_month, function( $budgets, $year_month ){
                $budgets->where("t.year_month", $year_month);
            });
        });

        $budgets->select( "b.*" );
        $budgets->selectRaw("IFNULL( SUM( `cash_debit_amount` ), 0) as `total_cash_expense`" );
        $budgets->selectRaw("IFNULL( SUM( `bank_debit_amount` ), 0) AS `total_bank_expense`" );
        return  $budgets->groupBy( "b.id" );
    }
}
