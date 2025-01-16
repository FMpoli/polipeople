<?php

namespace Detit\Polipeople\Resources\PageResource\Blocks;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Builder\Block;

class MemberDetail
{
    public static function make(): Block
    {
        return Block::make('polipeople-member-detail')
            ->icon('heroicon-m-user')
            ->label('Member Detail')
            ->preview('polipeople::blocks-previews.member-detail')
            ->schema([
                Section::make('Display Options')
                    ->schema([
                        Toggle::make('show_teams')
                            ->label('Show Teams')
                            ->default(true),
                        Toggle::make('show_social')
                            ->label('Show Social Links')
                            ->default(true),
                        ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->default('#ffffff'),

                    ]),
            ]);
    }
}
