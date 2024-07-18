<?php

namespace Detit\Polipeople\Resources\MemberResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Detit\Polipeople\Resources\MemberResource;

class EditMember extends EditRecord
{
    // use EditRecord\Concerns\Translatable;
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
