<?php

namespace App\Providers;

use App\Models\NavMenu;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('components.app-layout', function ($view) {
            $view->with('_nav_menus', $this->nav_menu());
        });
    }

    protected function nav_menu(){

        return [
            new NavMenu([
                'title' => 'Dashboard',
                'url' => route('dashboard.index'),
                'active' => request()->routeIs('dashboard.index'),
            ]),
            new NavMenu([
                'title' => 'Budgets',
                'url' => route('budgets.index'),
                'active' => request()->routeIs('budgets.*'),
            ]),
            new NavMenu([
                'title' => 'Transactions',
                'url' => route('transactions.index'),
                'active' => request()->routeIs('transactions.*'),
            ]),
        ];

          
    }
}
