<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_if(! in_array($locale, ['en', 'nl']), 404);

        session(['locale' => $locale]);

        return back();
    }
}
