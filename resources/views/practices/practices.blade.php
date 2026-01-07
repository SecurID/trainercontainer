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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(count($practices) === 0)
                    <flux:text>{{ __("No practices found.") }} {{ __('Create one by clicking on "Create Practice".') }}</flux:text>
                @else
                    <table class="w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="pb-2 text-left">{{ __('Choose a Practice to view') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($practices as $practice)
                            <tr class="border-b">
                                <td class="py-2">
                                    <flux:link href="{{ route('practices.show', $practice->id) }}">
                                        {{ Carbon::parse($practice->date)->locale(app()->getLocale())->translatedFormat('l') }}
                                        - {{ Carbon::parse($practice->date)->format('d.m.Y') }}
                                        - {{ Carbon::parse($practice->time)->format('H:i') }} {{ __('Uhr') }}
                                        - {{ $practice->topic }}
                                    </flux:link>
                                </td>
                                <td class="py-2">
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
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
