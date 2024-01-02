<?php

namespace App\Filament\Resources\SalarytranResource\Pages;

use App\Filament\Resources\SalarytranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalarytran extends EditRecord
{
    protected static string $resource = SalarytranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
