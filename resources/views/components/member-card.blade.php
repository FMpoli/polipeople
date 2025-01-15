@props(['member'])

<div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
    <a href="{{ '/' . ($block['data']['member_detail_page'] ?? 'member-profile') . '?member=' . $member->slug }}" class="block">
        @if($member->avatar)
            @php
                $media = \Awcodes\Curator\Models\Media::find($member->avatar);
            @endphp
            @if($media)
                <x-curator-glider
                    curation="polipeoplethumbnail"
                    :media="$media"
                    class="object-cover w-full mb-4 rounded-lg h-60"
                    alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                />
            @endif
        @endif

        <div class="text-center">
            <h3 class="mb-1 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}
            </h3>

            @if($member->role)
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{ $member->getTranslation('role', app()->getLocale()) }}
                </p>
            @endif

            @if($member->affiliation)
                <p class="mb-3 text-sm text-gray-600 dark:text-gray-500">
                    {{ $member->getTranslation('affiliation', app()->getLocale()) }}
                </p>
            @endif

            @php
                $links = $member->getTranslation('links', app()->getLocale());
            @endphp

            @if(!empty($links))
                <div class="flex items-center justify-center gap-3">
                    @foreach($links as $linkId => $linkData)
                        <a href="{{ $linkData['url'] }}"
                           @if($linkData['is_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                           class="inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-gray-100 rounded-lg hover:text-gray-900 hover:bg-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                           title="{{ $linkData['link_text'] }}">
                            @svg('heroicon-' . Str::after($linkData['icon'], 'heroicon-'), 'w-5 h-5')
                            <span class="sr-only">{{ $linkData['link_text'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </a>
</div>
