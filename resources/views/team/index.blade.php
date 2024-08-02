@extends('layouts.people')
@section('title')
    People
@endsection

@section('content')
<div class="mb-8 text-center">
    <h1 class="mb-4 text-4xl font-bold tracking-tight text-left text-gray-900 lg:font-extrabold lg:text-4xl lg:leading-none dark:text-white lg:text-center lg:mb-7">Our team</h1>
    <p class="mt-4 text-lg prose prose-xl text-gray-600 max-w-none prose-max-">
        We’re a dynamic group of individuals who are passionate about what we do and dedicated to delivering the best results for our clients.
    </p>
</div>
<h2 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-gray-200 lg:text-3xl lg:text-center">
    <div class="flex justify-center space-x-4">
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
</h2>

@if($members->isNotEmpty())

<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
    @if($members && $members->isNotEmpty())
        @foreach ($members as $member)
            <!-- Team Member -->
            <div class="p-6 bg-white">
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
                        <div class="flex mt-4 space-x-4 border-l-4 border-gray-700 justify-left margin-x-4">
                            @foreach($member->links as $link)
                            <a href="{{  $link['url'] }}" class="text-gray-600 hover:text-gray-900">
                                <x-icon name="{{ $link['icon'] }}" class="flex-shrink-0 w-6 h-6 ml-2"/>
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
    <p class="text-gray-600 dark:text-gray-300 lg:text-center">Nessuna membro trovato</p>
@endif
@endsection
