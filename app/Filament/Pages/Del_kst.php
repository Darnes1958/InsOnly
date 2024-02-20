<?php

namespace App\Filament\Pages;

use App\Models\Main;

use App\Models\Tran;

use Filament\Facades\Filament;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;


class Del_kst extends Page implements HasTable, HasForms
{
  use InteractsWithTable,InteractsWithForms;
  protected static ?string $navigationLabel='الغاء قسط';

  protected static ?int $navigationSort=4;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.del-kst';
  protected ?string $heading = '';

 public $main_id=0;

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('main_id')
          ->options(Main::all()->pluck('name', 'id')->toArray())
          ->searchable()
          ->columnSpan(2)
          ->inlineLabel()
          ->preload()
          ->live()
          ->Label('الاسم'),



      ])->columns(4);
  }

  public function table(Table $table):Table
  {
    return $table
      ->query(function (Tran $tran)  {
        $tran= Tran::where('main_id',$this->main_id);

        return  $tran;
      })
      ->columns([
        TextColumn::make('kst_date')
          ->sortable()
          ->label('تاريخ الاستحقاق'),
        TextColumn::make('ksm_date')
          ->sortable()
          ->label('تاريخ الخصم'),
        TextColumn::make('ksm')
          ->label('الخصم'),
        TextColumn::make('ksm_type')
          ->label('نوع الخصم'),
        TextColumn::make('ksm_notes')
          ->label('ملاحظات'),
      ])
        ->actions([
            Action::make('delete')
                ->label('الغاء')
                ->requiresConfirmation()
                ->action(fn (Tran $record) => $record->delete())
        ]);




  }


}
