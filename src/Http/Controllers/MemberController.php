<?php

namespace Detit\Polipeople\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Detit\Polipeople\Models\Member;

class MemberController extends Controller
{
    public function show($slug)
    {
        Log::info('MemberController@show: Accessed with slug: ' . $slug);
        $member = Member::where("slug", $slug)->firstOrFail();
        return view('polipeople::member.show', compact('member'));
    }

}
