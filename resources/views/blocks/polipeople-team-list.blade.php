<section class="prose-custom {{ ($block['data']['overlap_previous'] ?? false) ? '-mt-80 lg:-mt-16 relative z-10' : '' }}">
    <div class="px-4 mx-auto max-w-7xl md:pb-16 lg:px-6
        {{ ($block['data']['overlap_previous'] ?? false) ? 'rounded-t-xl pt-0' : 'py-8 md:pt-20' }}
        {{ $isLastBlock ? 'rounded-b-xl' : '' }}"
        style="background-color: {{ $block['data']['background_color'] ?? '#ffffff' }}">
        @if(!empty($block['data']['title']))
            <h1>{{ $block['data']['title'] }}</h1>
        @endif

        @if(!empty($block['data']['description']))
            <h3 class="{{ empty($block['data']['title']) ? 'pt-8' : '' }}">
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
                        ->with('teams')
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
                            ->with('teams')
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

            $showFilters = ($block['data']['show_filters'] ?? true) && $teams->count() > 0;
        @endphp

        @if($showFilters)
            <div class="mb-8 {{ empty($block['data']['title']) && empty($block['data']['description']) ? 'pt-8' : 'mt-8' }}">
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ url()->current() }}"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md {{ is_null($selectedTeamSlug) ? 'bg-primary/10 text-primary' : 'text-secondary hover:bg-primary/10 hover:text-primary' }}">
                        {{ __('polipeople::polipeople.all_teams') }}
                    </a>

                    @foreach($teams as $team)
                        <a href="{{ url()->current() }}?team={{ $team->getTranslation('slug', app()->getLocale()) }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md {{ $team->is($currentTeam) ? 'bg-primary/10 text-primary' : 'text-secondary hover:bg-primary/10 hover:text-primary' }}">
                            {{ $team->getTranslation('name', app()->getLocale()) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($currentTeam)
            <div class="mb-8 text-center">
                <p>{{ $currentTeam->getTranslation('description', app()->getLocale()) }}</p>
            </div>
        @endif

        @if($members->isNotEmpty())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($members as $member)
                    @php
                        $url = !empty($block['data']['member_detail_page'])
                            ? '/' . $block['data']['member_detail_page'] . '?member=' . $member->slug
                            : '#';

                        Session::put('member_params', 'member=' . $member->slug);
                    @endphp

                    <x-polipeople::member-card
                        :member="$member"
                        :block="$block"
                        :href="$url"
                    />
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600 dark:text-gray-400">
                {{ __('polipeople::polipeople.no_members') }}
            </p>
        @endif
    </div>
</section>
