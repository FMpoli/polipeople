@php
    $memberSlug = request()->query('member');
    $member = \Detit\Polipeople\Models\Member::where('slug', $memberSlug)->published()->first();
@endphp

<section class="prose-custom">
    <div class="{{ $isOverlapped ? 'rounded-t-xl' : '' }} {{ $isLastBlock ? 'rounded-b-xl' : '' }} px-4 py-8 mx-auto max-w-7xl md:pb-16 md:pt-20 lg:px-6"
         style="background-color: {{ $block['data']['background_color'] }}">

        @if($member)
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <!-- Header con immagine profilo -->
                    <div class="relative mb-8">
                        @if($member->avatar)
                            <x-curator-glider
                                :media="$member->avatar"
                                class="w-full h-64 object-cover rounded-xl"
                                alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                            />
                        @endif
                    </div>

                    <!-- Info principali -->
                    <div class="prose prose-lg max-w-none">
                        <h1>{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}</h1>

                        @if($member->role)
                            <h2 class="text-xl text-gray-600">
                                {{ $member->getTranslation('role', app()->getLocale()) }}
                            </h2>
                        @endif

                        @if($member->affiliation)
                            <p class="text-gray-500">
                                {{ $member->getTranslation('affiliation', app()->getLocale()) }}
                            </p>
                        @endif

                        @if($member->bio)
                            <div class="mt-8">
                                {!! $member->getTranslation('bio', app()->getLocale()) !!}
                            </div>
                        @endif

                        @if($member->links)
                            <div class="flex gap-4 mt-8">
                                @foreach($member->getTranslation('links', app()->getLocale()) as $linkId => $linkData)
                                    <a href="{{ $linkData['url'] }}"
                                       @if($linkData['is_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
                                       title="{{ $linkData['link_text'] }}">
                                        @svg('heroicon-' . Str::after($linkData['icon'], 'heroicon-'), 'w-5 h-5 mr-2')
                                        {{ $linkData['link_text'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center">
                <h2 class="text-xl text-gray-600">{{ __('Member not found') }}</h2>
            </div>
        @endif
    </div>
</section>
