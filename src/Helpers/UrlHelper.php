<?php

namespace Detit\Polipeople\Helpers;

use Detit\Polipeople\Models\Team;

class UrlHelper
{
    public static function getLocalizedTeamUrl($currentSlug, $targetLocale)
    {
        if (!$currentSlug) {
            return route('teams');
        }

        $team = Team::all()->first(function ($team) use ($currentSlug) {
            return collect($team->getTranslations('slug'))->contains($currentSlug);
        });

        if (!$team) {
            return route('teams');
        }

        return route('teams.show', $team->getTranslation('slug', $targetLocale));
    }
}
