<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <x-back-button></x-back-button>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3"
                     x-data="{ playerName: '{{ $player->getFullname() }}' }"
                     x-on:player-name-updated.window="playerName = $event.detail.name">
                    <flux:heading size="xl" x-text="playerName"></flux:heading>
                    <flux:modal.trigger name="edit-player-name">
                        <flux:button variant="subtle" size="sm" icon="pencil">
                            {{ __('Edit Name') }}
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <livewire:delete-player :player="$player" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                        <livewire:player-details :player="$player" />
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/3 p-4">
                        <flux:heading class="mb-4">{{ __('Performance Over Time') }}</flux:heading>
                        @php
                            $chartData = collect($labels)->zip($ratings_array)->map(fn($item) => [
                                'date' => $item[0],
                                'rating' => $item[1],
                            ])->toArray();
                        @endphp
                        @if(count($chartData) > 0)
                            <div x-data="{ chartData: @js($chartData) }">
                                <flux:chart x-model="chartData" class="aspect-[3/1]">
                                    <flux:chart.svg>
                                        <flux:chart.line field="rating" class="text-teal-500" />
                                        <flux:chart.point field="rating" class="text-teal-600" />
                                        <flux:chart.axis axis="x" field="date" />
                                        <flux:chart.axis axis="y" :max="5" :min="1" />
                                    </flux:chart.svg>

                                    <flux:chart.tooltip>
                                        <flux:chart.tooltip.heading field="date" />
                                        <flux:chart.tooltip.value field="rating" label="{{ __('Rating') }}" />
                                    </flux:chart.tooltip>
                                </flux:chart>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-3 text-sm text-zinc-600">
                                <span><span class="inline-block w-3 h-3 rounded-full bg-red-400 mr-1"></span>1 = {{ __('very bad') }} (--)</span>
                                <span><span class="inline-block w-3 h-3 rounded-full bg-orange-400 mr-1"></span>2 = {{ __('bad') }} (-)</span>
                                <span><span class="inline-block w-3 h-3 rounded-full bg-yellow-400 mr-1"></span>3 = {{ __('normal') }} (o)</span>
                                <span><span class="inline-block w-3 h-3 rounded-full bg-lime-400 mr-1"></span>4 = {{ __('good') }} (+)</span>
                                <span><span class="inline-block w-3 h-3 rounded-full bg-green-400 mr-1"></span>5 = {{ __('very good') }} (++)</span>
                            </div>
                        @else
                            <div class="flex items-center justify-center h-48 bg-zinc-50 rounded-lg">
                                <flux:text class="text-zinc-400">{{ __('No ratings available yet') }}</flux:text>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
