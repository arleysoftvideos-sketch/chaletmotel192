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
        $locale = null;

        // 1. Check if 'lang' query parameter is present (e.g. ?lang=en or ?lang=es)
        if ($request->has('lang')) {
            $lang = $request->query('lang');
            if (in_array($lang, ['en', 'es'])) {
                $locale = $lang;
                Session::put('locale', $lang);
                cookie()->queue('locale', $lang, 60 * 24 * 365); // 1 year
            }
        }

        // 2. If not set, check cookie
        if (!$locale) {
            $cookieLang = $request->cookie('locale');
            if (in_array($cookieLang, ['en', 'es'])) {
                $locale = $cookieLang;
            }
        }

        // 3. If not set, check session
        if (!$locale) {
            $sessionLang = Session::get('locale');
            if (in_array($sessionLang, ['en', 'es'])) {
                $locale = $sessionLang;
            }
        }

        // 4. Fallback: Automatically detect browser language
        if (!$locale) {
            $browserLang = $request->getPreferredLanguage(['es', 'en']);
            $locale = $browserLang ?: 'es';
            Session::put('locale', $locale);
            cookie()->queue('locale', $locale, 60 * 24 * 365);
        }

        // 5. Set application locale
        App::setLocale($locale);

        // Ensure session is synchronized
        if (Session::get('locale') !== $locale) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
