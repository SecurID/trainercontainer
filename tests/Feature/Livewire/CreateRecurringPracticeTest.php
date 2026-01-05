<?php

use App\Livewire\CreateRecurringPractice;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders create recurring practice component', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->assertStatus(200);
});

it('requires start date', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->set('end_date', now()->addWeek()->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create')
        ->assertHasErrors(['start_date']);
});

it('requires end date', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', now()->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create')
        ->assertHasErrors(['end_date']);
});

it('requires end date to be after or equal to start date', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', now()->format('Y-m-d'))
        ->set('end_date', now()->subDay()->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create')
        ->assertHasErrors(['end_date']);
});

it('requires at least one weekday', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', now()->format('Y-m-d'))
        ->set('end_date', now()->addWeek()->format('Y-m-d'))
        ->set('weekdays', [])
        ->set('time', '18:00')
        ->call('create')
        ->assertHasErrors(['weekdays']);
});

it('requires time', function () {
    $this->actingAs($this->user);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', now()->format('Y-m-d'))
        ->set('end_date', now()->addWeek()->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->call('create')
        ->assertHasErrors(['time']);
});

it('creates practices for matching weekdays', function () {
    $this->actingAs($this->user);

    // Find next Monday
    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addWeeks(2);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1']) // Monday
        ->set('time', '18:00')
        ->call('create');

    // Should create 3 practices (start day + 2 weeks)
    expect(Practice::where('user_id', $this->user->id)->count())->toBe(3);
});

it('creates practices with correct topic', function () {
    $this->actingAs($this->user);

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1']) // Monday
        ->set('time', '18:00')
        ->call('create');

    $practice = Practice::where('user_id', $this->user->id)->first();
    expect($practice->topic)->toBe('Training');
});

it('creates practices with correct time', function () {
    $this->actingAs($this->user);

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1']) // Monday
        ->set('time', '19:30')
        ->call('create');

    $practice = Practice::where('user_id', $this->user->id)->first();
    expect($practice->time)->toBe('19:30');
});

it('creates practices for multiple weekdays', function () {
    $this->actingAs($this->user);

    // One full week
    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1', '3', '5']) // Monday, Wednesday, Friday
        ->set('time', '18:00')
        ->call('create');

    expect(Practice::where('user_id', $this->user->id)->count())->toBe(3);
});

it('sets success flag after creating practices', function () {
    $this->actingAs($this->user);

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    $component = Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create');

    expect($component->get('success'))->toBeTrue();
});

it('resets form after creating practices', function () {
    $this->actingAs($this->user);

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    $component = Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create');

    expect($component->get('start_date'))->toBeNull();
    expect($component->get('end_date'))->toBeNull();
    expect($component->get('weekdays'))->toBe([]);
    expect($component->get('time'))->toBeNull();
});

it('redirects to practices index after creating', function () {
    $this->actingAs($this->user);

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create')
        ->assertRedirect(route('practices.index'));
});

it('associates practices with authenticated user', function () {
    $this->actingAs($this->user);
    $otherUser = User::factory()->create();

    $startDate = now()->startOfWeek();
    $endDate = $startDate->copy()->addDays(6);

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $startDate->format('Y-m-d'))
        ->set('end_date', $endDate->format('Y-m-d'))
        ->set('weekdays', ['1'])
        ->set('time', '18:00')
        ->call('create');

    expect(Practice::where('user_id', $this->user->id)->count())->toBe(1);
    expect(Practice::where('user_id', $otherUser->id)->count())->toBe(0);
});

it('handles same start and end date', function () {
    $this->actingAs($this->user);

    // Find next Monday and use as both start and end
    $monday = now()->startOfWeek();

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $monday->format('Y-m-d'))
        ->set('end_date', $monday->format('Y-m-d'))
        ->set('weekdays', ['1']) // Monday
        ->set('time', '18:00')
        ->call('create');

    expect(Practice::where('user_id', $this->user->id)->count())->toBe(1);
});

it('creates no practices when weekday not in range', function () {
    $this->actingAs($this->user);

    // Tuesday and Wednesday only
    $tuesday = now()->startOfWeek()->addDay();
    $wednesday = $tuesday->copy()->addDay();

    Livewire::test(CreateRecurringPractice::class)
        ->set('start_date', $tuesday->format('Y-m-d'))
        ->set('end_date', $wednesday->format('Y-m-d'))
        ->set('weekdays', ['1']) // Monday - not in range
        ->set('time', '18:00')
        ->call('create');

    expect(Practice::where('user_id', $this->user->id)->count())->toBe(0);
});
