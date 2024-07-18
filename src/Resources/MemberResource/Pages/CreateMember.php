<?php

namespace Detit\Polipeople\Resources\MemberResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Detit\Polipeople\Resources\MemberResource;

class CreateMember extends CreateRecord
{
    // use CreateRecord\Concerns\Translatable;
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
