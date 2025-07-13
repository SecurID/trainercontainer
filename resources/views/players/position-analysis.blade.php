<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <x-back-button></x-back-button>
            <h2 class="flex-grow text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Position Analysis') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Summary Statistics -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ __('Squad Overview') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $totalPlayers }}</div>
                            <div class="text-sm text-gray-600">{{ __('Total Players') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'critical')->count() }}
                            </div>
                            <div class="text-sm text-gray-600">{{ __('Critical Positions') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'low')->count() }}
                            </div>
                            <div class="text-sm text-gray-600">{{ __('Low Coverage') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ collect($positionAnalysis)->where('coverage_status', 'good')->count() }}
                            </div>
                            <div class="text-sm text-gray-600">{{ __('Well Covered') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Position Coverage Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Position') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Main') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Sub') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Total') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Status') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Players') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($positionAnalysis as $analysis)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="font-semibold">{{ $analysis['position']->name }}</div>
                                        <div class="text-sm text-gray-500">({{ $analysis['position']->abbreviation }})</div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 text-sm font-bold text-white bg-blue-500 rounded-full">
                                            {{ $analysis['main_count'] }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 text-sm font-bold text-white bg-gray-500 rounded-full">
                                            {{ $analysis['sub_count'] }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <span class="text-lg font-bold">{{ $analysis['total_count'] }}</span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        @php
                                            $statusConfig = [
                                                'critical' => ['bg-red-100', 'text-red-800', __('Critical')],
                                                'low' => ['bg-yellow-100', 'text-yellow-800', __('Low')],
                                                'medium' => ['bg-blue-100', 'text-blue-800', __('Medium')],
                                                'good' => ['bg-green-100', 'text-green-800', __('Good')]
                                            ];
                                            $config = $statusConfig[$analysis['coverage_status']];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded {{ $config[0] }} {{ $config[1] }}">
                                            {{ $config[2] }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <div class="space-y-1">
                                            @if($analysis['main_players']->count() > 0)
                                                <div>
                                                    <span class="text-xs font-semibold text-blue-600">{{ __('Main') }}:</span>
                                                    @foreach($analysis['main_players'] as $player)
                                                        <a href="{{ route('players.show', $player->id) }}" class="text-sm text-blue-600 hover:underline">
                                                            {{ $player->getFullname() }}
                                                        </a>
                                                        @if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if($analysis['sub_players']->count() > 0)
                                                <div>
                                                    <span class="text-xs font-semibold text-gray-600">{{ __('Sub') }}:</span>
                                                    @foreach($analysis['sub_players'] as $player)
                                                        <a href="{{ route('players.show', $player->id) }}" class="text-sm text-gray-600 hover:underline">
                                                            {{ $player->getFullname() }}
                                                        </a>
                                                        @if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            @if($analysis['total_count'] == 0)
                                                <span class="text-sm text-red-500 italic">{{ __('No players assigned') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Recommendations -->
                @php
                    $criticalPositions = collect($positionAnalysis)->where('coverage_status', 'critical');
                    $lowPositions = collect($positionAnalysis)->where('coverage_status', 'low');
                @endphp
                
                @if($criticalPositions->count() > 0 || $lowPositions->count() > 0)
                    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">{{ __('Recruitment Recommendations') }}</h3>
                        
                        @if($criticalPositions->count() > 0)
                            <div class="mb-3">
                                <h4 class="font-semibold text-red-700">{{ __('Urgent Need') }} ({{ __('No Players') }}):</h4>
                                <ul class="list-disc list-inside text-sm text-red-600">
                                    @foreach($criticalPositions as $analysis)
                                        <li>{{ $analysis['position']->name }} ({{ $analysis['position']->abbreviation }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if($lowPositions->count() > 0)
                            <div>
                                <h4 class="font-semibold text-yellow-700">{{ __('Low Coverage') }} ({{ __('Only 1 Player') }}):</h4>
                                <ul class="list-disc list-inside text-sm text-yellow-600">
                                    @foreach($lowPositions as $analysis)
                                        <li>{{ $analysis['position']->name }} ({{ $analysis['position']->abbreviation }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>