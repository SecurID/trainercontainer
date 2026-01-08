<?php

use App\Livewire\PracticeScheduleBuilder;
use App\Models\Exercise;
use App\Models\Practice;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->practice = Practice::factory()->create(['user_id' => $this->user->id]);
});

it('renders practice schedule builder component', function () {
    $this->actingAs($this->user);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->assertStatus(200);
});

it('initializes with one empty row when no schedules exist', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice]);

    expect($component->get('scheduleRows'))->toHaveCount(1);
});

it('loads existing schedules on mount', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    Schedule::factory()->create([
        'practice_id' => $this->practice->id,
        'exercise_id' => $exercise->id,
        'playerCount' => 10,
        'time' => '15',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice]);

    expect($component->get('scheduleRows'))->toHaveCount(1);
    expect($component->get('scheduleRows.0.exercise_id'))->toBe((string) $exercise->id);
    expect($component->get('scheduleRows.0.playerCount'))->toBe(10);
});

it('loads all exercises on mount', function () {
    $this->actingAs($this->user);
    Exercise::factory()->count(3)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice]);

    expect($component->get('exercises'))->toHaveCount(3);
});

it('can add a new row', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('addRow');

    expect($component->get('scheduleRows'))->toHaveCount(2);
});

it('can remove a row without persisted schedule', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('addRow')
        ->call('removeRow', 1);

    expect($component->get('scheduleRows'))->toHaveCount(1);
});

it('deletes schedule when removing persisted row', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $schedule = Schedule::factory()->create([
        'practice_id' => $this->practice->id,
        'exercise_id' => $exercise->id,
    ]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('removeRow', 0);

    expect(Schedule::find($schedule->id))->toBeNull();
});

it('saves new schedule row', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    $this->assertDatabaseHas('schedules', [
        'practice_id' => $this->practice->id,
        'exercise_id' => $exercise->id,
        'playerCount' => 10,
        'time' => '15',
    ]);
});

it('updates existing schedule row', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);
    $schedule = Schedule::factory()->create([
        'practice_id' => $this->practice->id,
        'exercise_id' => $exercise->id,
        'playerCount' => 5,
    ]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.playerCount', 15)
        ->call('saveScheduleRow', 0);

    $this->assertDatabaseHas('schedules', [
        'id' => $schedule->id,
        'playerCount' => 15,
    ]);
});

it('shows error when exercise is missing', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('shows error when player count is missing', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('shows error when time is missing', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->call('saveScheduleRow', 0);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('shows success message after save', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    expect(in_array($component->get('successMessage'), ['Neu gespeichert!', 'Aktualisiert!']))->toBeTrue();
});

it('dispatches success message event', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0)
        ->assertDispatched('success-message');
});

it('auto-saves on schedule row field update', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', (string) $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '20');

    $this->assertDatabaseHas('schedules', [
        'practice_id' => $this->practice->id,
        'time' => '20',
    ]);
});

it('does not create schedule when row index is invalid', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('saveScheduleRow', 99);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('reindexes arrays after removing row', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('addRow')
        ->call('addRow')
        ->call('removeRow', 1);

    $rows = $component->get('scheduleRows');
    expect(array_keys($rows))->toBe([0, 1]);
});

it('selects exercise and auto-fills defaults', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Exercise',
        'playerCount' => 12,
        'goalkeeperCount' => 2,
        'duration' => '20',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('selectExercise', 0, $exercise->id);

    expect($component->get('scheduleRows.0.exercise_id'))->toBe((string) $exercise->id);
    expect($component->get('exerciseSearchTerms.0'))->toBe('Test Exercise');
    expect($component->get('scheduleRows.0.playerCount'))->toBe(12);
    expect($component->get('scheduleRows.0.goalkeeperCount'))->toBe(2);
    expect((string) $component->get('scheduleRows.0.time'))->toBe('20');
});

it('loads exercise name in search term on mount', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Existing Exercise',
    ]);
    Schedule::factory()->create([
        'practice_id' => $this->practice->id,
        'exercise_id' => $exercise->id,
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice]);

    expect($component->get('exerciseSearchTerms.0'))->toBe('Existing Exercise');
});

it('filters exercises by search term', function () {
    $this->actingAs($this->user);
    Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Passing Drill',
    ]);
    Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Shooting Exercise',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('exerciseSearchTerms.0', 'Passing');

    $filtered = $component->instance()->getFilteredExercises(0);
    expect($filtered)->toHaveCount(1);
    expect($filtered->first()->name)->toBe('Passing Drill');
});

