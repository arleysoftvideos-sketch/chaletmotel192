<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Check if 'lang' query parameter is present (e.g. ?lang=en or ?lang=es)
        if ($request->has('lang')) {
            $lang = $request->query('lang');
            if (in_array($lang, ['en', 'es'])) {
                Session::put('locale', $lang);
            }
        }

        // 2. Retrieve locale from session
        $locale = Session::get('locale');

        // 3. Fallback: Automatically detect browser language
        if (!$locale) {
            $browserLang = $request->getPreferredLanguage(['es', 'en']);
            $locale = $browserLang ?: 'es';
            Session::put('locale', $locale);
        }

        // 4. Set application locale
        App::setLocale($locale);

        return $next($request);
    }
}
