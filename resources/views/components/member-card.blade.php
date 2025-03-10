@props(['member', 'block' => ['data' => ['member_detail_page' => '']], 'defaultDetailPage' => '', 'href' => '#'])

<div class="h-full p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
    <div class="flex flex-col items-center h-full gap-8 sm:flex-row">
        @if($member->avatar)
            @php
                $media = \Awcodes\Curator\Models\Media::find($member->avatar);
            @endphp
            @if($media)
                <x-curator-glider
                    curation="polipeoplethumbnail"
                    :media="$media"
                    class="flex-shrink-0 object-cover object-center w-40 h-40 rounded-lg shadow-lg sm:w-48 sm:h-48"
                    alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                />
            @endif
        @endif

        <div class="flex flex-col justify-between flex-grow">
            <div class="space-y-3">
                <a href="{{ $href }}"
                   data-member="{{ $member->slug }}"
                   data-preserve-params="member"
                   class="member-link">
                    <h2 class="text-gray-900 dark:text-white">
                        {{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}
                    </h2>
                </a>

                @if($member->role)
                    <h3 class="text-primary dark:text-primary-light">
                        {{ $member->getTranslation('role', app()->getLocale()) }}
                    </h3>
                @endif

                @if($member->affiliation)
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $member->getTranslation('affiliation', app()->getLocale()) }}
                    </p>
                @endif
            </div>

            @if($member->links)
                <div class="flex flex-wrap gap-3 pt-4">
                    @foreach($member->getTranslation('links', app()->getLocale()) as $linkId => $linkData)
                    <a href="{{ $linkData['url'] }}"
                        @if($linkData['is_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                        class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md text-secondary hover:bg-primary/10 hover:text-primary">
                        @svg('heroicon-' . Str::after($linkData['icon'], 'heroicon-'), 'w-4 h-4 mr-1.5 flex-shrink-0')
                        <span class="truncate">{{ $linkData['link_text'] }}</span>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
