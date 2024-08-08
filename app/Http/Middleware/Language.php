<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLangDB = "tr";

        $lang = app()->getLocale();

        if ($lang != $defaultLangDB) {
            app()->setLocale($defaultLangDB);
        }

        return $next($request);
    }
}
