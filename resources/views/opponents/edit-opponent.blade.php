<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <x-back-button></x-back-button>
            <flux:heading size="xl">{{ __('Edit Opponent') }}</flux:heading>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <form action="{{ route('opponents.update', $opponent->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <flux:field>
                            <flux:label>{{ __('Name') }}</flux:label>
                            <flux:input name="name" value="{{ old('name', $opponent->name) }}" placeholder="{{ __('Opponent name') }}" required />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:editor name="notes" label="{{ __('Notes') }}" placeholder="{{ __('Notes about the opponent') }}" :value="old('notes', $opponent->notes)" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <flux:button type="submit" variant="primary">
                            {{ __('Update Opponent') }}
                        </flux:button>
                    </div>
                </form>
            </flux:card>
        </div>
    </div>
</x-app-layout>
