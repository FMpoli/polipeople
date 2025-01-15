@props(['mediaId', 'class' => '', 'alt' => ''])

@php
    $media = \Awcodes\Curator\Models\Media::find($mediaId);
@endphp

@if($media)
    <x-curator-glider
        :media="$mediaId"
        :class="$class"
        :alt="$alt"
    />
@endif
