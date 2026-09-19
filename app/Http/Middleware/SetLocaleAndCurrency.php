<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleAndCurrency
{
    public function handle(Request $request, Closure $next)
    {
        // Set Language
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale('en'); // Default Language
        }

        // Set Currency (Default BDT)
        if (!Session::has('currency')) {
            Session::put('currency', 'BDT');
        }

        return $next($request);
    }
}
