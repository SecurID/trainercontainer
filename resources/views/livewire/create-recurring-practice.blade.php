<div>
    <form wire:submit.prevent="create">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <flux:field>
                        <flux:label>Startdatum</flux:label>
                        <flux:date-picker wire:model="start_date" />
                        <flux:error name="start_date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Enddatum</flux:label>
                        <flux:date-picker wire:model="end_date" />
                        <flux:error name="end_date" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <flux:field>
                        <flux:label>Wochentage</flux:label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <flux:checkbox wire:model="weekdays" value="1" label="Montag" />
                            <flux:checkbox wire:model="weekdays" value="2" label="Dienstag" />
                            <flux:checkbox wire:model="weekdays" value="3" label="Mittwoch" />
                            <flux:checkbox wire:model="weekdays" value="4" label="Donnerstag" />
                            <flux:checkbox wire:model="weekdays" value="5" label="Freitag" />
                            <flux:checkbox wire:model="weekdays" value="6" label="Samstag" />
                            <flux:checkbox wire:model="weekdays" value="7" label="Sonntag" />
                        </div>
                        <flux:error name="weekdays" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Uhrzeit</flux:label>
                        <flux:time-picker wire:model="time" />
                        <flux:error name="time" />
                    </flux:field>
                </div>

                <div class="flex justify-end mt-4">
                    <flux:button type="submit" variant="primary">
                        Erstellen
                    </flux:button>
                </div>

                @if($success)
                    <div class="mt-4 text-green-600 font-semibold">Trainingseinheiten wurden erfolgreich erstellt!</div>
                @endif
            </div>
        </div>
    </form>
</div>
