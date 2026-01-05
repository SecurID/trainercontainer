<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var string|null $locale */
        $locale = Session::get('locale', function (): ?string {
            if (Auth::check()) {
                /** @var User $user */
                $user = Auth::user();

                return $user->locale;
            }

            return null;
        });

        if (! $locale) {
            /** @var string $locale */
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        // If locale is determined by the user, ensure it's stored in the session.
        if (! Session::has('locale') && Auth::check()) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
