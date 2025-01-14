<section class="prose-custom">
    <div
        class="{{ $isOverlapped ? 'rounded-t-xl' : '' }} {{ $isLastBlock ? 'rounded-b-xl' : '' }} px-4 py-8 mx-auto max-w-7xl md:pb-16 md:pt-20 lg:px-6" style="background-color: {{ $block['data']['background_color'] }}">
        @if(!empty($block['data']['title']))
            <h1>{{ $block['data']['title'] }}</h1>
        @endif

        @if(!empty($block['data']['description']))
            <h3>
                {!! $block['data']['description'] !!}
            </h3>
        @endif

        @php
            $teams = \Detit\Polipeople\Models\Team::with('members')->get();

            // Gestione dei membri in base al display_mode
            switch($block['data']['display_mode'] ?? 'all') {
                case 'team':
                    $selectedTeam = $teams->find($block['data']['team_id']);
                    $members = $selectedTeam ? $selectedTeam->members()->published()->get() : collect();
                    break;

                case 'selection':
                    $selectedIds = $block['data']['selected_members'] ?? [];
                    $members = \Detit\Polipeople\Models\Member::published()
                        ->whereIn('id', $selectedIds)
                        ->with('teams')
                        ->get();
                    break;

                default: // 'all'
                    $selectedTeamSlug = request()->query('team');
                    if ($selectedTeamSlug) {
                        $currentTeam = $teams->first(function ($team) use ($selectedTeamSlug) {
                            return collect($team->getTranslations('slug'))->contains($selectedTeamSlug);
                        });
                        $members = $currentTeam ? $currentTeam->members : collect();
                    } else {
                        $currentTeam = null;
                        $members = \Detit\Polipeople\Models\Member::published()->with('teams')->get();
                    }
                    break;
            }

            // Ottieni tutti i blocchi della pagina
            //$pageBlocks = $page->content ?? [];

            // Trova l'indice del blocco corrente usando il tipo e i dati
            //$currentIndex = collect($pageBlocks)->search(function($pageBlock) use ($block) {
            //    return $pageBlock['type'] === 'polipeople-team-list' &&
            //           $pageBlock['data'] === $block['data'];
            //});

            // È l'ultimo blocco se è l'ultimo nell'array
            //$isLastBlock = $currentIndex === count($pageBlocks) - 1;


        @endphp

        <x-polipeople::team-list
            :teams="$teams"
            :members="$members"
            :currentTeam="$currentTeam ?? null"
            :slug="$selectedTeamSlug ?? null"
            :showFilters="$block['data']['show_filters'] ?? true"
        />
    </div>
</section>
