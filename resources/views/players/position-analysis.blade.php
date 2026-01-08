<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button></x-back-button>
            <flux:heading size="xl">{{ __('Position Analysis') }}</flux:heading>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <flux:card>
                <!-- Summary Statistics -->
                <div class="mb-8">
                    <flux:heading size="lg" class="mb-4">{{ __('Squad Overview') }}</flux:heading>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <flux:card class="text-center">
                            <flux:heading size="xl" class="text-primary-600">{{ $totalPlayers }}</flux:heading>
                            <flux:text size="sm">{{ __('Total Players') }}</flux:text>
                        </flux:card>
                        <flux:card class="text-center">
                            <flux:heading size="xl" class="text-red-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'critical')->count() }}
                            </flux:heading>
                            <flux:text size="sm">{{ __('Critical Positions') }}</flux:text>
                        </flux:card>
                        <flux:card class="text-center">
                            <flux:heading size="xl" class="text-amber-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'low')->count() }}
                            </flux:heading>
                            <flux:text size="sm">{{ __('Low Coverage') }}</flux:text>
                        </flux:card>
                        <flux:card class="text-center">
                            <flux:heading size="xl" class="text-green-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'good')->count() }}
                            </flux:heading>
                            <flux:text size="sm">{{ __('Well Covered') }}</flux:text>
                        </flux:card>
                    </div>
                </div>

                <!-- Position Coverage Table -->
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>{{ __('Position') }}</flux:table.column>
                        <flux:table.column class="text-center">{{ __('Main') }}</flux:table.column>
                        <flux:table.column class="text-center">{{ __('Sub') }}</flux:table.column>
                        <flux:table.column class="text-center">{{ __('Total') }}</flux:table.column>
                        <flux:table.column class="text-center">{{ __('Status') }}</flux:table.column>
                        <flux:table.column>{{ __('Players') }}</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach($positionAnalysis as $analysis)
                            <flux:table.row>
                                <flux:table.cell>
                                    <flux:heading size="sm">{{ $analysis['position']->name }}</flux:heading>
                                    <flux:text size="sm">({{ $analysis['position']->abbreviation }})</flux:text>
                                </flux:table.cell>
                                <flux:table.cell class="text-center">
                                    <flux:badge color="blue" size="sm">{{ $analysis['main_count'] }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="text-center">
                                    <flux:badge color="zinc" size="sm">{{ $analysis['sub_count'] }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="text-center">
                                    <flux:heading size="lg">{{ $analysis['total_count'] }}</flux:heading>
                                </flux:table.cell>
                                <flux:table.cell class="text-center">
                                    @php
                                        $statusConfig = [
                                            'critical' => ['red', __('Critical')],
                                            'low' => ['amber', __('Low')],
                                            'medium' => ['blue', __('Medium')],
                                            'good' => ['green', __('Good')]
                                        ];
                                        $config = $statusConfig[$analysis['coverage_status']];
                                    @endphp
                                    <flux:badge color="{{ $config[0] }}" size="sm">{{ $config[1] }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div class="space-y-1">
                                        @if($analysis['main_players']->count() > 0)
                                            <div>
                                                <flux:text size="sm" class="font-semibold text-blue-600">{{ __('Main') }}:</flux:text>
                                                @foreach($analysis['main_players'] as $player)
                                                    <flux:link href="{{ route('players.show', $player->id) }}" class="text-sm">
                                                        {{ $player->getFullname() }}
                                                    </flux:link>
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($analysis['sub_players']->count() > 0)
                                            <div>
                                                <flux:text size="sm" class="font-semibold text-zinc-600">{{ __('Sub') }}:</flux:text>
                                                @foreach($analysis['sub_players'] as $player)
                                                    <flux:link href="{{ route('players.show', $player->id) }}" variant="subtle" class="text-sm">
                                                        {{ $player->getFullname() }}
                                                    </flux:link>
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($analysis['total_count'] == 0)
                                            <flux:text size="sm" class="text-red-500 italic">{{ __('No players assigned') }}</flux:text>
                                        @endif
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>

                <!-- Recommendations -->
                @php
                    $criticalPositions = collect($positionAnalysis)->where('coverage_status', 'critical');
                    $lowPositions = collect($positionAnalysis)->where('coverage_status', 'low');
                @endphp

                @if($criticalPositions->count() > 0 || $lowPositions->count() > 0)
                    <flux:callout icon="exclamation-triangle" class="mt-6">
                        <flux:callout.heading>{{ __('Recruitment Recommendations') }}</flux:callout.heading>
                        <flux:callout.text>
                            @if($criticalPositions->count() > 0)
                                <div class="mb-3">
                                    <flux:text class="font-semibold text-red-700">{{ __('Urgent Need') }} ({{ __('No Players') }}):</flux:text>
                                    <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                                        @foreach($criticalPositions as $analysis)
                                            <li>{{ $analysis['position']->name }} ({{ $analysis['position']->abbreviation }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if($lowPositions->count() > 0)
                                <div>
                                    <flux:text class="font-semibold text-amber-700">{{ __('Low Coverage') }} ({{ __('Only 1 Player') }}):</flux:text>
                                    <ul class="list-disc list-inside text-sm text-amber-600 mt-1">
                                        @foreach($lowPositions as $analysis)
                                            <li>{{ $analysis['position']->name }} ({{ $analysis['position']->abbreviation }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </flux:callout.text>
                    </flux:callout>
                @endif
            </flux:card>
        </div>
    </div>
</x-app-layout>
