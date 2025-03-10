<?php

namespace Detit\Polipeople\Http\Controllers;

use Detit\Polipeople\Models\Team;
use Illuminate\Routing\Controller;
use Detit\Polipeople\Models\Member;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('sort_order', 'asc')->get();
        return view('polipeople::teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $teams = Team::orderBy('sort_order', 'asc')->get();
        return view('polipeople::teams.show', compact('team', 'teams'));
    }
}
