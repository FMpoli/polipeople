<?php

namespace Detit\Polipeople\Resources\PageResource\Blocks;

use Detit\Polipeople\Models\Team;
use Detit\Polipeople\Models\Member;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Builder\Block;

class TeamList
{
    public static function make(): Block
    {
        return Block::make('polipeople-team-list')
            ->icon('heroicon-m-users')
            ->label('Team List')
            ->preview('polipeople::blocks-previews.team-list')
            ->schema([
                Section::make('Appearance')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Enter section title'),
                        RichEditor::make('description')
                            ->label('Description')
                            ->placeholder('Enter section description')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                            ]),
                        ColorPicker::make('background_color')
                            ->label('Background Color'),
                        Toggle::make('is_overlapped')
                            ->label('Enable Overlap')
                            ->helperText(trans('polipeople::blocks.team_list.overlap_description'))
                            ->default(false),
                    ]),

                Section::make('Display Options')
                    ->schema([
                        Toggle::make('show_filters')
                            ->label('Show Team Filters')
                            ->helperText('Enable team filtering navigation')
                            ->default(true),

                        Select::make('display_mode')
                            ->label('Display Mode')
                            ->options([
                                'all' => 'All Members',
                                'team' => 'Single Team',
                                'selection' => 'Selected Members',
                            ])
                            ->default('all')
                            ->reactive(),

                        Select::make('team_id')
                            ->label('Team')
                            ->options(fn () => Team::all()->pluck('name', 'id'))
                            ->visible(fn (callable $get) => $get('display_mode') === 'team'),

                        CheckboxList::make('selected_members')
                            ->label('Select Members')
                            ->options(fn () => Member::published()->get()->pluck('full_name', 'id'))
                            ->visible(fn (callable $get) => $get('display_mode') === 'selection')
                            ->columns(2),
                    ]),
            ]);
    }
}
