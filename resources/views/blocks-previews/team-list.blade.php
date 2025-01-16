<div class="p-4">
    <div class="flex items-center gap-4">
        <div class="flex-shrink-0">
            @svg('heroicon-m-users', 'w-6 h-6 text-gray-500')
        </div>
        <div class="flex-grow">
            <h3 class="text-base font-medium text-gray-900">
                {{ $block['data']['title'] ?? 'Team List' }}
            </h3>
            @if(!empty($block['data']['description']))
                <p class="mt-1 text-sm text-gray-500">
                    {!! Str::limit(strip_tags($block['data']['description']), 100) !!}
                </p>
            @endif
            <div class="mt-2 text-xs text-gray-500">
                <span class="font-medium">Display Mode:</span>
                {{ ucfirst($block['data']['display_mode'] ?? 'all') }}
                @if(($block['data']['display_mode'] ?? 'all') === 'team' && !empty($block['data']['team_id']))
                    - Team ID: {{ $block['data']['team_id'] }}
                @endif
            </div>
            @if(!empty($block['data']['member_detail_page']))
                <div class="mt-1 text-xs text-gray-500">
                    <span class="font-medium">Detail Page:</span>
                    {{ $block['data']['member_detail_page'] }}
                </div>
            @endif
        </div>
        <div class="flex-shrink-0">
            <div class="w-4 h-4 rounded" style="background-color: {{ $block['data']['background_color'] ?? '#ffffff' }}"></div>
        </div>
    </div>
</div>
