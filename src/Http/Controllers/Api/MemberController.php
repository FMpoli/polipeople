<?php

namespace Detit\Polipeople\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Detit\Polipeople\Models\Member;

class MemberController extends Controller
{
    public function show(Member $member)
    {
        if (!$member->is_published) {
            abort(404);
        }

        return response()->json([
            'id' => $member->id,
            'prefix' => $member->prefix,
            'name' => $member->name,
            'last_name' => $member->last_name,
            'role' => $member->getTranslation('role', app()->getLocale()),
            'affiliation' => $member->getTranslation('affiliation', app()->getLocale()),
            'bio' => $member->getTranslation('bio', app()->getLocale()),
            'avatar' => $member->avatar,
            'links' => $member->getTranslation('links', app()->getLocale()),
            'teams' => $member->teams->map(fn($team) => [
                'name' => $team->getTranslation('name', app()->getLocale()),
                'slug' => $team->slug,
            ]),
        ]);
    }
}
