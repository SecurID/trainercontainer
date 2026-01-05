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

it('starts collapsed by default', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice]);

    expect($component->get('isCollapsed'))->toBeTrue();
});

it('can toggle collapse state', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('toggleCollapse');

    expect($component->get('isCollapsed'))->toBeFalse();

    $component->call('toggleCollapse');

    expect($component->get('isCollapsed'))->toBeTrue();
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
    expect($component->get('scheduleRows.0.exercise_id'))->toBe($exercise->id);
    expect($component->get('scheduleRows.0.playerCount'))->toBe(10);
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

it('searches exercises by name', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Passing Drill',
    ]);
    Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Shooting Exercise',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('updateExerciseSearch', 0, 'Passing');

    expect($component->get('availableExercises.0'))->toHaveCount(1);
    expect($component->get('showExerciseDropdowns.0'))->toBeTrue();
});

it('searches exercises by focus', function () {
    $this->actingAs($this->user);
    Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Exercise',
        'focus' => 'Dribbling',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('updateExerciseSearch', 0, 'Dribbling');

    expect($component->get('availableExercises.0'))->toHaveCount(1);
});

it('hides dropdown when search term is empty', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('updateExerciseSearch', 0, '');

    expect($component->get('showExerciseDropdowns.0'))->toBeFalse();
});

it('can select an exercise', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Selected Exercise',
        'playerCount' => 12,
        'duration' => '20',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('selectExercise', 0, $exercise->id);

    expect($component->get('scheduleRows.0.exercise_id'))->toBe($exercise->id);
    expect($component->get('scheduleRows.0.exercise_name'))->toBe('Selected Exercise');
    expect($component->get('exerciseSearchTerms.0'))->toBe('Selected Exercise');
});

it('pre-fills player count from exercise', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'playerCount' => 8,
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('selectExercise', 0, $exercise->id);

    expect($component->get('scheduleRows.0.playerCount'))->toBe(8);
});

it('pre-fills time from exercise duration', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create([
        'user_id' => $this->user->id,
        'duration' => '25',
    ]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('selectExercise', 0, $exercise->id);

    // Duration could be string or int depending on database
    expect((string) $component->get('scheduleRows.0.time'))->toBe('25');
});

it('hides dropdown after selecting exercise', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('showExerciseDropdowns.0', true)
        ->call('selectExercise', 0, $exercise->id);

    expect($component->get('showExerciseDropdowns.0'))->toBeFalse();
});

it('can hide exercise dropdown', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('showExerciseDropdowns.0', true)
        ->call('hideExerciseDropdown', 0);

    expect($component->get('showExerciseDropdowns.0'))->toBeFalse();
});

it('shows exercises when dropdown focused', function () {
    $this->actingAs($this->user);
    Exercise::factory()->count(3)->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('showExerciseDropdown', 0);

    expect($component->get('availableExercises.0'))->toHaveCount(3);
    expect($component->get('showExerciseDropdowns.0'))->toBeTrue();
});

it('saves new schedule row', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', $exercise->id)
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
        ->set('scheduleRows.0.exercise_id', $exercise->id)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('shows error when time is missing', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->call('saveScheduleRow', 0);

    expect($component->get('successMessage'))->toContain('Fehler');
});

it('shows success message after save', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0);

    // Auto-save triggers on set, so it might be "Neu gespeichert!" or "Aktualisiert!"
    expect(in_array($component->get('successMessage'), ['Neu gespeichert!', 'Aktualisiert!']))->toBeTrue();
});

it('dispatches success message event', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', $exercise->id)
        ->set('scheduleRows.0.playerCount', 10)
        ->set('scheduleRows.0.time', '15')
        ->call('saveScheduleRow', 0)
        ->assertDispatched('success-message');
});

it('auto-saves on schedule row field update', function () {
    $this->actingAs($this->user);
    $exercise = Exercise::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->set('scheduleRows.0.exercise_id', $exercise->id)
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

it('handles non-existent exercise gracefully', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(PracticeScheduleBuilder::class, ['practice' => $this->practice])
        ->call('selectExercise', 0, 99999);

    expect($component->get('scheduleRows.0.exercise_id'))->toBeNull();
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
