<?php

namespace Detit\Polipeople\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Detit\Polipeople\Models\Team;

class LocalizeTeamUrls
{
    protected function getAvailableLocales(): array
    {
        $locales = json_decode(env('APP_AVAILABLE_LOCALES', '{"en":"English"}'), true);
        return array_keys($locales);
    }

    protected function getRouteNames(): array
    {
        $locales = $this->getAvailableLocales();
        $baseNames = ['teams', 'teams.show'];
        $names = $baseNames;

        foreach ($locales as $locale) {
            if ($locale !== 'en') {
                $names[] = "teams.{$locale}";
                $names[] = "teams.show.{$locale}";
            }
        }

        return $names;
    }

    protected function getLocalizedPrefix(string $currentLocale): string
    {
        return __('polipeople::routes.teams', [], $currentLocale);
    }

    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();
        if (!in_array($routeName, $this->getRouteNames())) {
            return $next($request);
        }

        $currentLocale = app()->getLocale();
        $currentPath = trim($request->path(), '/');
        $segments = explode('/', $currentPath);
        $needsRedirect = false;

        // Ottieni tutti i prefissi possibili dalle traduzioni
        $allPrefixes = collect($this->getAvailableLocales())->mapWithKeys(function ($locale) {
            return [$this->getLocalizedPrefix($locale) => $locale];
        });

        // Se il segmento corrente è un prefisso conosciuto ma non nella lingua corretta
        if (isset($segments[0]) && $allPrefixes->has($segments[0])) {
            $currentPrefix = $this->getLocalizedPrefix($currentLocale);
            if ($segments[0] !== $currentPrefix) {
                $segments[0] = $currentPrefix;
                $needsRedirect = true;
            }
        }

        // Se c'è uno slug, verifica che sia nella lingua corretta
        if (isset($segments[1])) {
            $team = Team::all()->first(function ($team) use ($segments) {
                return collect($team->getTranslations('slug'))->contains($segments[1]);
            });

            if ($team && $team->hasTranslation('slug', $currentLocale)) {
                $localizedSlug = $team->getTranslation('slug', $currentLocale);
                if ($localizedSlug !== $segments[1]) {
                    $segments[1] = $localizedSlug;
                    $needsRedirect = true;
                }
            }
        }

        // Reindirizza solo se necessario
        if ($needsRedirect) {
            return redirect()->to(implode('/', $segments));
        }

        return $next($request);
    }
}
