<?php

namespace App\Filament\Resources\TranResource\Pages;

use App\Filament\Resources\TranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrans extends ListRecords
{
    protected static string $resource = TranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
