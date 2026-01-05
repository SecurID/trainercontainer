<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class LanguageSwitcher extends Component
{
    public string $currentLocale = '';

    /** @var array<string, string> */
    public array $availableLocales = [
        'de' => 'DE',
        'en' => 'EN',
    ];

    public function mount(): void
    {
        $this->currentLocale = App::getLocale();
    }

    public function switchLanguage(string $locale): RedirectResponse|Redirector|null
    {
        // Validate locale
        if (! array_key_exists($locale, $this->availableLocales)) {
            return null;
        }

        // Update session
        Session::put('locale', $locale);

        // Update user preference in database if authenticated
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $user->update(['locale' => $locale]);
        }

        // Set the application locale
        App::setLocale($locale);

        // Redirect to refresh the page with new locale
        return redirect()->to(url()->previous('/'));
    }

    public function render(): View
    {
        return view('livewire.language-switcher');
    }
}
