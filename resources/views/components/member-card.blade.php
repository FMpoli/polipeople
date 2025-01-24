@props(['member', 'block' => ['data' => ['member_detail_page' => '']], 'defaultDetailPage' => '', 'href' => '#'])

<div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
    <div class="flex flex-col items-center h-full gap-8 sm:flex-row">
        @if($member->avatar)
            @php
                $media = \Awcodes\Curator\Models\Media::find($member->avatar);
            @endphp
            @if($media)
                <x-curator-glider
                    curation="polipeoplethumbnail"
                    :media="$media"
                    class="flex-shrink-0 object-cover object-center w-48 h-48 rounded-lg shadow-lg"
                    alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                />
            @endif
        @endif

        <div class="flex-grow space-y-4">
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

            @if($member->links)
                <div class="flex gap-4 pt-2">
                    @foreach($member->getTranslation('links', app()->getLocale()) as $linkId => $linkData)
                        <a href="{{ $linkData['url'] }}"
                           @if($linkData['is_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                           class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary-light"
                           title="{{ $linkData['link_text'] }}">
                            @svg('heroicon-' . Str::after($linkData['icon'], 'heroicon-'), 'w-5 h-5')
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
