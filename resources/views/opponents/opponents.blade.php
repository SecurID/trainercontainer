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
            <flux:card>
                @if(count($opponents) === 0)
                    <flux:text class="text-zinc-500">{{ __("No opponents found.") }} {{ __('Create one by clicking on "Create Opponent".') }}</flux:text>
                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>{{ __('Name') }}</flux:table.column>
                            <flux:table.column>{{ __('Games') }}</flux:table.column>
                            <flux:table.column></flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach($opponents as $opponent)
                                <flux:table.row :key="$opponent->id">
                                    <flux:table.cell>
                                        <flux:link href="{{ route('opponents.show', $opponent->id) }}">
                                            {{ $opponent->name }}
                                        </flux:link>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge color="zinc" size="sm">{{ $opponent->games()->count() }}</flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex gap-2 justify-end">
                                            <flux:button href="{{ route('opponents.edit', $opponent->id) }}" variant="ghost" size="sm" icon="pencil" />
                                            <form action="{{ route('opponents.destroy', $opponent->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button
                                                    type="submit"
                                                    variant="danger"
                                                    size="sm"
                                                    icon="trash"
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this opponent?') }}')"
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
        </div>
    </div>
</x-app-layout>
