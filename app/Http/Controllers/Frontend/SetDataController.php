<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetDataController extends Controller
{
    public function switchLanguage($lang)
    {
        if (in_array($lang, ['en', 'bn'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        }
        return redirect()->back();
    }

    public function switchCurrency($currency)
    {
        if (in_array($currency, ['BDT', 'USD'])) {
            Session::put('currency', $currency);
        }
        return redirect()->back();
    }
}
