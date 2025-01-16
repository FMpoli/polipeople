<?php

namespace Detit\Polipeople\Resources\PageResource\Blocks;

use Base33\Pages\Models\Page;
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
                            ]),
                        ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->default('#ffffff'),
                    ]),

                Section::make('Display Options')
                    ->schema([
                        Toggle::make('show_filters')
                            ->label('Show Filters')
                            ->default(true),

                        Select::make('member_detail_page')
                            ->label('Member Detail Page')
                            ->options(function() {
                                return Page::where('is_published', true)
                                    ->where('content', 'like', '%member-detail%')
                                    ->get()
                                    ->mapWithKeys(function ($page) {
                                        $cleanSlug = preg_replace('/^[a-z]{2}-/', '', $page->slug);
                                        return [$cleanSlug => $page->title . ' (' . strtoupper($page->language) . ')'];
                                    });
                            })
                            ->helperText('Select the page that will display member details')
                            ->required(),

                        Grid::make(2)
                            ->schema([
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
                    ]),
            ]);
    }
}
