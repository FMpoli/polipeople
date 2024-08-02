<?php

namespace Detit\Polipeople\Resources\MemberResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Detit\Polipeople\Resources\MemberResource;

class ListMembers extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
