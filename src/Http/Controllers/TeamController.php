<?php

namespace Detit\Polipeople\Http\Controllers;

use Detit\Polipeople\Models\Team;
use Illuminate\Routing\Controller;
use Detit\Polipeople\Models\Member;

class TeamController extends Controller
{
    public function index($slug = null)
    {
        $teams = Team::all();

        if ($slug) {
            $team = Team::where('slug->' . App()->getLocale(), $slug)->firstOrFail();

            $members = $team->members()->with('teams')->paginate(9);
        } else {
            $members = Member::published()->with('teams')->paginate(9);
        }

        return view('polipeople::team.index', compact('members', 'teams', 'slug'));
    }
}
