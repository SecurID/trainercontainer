It shou<?php

use App\Livewire\LanguageSwitcher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Log out the default user that TestCase creates
    Auth::logout();
    $this->user = User::factory()->create(['locale' => 'de']);
});

it('shows current language in the switcher', function () {
    $this->actingAs($this->user);

    Livewire::test(LanguageSwitcher::class)
        ->assertSet('currentLocale', 'de')
        ->assertSee('DE');
});

it('switches language for authenticated user', function () {
    $this->actingAs($this->user);

    Livewire::test(LanguageSwitcher::class)
        ->call('switchLanguage', 'en')
        ->assertRedirect();

    // Check that user's locale was updated in database
    expect($this->user->fresh()->locale)->toBe('en')
        ->and(session('locale'))->toBe('en');
});

it('switches language for guest user using session', function () {
    Livewire::test(LanguageSwitcher::class)
        ->assertSet('currentLocale', 'de') // Default locale
        ->call('switchLanguage', 'en')
        ->assertRedirect();

    // Check that session has the new locale
    expect(session('locale'))->toBe('en');
});

it('validates locale before switching', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(LanguageSwitcher::class);

    // Try to switch to an invalid locale
    $component->call('switchLanguage', 'invalid');

    // User's locale should remain unchanged
    expect($this->user->fresh()->locale)->toBe('de');
});

it('displays available languages', function () {
    $this->actingAs($this->user);

    Livewire::test(LanguageSwitcher::class)
        ->assertSee('DE')
        ->assertSee('EN');
});

it('highlights current language', function () {
    $this->actingAs($this->user);

    App::setLocale('en');

    Livewire::test(LanguageSwitcher::class)
        ->assertSet('currentLocale', 'en')
        ->assertSee('EN');
});
