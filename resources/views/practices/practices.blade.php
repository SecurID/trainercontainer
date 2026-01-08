@php use Illuminate\Support\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Practices') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('practices.create') }}" variant="primary">
                    {{ __('Create Practice') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Upcoming Practices -->
            <flux:card>
                <flux:heading size="lg" class="mb-4">{{ __('Upcoming Practices') }}</flux:heading>
                @if(count($upcomingPractices) === 0)
                    <flux:text class="text-zinc-500">{{ __("No upcoming practices.") }} {{ __('Create one by clicking on "Create Practice".') }}</flux:text>
                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>{{ __('Practice') }}</flux:table.column>
                            <flux:table.column></flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach($upcomingPractices as $practice)
                                <flux:table.row :key="$practice->id">
                                    <flux:table.cell>
                                        <flux:link href="{{ route('practices.show', $practice->id) }}">
                                            {{ Carbon::parse($practice->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                            - {{ Carbon::parse($practice->date)->format('d.m.Y') }}
                                            - {{ Carbon::parse($practice->time)->format('H:i') }} {{ __('Uhr') }}
                                            - {{ $practice->topic }}
                                        </flux:link>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex justify-end">
                                            <form action="{{ route('practices.destroy', $practice->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    type="submit"
                                                    variant="danger"
                                                    size="sm"
                                                    icon="trash"
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this practice?') }}')"
                                                />
                                            </form>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @endif
            </flux:card>

            <!-- Past Practices -->
            @if(count($pastPractices) > 0)
                <flux:accordion transition>
                    <flux:accordion.item>
                        <flux:accordion.heading>
                            <flux:heading size="lg">{{ __('Past Practices') }} ({{ count($pastPractices) }})</flux:heading>
                        </flux:accordion.heading>
                        <flux:accordion.content>
                            <div class="pt-4">
                                <flux:table>
                                    <flux:table.columns>
                                        <flux:table.column>{{ __('Practice') }}</flux:table.column>
                                        <flux:table.column></flux:table.column>
                                    </flux:table.columns>
                                    <flux:table.rows>
                                        @foreach($pastPractices as $practice)
                                            <flux:table.row :key="$practice->id">
                                                <flux:table.cell>
                                                    <flux:link href="{{ route('practices.show', $practice->id) }}">
                                                        {{ Carbon::parse($practice->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                                        - {{ Carbon::parse($practice->date)->format('d.m.Y') }}
                                                        - {{ Carbon::parse($practice->time)->format('H:i') }} {{ __('Uhr') }}
                                                        - {{ $practice->topic }}
                                                    </flux:link>
                                                </flux:table.cell>
                                                <flux:table.cell>
                                                    <div class="flex justify-end">
                                                        <form action="{{ route('practices.destroy', $practice->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <flux:button
                                                                type="submit"
                                                                variant="danger"
                                                                size="sm"
                                                                icon="trash"
                                                                onclick="return confirm('{{ __('Are you sure you want to delete this practice?') }}')"
                                                            />
                                                        </form>
                                                    </div>
                                                </flux:table.cell>
                                            </flux:table.row>
                                        @endforeach
                                    </flux:table.rows>
                                </flux:table>
                            </div>
                        </flux:accordion.content>
                    </flux:accordion.item>
                </flux:accordion>
            @endif
        </div>
    </div>
</x-app-layout>
