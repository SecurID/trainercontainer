<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex sm:space-y-2 justify-between items-center block">
            <flux:heading size="xl">
                {{ __('Opponents') }}
            </flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('opponents.create') }}" variant="primary">
                    {{ __('Create Opponent') }}
                </flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(count($opponents) === 0)
                    <flux:text>{{ __("No opponents found.") }} {{ __('Create one by clicking on "Create Opponent".') }}</flux:text>
                @else
                    <table class="w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="pb-2 text-left">{{ __('Name') }}</th>
                            <th class="pb-2 text-left">{{ __('Games') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($opponents as $opponent)
                            <tr class="border-b">
                                <td class="py-2">
                                    <flux:link href="{{ route('opponents.show', $opponent->id) }}">
                                        {{ $opponent->name }}
                                    </flux:link>
                                </td>
                                <td class="py-2">
                                    {{ $opponent->games()->count() }}
                                </td>
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('opponents.edit', $opponent->id) }}" size="sm">
                                            {{ __('Edit') }}
                                        </flux:button>
                                        <form action="{{ route('opponents.destroy', $opponent->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button
                                                type="submit"
                                                variant="danger"
                                                size="sm"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this opponent?') }}')"
                                            >
                                                {{ __('Delete') }}
                                            </flux:button>
                                        </form>
                                    </div>
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
