<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class inp_kst extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel='ادخال اقساط';
    protected static ?int $navigationSort = 2;
    public function getTitle():  string|Htmlable
    {
        return  new HtmlString('<div class="leading-3 h-0  py-0 text-blue-400">ادخال أقساط من القائمة</div>');
    }

    protected static string $view = 'filament.pages.inp_kst';
}
