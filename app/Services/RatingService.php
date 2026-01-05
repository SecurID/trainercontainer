<?php

namespace App\Services;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    /**
     * Load existing ratings for a practice or game and return organized data.
     *
     * @param  Collection<int, \App\Models\Player>  $players
     * @return array{ratings: array<int, int|null>, attendances: array<int, bool>}
     */
    public function loadRatingsForPlayers(Collection $players, ?int $practiceId, ?int $gameId): array
    {
        $playerIds = $players->pluck('id')->toArray();

        $query = Rating::query()->whereIn('player_id', $playerIds);

        if ($practiceId !== null) {
            $query->where('practice_id', $practiceId);
        } elseif ($gameId !== null) {
            $query->where('game_id', $gameId);
        }

        $existingRatings = $query->get()->keyBy('player_id');

        $ratings = [];
        $attendances = [];

        foreach ($players as $player) {
            $rating = $existingRatings->get($player->id);
            $ratings[$player->id] = $rating?->rating;
            $attendances[$player->id] = $rating?->attended === false;
        }

        return [
            'ratings' => $ratings,
            'attendances' => $attendances,
        ];
    }

    /**
     * Save ratings for players to a practice or game.
     *
     * @param  Collection<int, \App\Models\Player>  $players
     * @param  array<int, int|null>  $ratings
     * @param  array<int, bool>  $attendances
     */
    public function saveRatings(
        Collection $players,
        array $ratings,
        array $attendances,
        ?int $practiceId,
        ?int $gameId
    ): void {
        foreach ($players as $player) {
            $ratingValue = $ratings[$player->id] ?? null;
            $attended = $attendances[$player->id] ?? false;

            if ($attended === true) {
                $attended = false;
                $ratingValue = null;
            } else {
                $attended = true;
            }

            $attributes = [
                'player_id' => $player->id,
                'user_id' => Auth::id(),
            ];

            if ($practiceId !== null) {
                $attributes['practice_id'] = $practiceId;
            } elseif ($gameId !== null) {
                $attributes['game_id'] = $gameId;
            }

            Rating::updateOrCreate(
                $attributes,
                [
                    'rating' => $ratingValue,
                    'attended' => $attended,
                ]
            );
        }
    }
}
