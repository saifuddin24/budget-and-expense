<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\CashTransaction;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $categories = $this->categories_query()->get();
        
        $transactions = CashTransaction::orderBy('created_at', 'DESC')->paginate(5);

        $monthly_budgets = $this->budgets_query()->frequency('monthly')->get();

        return view('dashboard.index', compact( 'transactions','categories','monthly_budgets'));
    }

    protected function categories_query(){
        $categories = Category::tableAs('c');
        $categories->leftJoin('cash_transactions AS t', 'c.id', 't.category_id');
        $categories->select( "c.*" );
        $categories->selectRaw("IFNULL( SUM( `cash_debit_amount` ), 0) as `total_cash_expense`" );
        $categories->selectRaw("IFNULL( SUM( `bank_debit_amount` ), 0) AS `total_bank_expense`" );
        return  $categories->groupBy( "c.id" );
    }

    protected function budgets_query(){
        $budgets = Budget::tableAs('b');
        $budgets->leftJoin('cash_transactions AS t', 'b.id', 't.budget_id');
        $budgets->select( "b.*" );
        $budgets->selectRaw("IFNULL( SUM( `cash_debit_amount` ), 0) as `total_cash_expense`" );
        $budgets->selectRaw("IFNULL( SUM( `bank_debit_amount` ), 0) AS `total_bank_expense`" );
        return  $budgets->groupBy( "b.id" );
    }
}
