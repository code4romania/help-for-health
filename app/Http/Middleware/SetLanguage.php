<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

/**
 * Class SetLanguage
 * @package App\Http\Middleware
 */
class SetLanguage
{
    const ACCEPTED_LANGUAGES = ['ro', 'en', 'de', 'hu'];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeLocaleValue = $request->route('locale');

        if (!empty($routeLocaleValue) && in_array($routeLocaleValue, self::ACCEPTED_LANGUAGES)) {
            App::setLocale($routeLocaleValue);
        }

        URL::defaults(['locale' => app()->getLocale()]);

        return $next($request);
    }
}
