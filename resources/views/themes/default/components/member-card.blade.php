<div class="bg-white rounded-lg shadow-sm p-6">
    @if($member->avatar)
        <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="w-32 h-32 rounded-full mx-auto mb-4">
    @endif
    <h3 class="text-xl font-bold text-center mb-2">{{ $member->name }}</h3>
    @if($member->role)
        <p class="text-gray-600 text-center">{{ $member->role }}</p>
    @endif
</div>
