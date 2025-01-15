@php
    // Ottieni il membro dallo slug nell'URL
    $memberSlug = request()->query('member');
    $member = \Detit\Polipeople\Models\Member::where('slug', $memberSlug)
        ->where('is_published', true)
        ->first();
@endphp

@if($member)
<div class="prose max-w-none">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Colonna sinistra con foto e info base --}}
        <div class="md:col-span-1">
            @if($member->avatar)
                @php
                    $media = \Awcodes\Curator\Models\Media::find($member->avatar);
                @endphp
                @if($media)
                    <x-curator-glider
                        :media="$media"
                        class="w-full rounded-lg shadow-lg mb-4"
                        alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                    />
                @endif
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                <h2 class="text-2xl font-bold mb-2">
                    {{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}
                </h2>
                @if($member->role)
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $member->role }}</p>
                @endif
                @if($member->affiliation)
                    <p class="text-gray-600 dark:text-gray-400">{{ $member->affiliation }}</p>
                @endif

                @if($block['data']['show_social'] && !empty($member->getTranslation('links', app()->getLocale())))
                    <div class="flex items-center gap-3 mt-4">
                        @foreach($member->getTranslation('links', app()->getLocale()) as $linkId => $linkData)
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
        </div>

        {{-- Colonna destra con bio e altri dettagli --}}
        <div class="md:col-span-2">
            @if($member->bio)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4">{{ __('polipeople::members.bio') }}</h3>
                    <div class="prose dark:prose-invert">
                        {!! $member->bio !!}
                    </div>
                </div>
            @endif

            @if(($block['data']['show_teams'] ?? true) && $member->teams && $member->teams->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold mb-4">{{ __('polipeople::members.teams') }}</h3>
                    <div class="space-y-2">
                        @foreach($member->teams as $team)
                            <div class="flex items-center gap-2">
                                <span class="text-gray-600 dark:text-gray-400">{{ $team->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@else
    <div class="text-center py-12">
        <p class="text-gray-600 dark:text-gray-400">{{ __('polipeople::messages.member_not_found') }}</p>
    </div>
@endif
