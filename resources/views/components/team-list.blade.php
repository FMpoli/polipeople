@props(['slug' => null, 'teams', 'members', 'currentTeam' => null])

@php
    $routePrefix = Route::has('teams') ? '' : 'polipeople.';
    $routeName = $routePrefix . 'teams';
    $routeShowName = $routePrefix . 'teams.show';
@endphp

<div class="prose-custom">
    <div class="mb-8 text-center">
        <h1 class="mb-4 text-4xl font-bold tracking-tight text-gray-900 lg:font-extrabold lg:text-4xl lg:leading-none dark:text-white">
            @if(is_null($currentTeam))
                {{ __('polipeople::polipeople.people_title') }}
            @else
                {{ $currentTeam->getTranslation('name', app()->getLocale()) }}
            @endif
        </h1>
    </div>

    {{-- Team Navigation --}}
    <div class="mb-8">
        <nav class="flex flex-wrap justify-center gap-4">
            <a href="{{ route($routeName) }}"
               class="px-4 py-2 text-sm font-medium rounded-lg {{ is_null($slug) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ __('polipeople::polipeople.all_teams') }}
            </a>

            @foreach($teams as $team)
                <a href="{{ route($routeShowName, $team->getTranslation('slug', app()->getLocale())) }}"
                   class="px-4 py-2 text-sm font-medium rounded-lg {{ $team->is($currentTeam) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $team->getTranslation('name', app()->getLocale()) }}
                </a>
            @endforeach
        </nav>
    </div>

    @if($currentTeam)
        <div class="mb-8 prose prose-lg max-w-none dark:prose-invert">
            <p>{{ $currentTeam->getTranslation('description', app()->getLocale()) }}</p>
        </div>
    @endif

    @if($members->isNotEmpty())
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($members as $member)
                <x-polipeople::member-card :member="$member" />
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">
            {{ __('polipeople::polipeople.no_members') }}
        </p>
    @endif
</div>
