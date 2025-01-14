<div class="px-4 py-2">
    <div class="flex items-center gap-2">
        <x-heroicon-m-users class="w-5 h-5 text-gray-400" />
        <div class="text-sm">
            @if(!empty($block['data']['title']))
                <strong>{{ $block['data']['title'] }}</strong>
            @else
                <span class="text-gray-500">Team List Block</span>
            @endif
        </div>
    </div>
</div>
