<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// переключение языка, со stackoverflow
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', 'uk');

        if (!in_array($locale, ['uk', 'en'])) {
            $locale = 'uk';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
