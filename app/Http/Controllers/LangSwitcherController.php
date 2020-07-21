<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* fbsg-signature-addLocaleENTH:<begin> */
use Session;
use Redirect;
/* fbsg-signature-addLocaleENTH:<end> */

class LangSwitcherController extends Controller
{
    //
    /* fbsg-signature-addLocaleENTH:<begin> */
    public function switchLang($lang)
    {
        if (array_key_exists($lang, config('app.languages'))) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }
    /* fbsg-signature-addLocaleENTH:<end> */
}
