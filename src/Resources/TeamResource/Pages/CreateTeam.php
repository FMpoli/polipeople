<?php

namespace Detit\Polipeople\Resources\TeamResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Detit\Polipeople\Resources\TeamResource;

class CreateTeam extends CreateRecord
{
    // use CreateRecord\Concerns\Translatable;
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}