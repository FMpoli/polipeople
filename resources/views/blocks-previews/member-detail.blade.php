<div class="px-4 py-3">
    <div class="flex items-center gap-4">
        <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
            @svg('heroicon-m-user', 'w-6 h-6 text-gray-500')
        </div>
        <div>
            <h3 class="text-base font-medium text-gray-900">
                Member Detail Block
            </h3>
            <p class="text-sm text-gray-500">
                Displays detailed information about a team member
            </p>
        </div>
    </div>
    <div class="mt-2 space-y-1 text-sm text-gray-500">
        @if($block['data']['show_teams'] ?? true)
            <div class="flex items-center gap-1">
                @svg('heroicon-m-check-circle', 'w-4 h-4 text-green-500')
                Show Teams
            </div>
        @endif
        @if($block['data']['show_social'] ?? true)
            <div class="flex items-center gap-1">
                @svg('heroicon-m-check-circle', 'w-4 h-4 text-green-500')
                Show Social Links
            </div>
        @endif
        @if($block['data']['show_publications'] ?? true)
            <div class="flex items-center gap-1">
                @svg('heroicon-m-check-circle', 'w-4 h-4 text-green-500')
                Show Publications
            </div>
        @endif
    </div>
</div>
