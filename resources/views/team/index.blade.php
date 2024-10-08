@extends('layouts.people')
@section('title')
    People
@endsection

@section('content')
<div class="mb-8 text-center" x-cloak>
    <h1 class="mb-4 text-4xl font-bold tracking-tight text-left text-gray-900 uppercase lg:font-extrabold lg:text-4xl lg:leading-none dark:text-white lg:text-center lg:mb-7">
        {{-- @if(is_null($slug)) --}}
            {{ __('polipeople::polipeople.people_title') }}
        {{-- @else
        {{ __('polipeople::polipeople.people_title') }}<br/><small>{{ $teams->firstWhere('slug', $slug)->name ?? __('polipeople::polipeople.people_title') }}</small>

        @endif --}}
    </h1>
</div>
<h2 x-data="{ isOpen: false }" class="mb-4 text-2xl font-semibold text-gray-800 dark:text-gray-200 lg:text-3xl lg:text-center">
    <!-- Pulsanti visibili solo su schermi grandi -->
    <div class="justify-center hidden mb-4 space-x-4 lg:flex">
        <a href="{{ route('team.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium
                  {{ is_null($slug) ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            All
        </a>

        @foreach ($teams as $team)
            <a href="{{ route('team.show', ['slug' => $team->slug]) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
                      {{ $team->slug == $slug ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                {{ $team->name }}
            </a>
        @endforeach
    </div>

    <!-- Icona Hamburger visibile solo su dispositivi mobili -->
    <div class="flex justify-end lg:hidden">
        <button @click="isOpen = !isOpen" class="text-gray-800 dark:text-gray-200 focus:outline-none">
            <!-- Icona Hamburger -->
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Menu a comparsa -->
    <div x-show="isOpen" @click.away="isOpen = false" class="absolute w-48 mt-2 bg-white rounded-lg shadow-lg lg:hidden dark:bg-gray-800 right-4">
        <a href="{{ route('team.index') }}"
           class="block px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 {{ is_null($slug) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
            All
        </a>
        @foreach ($teams as $team)
            <a href="{{ route('team.show', ['slug' => $team->slug]) }}"
               class="block px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 {{ $team->slug == $slug ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                {{ $team->name }}
            </a>
        @endforeach
    </div>
</h2>
@if($teams->firstWhere('slug', $slug))
    <h1 class="mt-8 mb-4 text-xl text-4xl font-bold tracking-tight text-left text-gray-900 uppercase lg:font-extrabold lg:text-2xl lg:leading-none dark:text-white lg:text-left">{{ $teams->firstWhere('slug', $slug)->name }}</h1>

    <p class="mt-4 text-lg prose prose-xl text-gray-600 !max-w-none py-4">
            {{ $teams->firstWhere('slug', $slug)->description }}
    </p>
@endif
@if($members->isNotEmpty())

<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
    @if($members && $members->isNotEmpty())
        @foreach ($members as $member)
            <!-- Team Member -->
            <div class="bg-white lg:mt-8">
                <x-curator-curation curation="polipeoplethumbnail" loading="lazy" :media="$member->avatar" class="mt-0 mb-2 rounded-xl"/>
                <div class="text-left">
                    <h3 class="text-xl font-bold text-gray-900">{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}</h3>
                    <p class="text-gray-600">{{ $member->affiliation }}</p>
                    <p class="text-gray-600">
                        @if($member->teams && $member->teams->isNotEmpty())
                            @foreach ($member->teams as $team)
                                {{ $team->name }}{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        @endif
                        @if($member->links)
                            <div class="flex justify-center mt-4 space-x-8">
                                @foreach($member->links as $link)
                                <a href="{{ $link['url'] }}" target="{{ $link['is_new_tab'] ? '_blank' : '' }}" class="flex flex-col items-center text-gray-600 hover:text-gray-900">
                                    <x-icon name="{{ $link['icon'] }}" class="w-6 h-6 mb-1"/>
                                    <span class="text-center">{{ $link['link_text'] }}</span>
                                </a>
                                @endforeach
                            </div>
                        @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
<div class="mt-6">
    {{-- $teams->links("polipeople::pagination.tailwind") --}} <!-- Questo genera i link di paginazione -->
</div>
@else
    <p class="text-gray-600 dark:text-gray-300 lg:text-center">{{ __('polipeople::polipeople.no_results') }}</p>
@endif
@endsection
