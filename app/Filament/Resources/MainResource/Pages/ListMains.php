<?php

namespace App\Filament\Resources\MainResource\Pages;

use App\Filament\Resources\MainResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ListMains extends ListRecords
{
    protected static string $resource = MainResource::class;
    public function getTitle():  string|Htmlable
    {
        return  new HtmlString('<div class="leading-3 h-0  py-0 text-blue-400">عقود</div>');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('إضافة عقد')
            ->icon('heroicon-o-plus'),

        ];
    }
}
