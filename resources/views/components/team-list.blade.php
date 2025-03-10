@props(['slug' => null, 'teams', 'members', 'currentTeam' => null, 'showFilters' => true, 'block' => null])

@php

$routePrefix = Route::has('teams') ? '' : 'polipeople.';
    $routeName = $routePrefix . 'teams';
    $routeShowName = $routePrefix . 'teams.show';
@endphp

<section class="px-3 prose-custom lg:p-0 left-title">
    <div class="grid px-4 py-8 mx-auto lg:px-20 max-w-7xl lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
        <div class="col-span-12">
            {{-- Team Navigation --}}
            @if($showFilters)
                <div class="mb-8">
                    <nav class="flex flex-wrap justify-center gap-4">
                        <a href="{{ url()->current() }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md text-secondary hover:bg-primary/10 hover:text-primary {{ is_null($slug) ? 'bg-primary/10 text-primary' : '' }}">
                            {{ __('polipeople::polipeople.all_teams') }}
                        </a>

                        @foreach($teams as $team)
                            <a href="{{ url()->current() }}?team={{ $team->getTranslation('slug', app()->getLocale()) }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md text-secondary hover:bg-primary/10 hover:text-primary {{ $team->is($currentTeam) ? 'bg-primary/10 text-primary' : '' }}">
                                {{ $team->getTranslation('name', app()->getLocale()) }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            @endif

            @if($currentTeam)
                <div class="mb-8 text-center">
                    <p>{{ $currentTeam->getTranslation('description', app()->getLocale()) }}</p>
                </div>
            @endif

            @if($members->isNotEmpty())
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-2">
                    @foreach($members as $member)
                        @php
                            $url = !empty($block['data']['member_detail_page'])
                                ? '/' . $block['data']['member_detail_page'] . '?member=' . $member->slug
                                : '#';

                            // Salva i parametri query in sessione quando clicchiamo sul link
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
    </div>
</section>
