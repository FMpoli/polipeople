<?php

namespace Detit\Polipeople\Resources\PageResource\Blocks;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Builder\Block;

class MemberProfile
{
    public static function make(): Block
    {
        return Block::make('polipeople-member-profile')
            ->icon('heroicon-m-user')
            ->label('Member Profile')
            ->schema([
                Section::make('Appearance')
                    ->schema([
                        ColorPicker::make('background_color')
                            ->label('Background Color'),
                    ]),
            ]);
    }
}
