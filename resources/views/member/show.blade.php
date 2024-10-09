@extends('polipeople::layouts.member')
@section('title')
    {{ $member->name }} {{ $member->last_name }}
@endsection

@php
    $media = $member->avatar;
    $rmedia = is_array($media) ? reset($media) : $media;
    $mediaValue = is_array($media) ? $rmedia['id']: $media;
@endphp

@section('content')
<article class="prose max-w-none">
        <h1 class="mb-4 text-4xl font-bold tracking-tight text-left text-gray-900 lg:font-extrabold lg:text-4xl lg:leading-none dark:text-white lg:text-center lg:mb-7">{{ $member->name }} {{ $member->last_name }}</h1>

        @if(filled($member->avatar))
         <div class="w-full mb-6 aspect-video"><x-curator-glider :media="$mediaValue" class=""/> </div>
        @endif
        <div class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-xl">{!! $member->bio !!}</div>
    </article>
@endsection
