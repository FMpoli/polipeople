<div class="p-6 bg-white rounded-lg shadow-sm">
    @if($member->avatar)
        <x-curator-curation
            :media="$member->avatar"
            curation="polipeoplethumbnail"
            loading="lazy"
            class="object-cover w-32 h-32 mx-auto mb-4 rounded-full"
            alt="{{ $member->name }}"
        />
    @endif

    @if ($member->avatar->hasCuration('polipeoplethumbnail'))
        <x-curator-curation :media="$member->avatar" curation="polipeoplethumbnail"/>
    @else
        <x-curator-glider
            class="object-cover w-auto"
            :media="$member->avatar"
            :width="$preset->getWidth()"
            :height="$preset->getHeight()"
        />
    @endif

    <h3 class="mb-2 text-xl font-bold text-center">{{ $member->name }}</h3>
    @if($member->role)
        <p class="text-center text-gray-600">{{ $member->role }}</p>
    @endif
</div>
