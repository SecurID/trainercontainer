<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = Session::get('locale', function () {
            return Auth::check() ? Auth::user()->locale : null;
        });

        if (!$locale) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        // If locale is determined by the user, ensure it's stored in the session.
        if (!Session::has('locale') && Auth::check()) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
