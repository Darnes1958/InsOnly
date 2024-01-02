<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Rep_all extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.rep_all';


    public static ?string $title = 'تقرير عن مصرف';

    protected static ?string $navigationGroup='تقارير';
    protected static ?int $navigationSort=2;
}
