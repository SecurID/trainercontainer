<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Auth::user()->players()->orderBy('players.lastname')->get();

        return response()->view('players/players', ['players' => $players]);
    }

    public function create()
    {
        return response()->view('players/create-player');
    }

    public function show(Player $player)
    {
        $player->load(['mainPosition', 'subPositions']);
        
        $ratings = $player->ratings()->get()->sortBy('date');
        $labels = [];
        $ratings_array = [];
        foreach($ratings as $rating){
            $dateFormatted = $rating->practice->date->format('d.m.Y');
            $labels[] = $dateFormatted;
            $ratings_array[] = $rating->rating;
        }

        return response()->view('players/player-single', ['player' => $player, 'ratings' => $ratings, 'labels' => $labels, 'ratings_array' => $ratings_array]);
    }

    public function positionAnalysis()
    {
        $players = Auth::user()->players()->with(['mainPosition', 'subPositions'])->get();
        $positions = \App\Models\Position::all();
        
        $positionAnalysis = [];
        
        foreach ($positions as $position) {
            $mainPositionCount = $players->where('main_position_id', $position->id)->count();
            $subPositionCount = $players->filter(function ($player) use ($position) {
                return $player->subPositions->contains('id', $position->id);
            })->count();
            
            $totalCount = $mainPositionCount + $subPositionCount;
            
            $positionAnalysis[] = [
                'position' => $position,
                'main_count' => $mainPositionCount,
                'sub_count' => $subPositionCount,
                'total_count' => $totalCount,
                'coverage_status' => $this->getCoverageStatus($totalCount),
                'main_players' => $players->where('main_position_id', $position->id),
                'sub_players' => $players->filter(function ($player) use ($position) {
                    return $player->subPositions->contains('id', $position->id);
                })
            ];
        }
        
        // Sort by total count (least covered first)
        usort($positionAnalysis, function ($a, $b) {
            return $a['total_count'] <=> $b['total_count'];
        });
        
        return response()->view('players/position-analysis', [
            'positionAnalysis' => $positionAnalysis,
            'totalPlayers' => $players->count()
        ]);
    }
    
    private function getCoverageStatus($count)
    {
        if ($count == 0) return 'critical';
        if ($count == 1) return 'low';
        if ($count <= 3) return 'medium';
        return 'good';
    }
}
