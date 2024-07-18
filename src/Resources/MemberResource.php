<?php

namespace Detit\Polipeople\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Detit\Polipeople\Models\Team;
use Detit\Polipeople\Models\Member;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Concerns\Translatable;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Detit\Polipeople\Resources\MemberResource\Pages;

class MemberResource extends Resource
{
    use Translatable;
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'People';

    protected static ?string $modelLabel = 'Member';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('members.member'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('members.name'))
                                ->required()
                                ->live(debounce: 500)
                                ->autocapitalize('words')
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                    $name = $state;
                                    $lastName = $get('last_name');
                                    $slug = Str::slug($name . ' ' . $lastName);
                                    $set('slug', $slug);
                                })
                                ->maxLength(255),

                            TextInput::make('last_name')
                                ->label(__('members.last_name'))
                                ->required()
                                ->live(debounce: 500)
                                ->autocapitalize('words')
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                    $name = $get('name');
                                    $lastName = $state;
                                    $slug = Str::slug($name . ' ' . $lastName);
                                    $set('slug', $slug);
                                })
                                ->maxLength(255),
                            Forms\Components\TextInput::make('slug')
                                ->label(__('members.slug'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('bio')
                                ->label(__('members.bio'))
                                ->columnSpanFull(),

                            Forms\Components\Toggle::make('is_published')
                                ->label(__('members.is_published'))
                                ->required(),
                        ])->columns(3),

                    ])->columnSpan(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\CheckboxList::make('teams')
                                ->options(Team::pluck('name')->toArray())
                                ->label(__('members.teams'))
                                ->relationship(name: 'teams', titleAttribute: 'name')
                                ->columnSpan(3)
                                ->required(),
                        Forms\Components\Repeater::make('links')
                            ->label(__('members.links'))
                            ->collapsible()
                            ->columnSpan(3)
                            ->collapsed()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => $state['link_text'] ?? null)
                            ->schema([
                                Forms\Components\TextInput::make('link_text')
                                    ->label(__('members.link_text'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('url')
                                    ->label(__('members.url'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_new_tab')
                                    ->label(__('members.open_new_tab')),
                                IconPicker::make('icon')
                                    ->label(__('members.icon'))
                                    ->default('heroicon-o-academic-cap')
                                    ->label('Icon'),
                            ]),
                            CuratorPicker::make('avatar')
                            ->label(__('member.avatar'))
                            ->columnSpan(3),

                    ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('avatar')
                ->label('')
                ->size(40)
                ->extraAttributes(['class' => 'round-full']),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teams.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('handle')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
