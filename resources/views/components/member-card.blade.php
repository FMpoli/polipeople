@props(['member', 'block' => [], 'href' => '#'])

<div class="relative overflow-hidden transition-all duration-300 bg-white shadow-md group dark:bg-gray-800 rounded-xl hover:shadow-lg">
    {{-- Immagine con overlay al hover --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-200 dark:bg-gray-700">
        @if($member->avatar)
        @php
            $media = \Awcodes\Curator\Models\Media::find($member->avatar);
        @endphp
        <x-curator-glider
            curation="polipeoplehumbnail"
            :media="$media"
            class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
            alt="{{ $member->full_name }}"
        />
            <div class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gradient-to-t from-black/60 to-transparent group-hover:opacity-100"></div>
        @else
            <div class="flex items-center justify-center w-full h-full">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        @endif
    </div>

    {{-- Contenuto --}}
    <div class="p-6">
        {{-- Nome completo e Ruolo --}}
        <div class="mb-4">
            <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                {{ $member->full_name }}
            </h3>
            @if($member->position)
                <p class="text-sm font-medium text-primary">
                    {{ $member->position }}
                </p>
            @endif
            @if($member->role)
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $member->getTranslation('role', app()->getLocale()) }}
                </p>
            @endif
        </div>

        {{-- Bio breve se disponibile --}}
        @if($member->bio)
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                    {{ $member->getTranslation('bio', app()->getLocale()) }}
                </p>
            </div>
        @endif

        {{-- Teams --}}
        @if($member->teams && $member->teams->isNotEmpty())
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($member->teams as $team)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                            {{ $team->getTranslation('name', app()->getLocale()) }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Contatti --}}
        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
            @if($member->email)
                <a href="mailto:{{ $member->email }}" class="flex items-center gap-1 transition-colors hover:text-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Email</span>
                </a>
            @endif
            @if($member->phone)
                <a href="tel:{{ $member->phone }}" class="flex items-center gap-1 transition-colors hover:text-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>Phone</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Link overlay --}}
    @if($href && $href !== '#')
        <a href="{{ $href }}" class="absolute inset-0 z-10" aria-label="View {{ $member->full_name }}'s details"></a>
    @endif
</div>
