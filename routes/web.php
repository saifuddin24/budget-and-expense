<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/')->group( base_path('routes/auth.php') );

Route::get('/', [DashboardController::class,'index'])->name('dashboard.index');


Route::prefix( '/dashboard' )->group( function(){

    Route::get('/categories', [DashboardController::class,'categories'])->name('dashboard.categories');
    Route::get('/budgets', [DashboardController::class,'budgets'])->name('dashboard.budgets');
    Route::get('/overview', [DashboardController::class,'overview'])->name('dashboard.overview');
});


Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::resource('categories', App\Http\Controllers\CategoryController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('budgets', App\Http\Controllers\BudgetController::class);

Route::resource('categories.transactions', App\Http\Controllers\CategoryTransactionController::class)->except('index');

Route::resource('budgets.transactions', App\Http\Controllers\BudgetTransactionController::class)->except('index');
