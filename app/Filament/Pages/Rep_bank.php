<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Rep_bank extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
  protected static ?string $navigationLabel='إجمالي المصارف';
  protected static ?string $navigationGroup='تقارير';
  protected static ?int $navigationSort=1;

  public function getTitle():  string|Htmlable
  {
    return  new HtmlString('<div class="leading-3 h-0  py-0 text-blue-400 text-sm">تقرير بإجمالي العقود بحسب المصارف التجميعية او الفروع</div>');
  }
    protected static string $view = 'filament.pages.rep_bank';
}
