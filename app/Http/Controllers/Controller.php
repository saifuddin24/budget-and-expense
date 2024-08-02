<?php

namespace App\Http\Controllers;

use App\Models\NavMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

        /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = parent::callAction($method, $parameters);

        if( $response instanceof View) {
            $response->with( '__nav_list', $this->nav_menu( ) );

            //dd( $response );
        }

        return $response;
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
