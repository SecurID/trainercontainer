<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class LanguageSwitcher extends Component
{
    /** @var array<string, string> */
    private const LOCALES = [
        'de' => 'DE',
        'en' => 'EN',
    ];

    public string $currentLocale = '';

    public function mount(): void
    {
        $this->currentLocale = App::getLocale();
    }

    /**
     * Server-authoritative locale map. Exposed as a computed property so it is
     * never carried in the Livewire snapshot, preventing stale client payloads
     * from rehydrating it into an inconsistent state.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function availableLocales(): array
    {
        return self::LOCALES;
    }

    public function switchLanguage(string $locale): RedirectResponse|Redirector|null
    {
        // Validate locale
        if (! array_key_exists($locale, self::LOCALES)) {
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
