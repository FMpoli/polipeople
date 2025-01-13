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
        return view('polipeople::team.index', [
            'teams' => Team::with('members')->get(),
            'members' => Member::published()->with('teams')->get(),
            'slug' => null,
            'currentTeam' => null
        ]);
    }

    public function show($slug)
    {
        $teams = Team::with('members')->get();
        $team = $teams->first(function ($t) use ($slug) {
            return collect($t->getTranslations('slug'))->contains($slug);
        });

        return view('polipeople::team.index', [
            'teams' => $teams,
            'members' => $team ? $team->members : collect(),
            'slug' => $slug,
            'currentTeam' => $team
        ]);
    }
}
