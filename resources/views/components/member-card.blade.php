@props(['member'])

<div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
    @if($member->avatar)
        <x-curator-curation
            curation="polipeoplethumbnail"
            :media="$member->avatar"
            class="object-cover w-full h-48 mb-4 rounded-lg"
        />
    @endif

    <div class="space-y-2">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
            {{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}
        </h3>

        @if($member->affiliation)
            <p class="text-gray-600 dark:text-gray-400">{{ $member->affiliation }}</p>
        @endif

        @if($member->role)
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->role }}</p>
        @endif

        @if($member->teams && $member->teams->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach($member->teams as $team)
                    <span class="px-2 py-1 text-xs text-gray-600 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                        {{ $team->name }}
                    </span>
                @endforeach
            </div>
        @endif

        @if($member->links)
            <div class="flex gap-4 mt-4">
                @foreach($member->links as $link)
                    <a href="{{ $link['url'] }}"
                       target="{{ $link['is_new_tab'] ? '_blank' : '_self' }}"
                       class="text-primary hover:text-primary-dark dark:text-primary-light">
                        <x-icon name="{{ $link['icon'] }}" class="w-5 h-5"/>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
