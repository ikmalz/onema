<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App; // Tambahkan ini
use Illuminate\Support\Facades\Session; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah ada 'language' dalam session
        $language = Session::get('language', config('app.locale'));
        App::setLocale($language);

        return $next($request);
    }
}
