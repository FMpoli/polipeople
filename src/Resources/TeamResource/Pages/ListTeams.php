<?php

namespace Detit\Polipeople\Resources\TeamResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Detit\Polipeople\Resources\TeamResource;


class ListTeams extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
