@extends('polipeople::layouts.team')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="mb-8 text-center">
            <h1 class="mb-4 text-4xl font-bold">{{ __('polipeople::polipeople.people_title') }}</h1>
        </div>

        <div class="mb-8">
            <nav class="flex flex-wrap justify-center gap-4">
                @if(Route::has('teams'))
                    {{-- Se il tema è attivo, usa le sue route --}}
                    <a href="{{ route('teams') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ is_null($slug) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ __('polipeople::polipeople.all_teams') }}
                    </a>

                    @foreach($teams as $team)
                        <a href="{{ route('teams.show', $team->getTranslation('slug', app()->getLocale())) }}"
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ isset($currentTeam) && $team->is($currentTeam) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $team->getTranslation('name', app()->getLocale()) }}
                        </a>
                    @endforeach
                @else
                    {{-- Altrimenti usa le route del plugin --}}
                    <a href="{{ route('polipeople.teams.index') }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ is_null($slug) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ __('polipeople::polipeople.all_teams') }}
                    </a>

                    @foreach($teams as $team)
                        <a href="{{ route('polipeople.teams.show', $team->getTranslation('slug', app()->getLocale())) }}"
                           class="px-4 py-2 text-sm font-medium rounded-lg {{ isset($currentTeam) && $team->is($currentTeam) ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $team->getTranslation('name', app()->getLocale()) }}
                        </a>
                    @endforeach
                @endif
            </nav>
        </div>

        @if(isset($currentTeam))
            <div class="mb-8 prose prose-lg max-w-none">
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
            <p class="text-center text-gray-600">
                {{ __('polipeople::polipeople.no_members') }}
            </p>
        @endif
    </div>
@endsection
