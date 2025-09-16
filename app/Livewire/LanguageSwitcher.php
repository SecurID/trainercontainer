<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $currentLocale;

    public $availableLocales = [
        'de' => 'DE',
        'en' => 'EN',
    ];

    public function mount()
    {
        $this->currentLocale = App::getLocale();
    }

    public function switchLanguage($locale)
    {
        // Validate locale
        if (! array_key_exists($locale, $this->availableLocales)) {
            return;
        }

        // Update session
        Session::put('locale', $locale);

        // Update user preference in database if authenticated
        if (Auth::check()) {
            Auth::user()->update(['locale' => $locale]);
        }

        // Set the application locale
        App::setLocale($locale);

        // Redirect to refresh the page with new locale
        return redirect()->to(request()->header('Referer', '/'));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
