<?php

namespace App\Filament\Resources\MemberResource;

use Filament\Forms\Components\Toggle;

class MemberResource
{
    public static function getBlockSchema(): array
    {
        return [
            // ... altre configurazioni ...
            Toggle::make('is_overlapped')
                ->label('Overlap with previous block')
                ->default(false)
                ->visible(fn ($get) => $get('type') === 'polipeople-member-detail'),
        ];
    }
}
