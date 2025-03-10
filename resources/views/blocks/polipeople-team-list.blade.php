<section class="prose-custom {{ ($block['data']['overlap_previous'] ?? false) ? '-mt-80 lg:-mt-16 relative z-10' : '' }}">
    <div class="px-4 mx-auto max-w-7xl md:pb-16 lg:px-6
        {{ ($block['data']['overlap_previous'] ?? false) ? 'rounded-t-xl pt-0' : 'py-8 md:pt-20' }}
        {{ $isLastBlock ? 'rounded-b-xl' : '' }}"
        style="background-color: {{ $block['data']['background_color'] }}">
        @if(!empty($block['data']['title']))
            <h1>{{ $block['data']['title'] }}</h1>
        @endif

        @if(!empty($block['data']['description']))
            <h3>
                {!! $block['data']['description'] !!}
            </h3>
        @endif

        @php
            $teams = \Detit\Polipeople\Models\Team::with('members')
                ->orderBy('sort_order', 'asc')
                ->get();

            // Gestione dei membri in base al display_mode
            switch($block['data']['display_mode'] ?? 'all') {
                case 'team':
                    $selectedTeam = $teams->find($block['data']['team_id']);
                    $members = $selectedTeam ? $selectedTeam->members()
                        ->published()
                        ->orderBy('sort_order', 'asc')
                        ->get() : collect();
                    break;

                case 'selection':
                    $selectedIds = $block['data']['selected_members'] ?? [];
                    $members = \Detit\Polipeople\Models\Member::published()
                        ->whereIn('id', $selectedIds)
                        ->with('teams')
                        ->orderBy('sort_order', 'asc')
                        ->get();
                    break;

                default: // 'all'
                    $selectedTeamSlug = request()->query('team');
                    if ($selectedTeamSlug) {
                        $currentTeam = $teams->first(function ($team) use ($selectedTeamSlug) {
                            return collect($team->getTranslations('slug'))->contains($selectedTeamSlug);
                        });
                        $members = $currentTeam ? $currentTeam->members()
                            ->orderBy('sort_order', 'asc')
                            ->get() : collect();
                    } else {
                        $currentTeam = null;
                        $members = \Detit\Polipeople\Models\Member::published()
                            ->with('teams')
                            ->orderBy('sort_order', 'asc')
                            ->get();
                    }
                    break;
            }

        @endphp

        <x-polipeople::team-list
            :teams="$teams"
            :members="$members"
            :currentTeam="$currentTeam ?? null"
            :slug="$selectedTeamSlug ?? null"
            :showFilters="$block['data']['show_filters'] ?? true"
            :block="$block"
        />
    </div>
</section>
