@php
    $memberSlug = request()->query('member');
    $member = \Detit\Polipeople\Models\Member::where('slug', $memberSlug)->published()->first();
@endphp

<section class="prose-custom {{ ($block['data']['overlap_previous'] ?? false) ? '-mt-80 lg:-mt-16 relative z-10' : '' }}">
    <div class="px-4 mx-auto max-w-7xl md:pb-16 lg:px-20
        {{ ($block['data']['overlap_previous'] ?? false) ? 'rounded-t-xl pt-0' : 'py-8 md:pt-20' }}
        {{ $isLastBlock ? 'rounded-b-xl' : '' }}"
        style="background-color: {{ $block['data']['background_color'] }}">
        @if($member)
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 xl:gap-0">
                <div class="lg:col-span-12">
                    <div class="flex flex-col pt-8 lg:flex-row lg:items-start lg:gap-12 lg:pt-16">
                        <!-- Colonna sinistra con foto -->
                        <div class="lg:w-1/3">
                            @if($member->avatar)
                                <div class="relative overflow-hidden rounded-lg">
                                    <x-curator-glider
                                        :media="$member->avatar"
                                        class="object-cover w-full"
                                        alt="{{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}"
                                    />
                                </div>
                            @endif
                        </div>

                        <!-- Colonna destra con informazioni -->
                        <div class="flex-1 mt-8 lg:mt-0">
                            <div class="text-left">
                                <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ $member->prefix }} {{ $member->name }} {{ $member->last_name }}
                                </h1>

                                @if($member->role)
                                    <h3 class="text-lg tracking-wider text-gray-600 uppercase dark:text-gray-400">
                                        {{ $member->getTranslation('role', app()->getLocale()) }}
                                    </h3>
                                @endif

                                @if($member->affiliation)
                                    <p class="text-lg text-gray-600 dark:text-gray-400">
                                        {{ $member->getTranslation('affiliation', app()->getLocale()) }}
                                    </p>
                                @endif
                            </div>

                            @if($member->bio)
                                <div class="mt-8 text-lg text-gray-700 dark:text-gray-300">
                                    {!! $member->getTranslation('bio', app()->getLocale()) !!}
                                </div>
                            @endif

                            <!-- Contatti -->
                            @if($member->links)
                                <div class="flex flex-wrap gap-4 mt-8">
                                    @foreach($member->getTranslation('links', app()->getLocale()) as $linkId => $linkData)
                                        <a href="{{ $linkData['url'] }}"
                                           @if($linkData['is_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                                           class="inline-flex items-center px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md text-secondary hover:bg-primary/10 hover:text-primary">
                                            @svg('heroicon-' . Str::after($linkData['icon'], 'heroicon-'), 'w-5 h-5 mr-2')
                                            {{ $linkData['link_text'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publications Section -->
            {{-- <div class="mt-16">
                <h3 class="mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Latest Selected Publications') }}
                </h3>
                <div class="space-y-8">
                    @foreach([
                        [
                            'title' => 'Real-Time 100 Gb/s PAM-4 for Access Links with up to 34 dB Power Budget',
                            'journal' => 'JOURNAL OF LIGHTWAVE TECHNOLOGY',
                            'authors' => 'Caruso, Giuseppe; Cano, Ivan N.; Nesset, Derek; Talli, Giuseppe; Gaudino, Roberto',
                            'details' => 'IEEE, Vol.41 pp.7 (pp.1-7)',
                            'doi' => '10.1109/JLT.2023.3244028'
                        ],
                        // Aggiungi qui le altre pubblicazioni...
                    ] as $publication)
                        <div class="pb-8 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <h4 class="text-xl font-medium text-gray-900 dark:text-white">{{ $publication['title'] }}</h4>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $publication['authors'] }}</p>
                            <p class="mt-1 font-medium text-primary dark:text-primary-light">{{ $publication['journal'] }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-gray-500 dark:text-gray-400">{{ $publication['details'] }}</span>
                                <a href="https://doi.org/{{ $publication['doi'] }}"
                                   target="_blank"
                                   class="text-primary hover:underline">
                                    DOI: {{ $publication['doi'] }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
        @else
            <div class="flex flex-col items-center justify-center min-h-[400px] text-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="mt-4 text-xl font-medium text-gray-600 dark:text-gray-400">
                    {{ __('Member not found') }}
                </h2>
            </div>
        @endif
    </div>
</section>
