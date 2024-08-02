@extends('layouts.newsCategory')
@section('title')
    News
@endsection

@section('content')
<h1 class="mb-4 text-4xl font-bold tracking-tight text-left text-gray-900 lg:font-extrabold lg:text-4xl lg:leading-none dark:text-white lg:text-center lg:mb-7">Photonext news</h1>

<h2 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-gray-200 lg:text-3xl lg:text-center">
    <a href="{{ route('news.index') }}" class="{{ is_null($slug) ? 'underline' : '' }}">All</a> /
    @foreach ($teams as $team)
        <a href="{{ route('team.index', ['slug' => $team->slug]) }}" class="{{ $team->slug == $slug ? 'underline' : '' }}">{{ $team->name }}</a>
        @if (!$loop->last)
            /
        @endif
    @endforeach
</h2>

@if($members->isNotEmpty())
    <div class="grid grid-cols-1 gap-6 prose max-w-none md:grid-cols-2 lg:grid-cols-3">
        @foreach ($members as $member)

            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="p-4">
                    {{-- <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-gray-100">{{ $member->team->title }}</h3> --}}
                    <a href="{{ route('people.show', ['slug' => $member->slug]) }}" class="text-blue-500 hover:underline">{{  $member->name }} {{ $member->last_name }}</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{-- $teams->links("polipeople::pagination.tailwind") --}} <!-- Questo genera i link di paginazione -->
    </div>
@else
    <p class="text-gray-600 dark:text-gray-300 lg:text-center">Nessuna membro trovato</p>
@endif
@endsection
