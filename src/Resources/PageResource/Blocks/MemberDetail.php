<?php

namespace Detit\Polipeople\Resources\PageResource\Blocks;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Toggle;

class MemberDetail
{
    public static function make(): Block
    {
        return Block::make('polipeople-member-detail')
            ->label('Member Detail')
            ->icon('heroicon-m-user')
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

                    ]),
            ]);
    }
}
