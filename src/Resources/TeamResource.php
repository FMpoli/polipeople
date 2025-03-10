<?php

namespace Detit\Polipeople\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Detit\Polipeople\Models\Team;
use Detit\Polipeople\Resources\TeamResource\Pages;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    use Translatable;
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'People';

    protected static ?string $modelLabel = 'Teams';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->autocapitalize('words')
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if ($state !== $old) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->helperText('This field is not translatable and must be unique'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('sort_order')
                    ->default(fn () => self::getModel()::max('sort_order') + 1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->orderBy('sort_order', 'asc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('members_count')
                    ->counts('members')
                    ->label('Members'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('moveUp')
                        ->label('Move Up')
                        ->icon('heroicon-o-chevron-up')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Team $record) {
                            $query = Team::query()
                                ->where('sort_order', '<', $record->sort_order)
                                ->orderBy('sort_order', 'desc');

                            if ($swapRecord = $query->first()) {
                                $tempOrder = $record->sort_order;
                                $record->update(['sort_order' => $swapRecord->sort_order]);
                                $swapRecord->update(['sort_order' => $tempOrder]);
                            }

                            return true;
                        }),
                    Tables\Actions\Action::make('moveDown')
                        ->label('Move Down')
                        ->icon('heroicon-o-chevron-down')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Team $record) {
                            $query = Team::query()
                                ->where('sort_order', '>', $record->sort_order)
                                ->orderBy('sort_order', 'asc');

                            if ($swapRecord = $query->first()) {
                                $tempOrder = $record->sort_order;
                                $record->update(['sort_order' => $swapRecord->sort_order]);
                                $swapRecord->update(['sort_order' => $tempOrder]);
                            }

                            return true;
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
