<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Main;
use App\Models\Taj;
use App\Models\Wrongkst;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class RepTajSum extends Component implements HasTable, HasForms
{
    use InteractsWithTable,InteractsWithForms;


    public function table(Table $table):Table
    {
        return $table
            ->query(function (Taj $taj)  {
                Bank::all();
                return  $taj;
            })
            ->columns([
                TextColumn::make('id')
                    ->label('رقم المصرف'),
                TextColumn::make('TajName')
                    ->label('الاسم'),
                TextColumn::make('main_count')
                    ->counts('Main')
                    ->label('عدد العقود')
                    ->summarize(
                        Summarizer::make()
                            ->using(function (){return Main::count();})

                    ),
                TextColumn::make('main_sum_kst')
                    ->sum('Main','kst')
                    ->label('اجمالي العقود')
                    ->summarize(
                        Summarizer::make()
                            ->using(function (){return Main::sum('kst');})
                            ->numeric(
                                decimalPlaces: 0,
                                decimalSeparator: '.',
                                thousandsSeparator: ',',
                            )

                    ),
            ])

            ;
    }

    public function render()
    {
        return view('livewire.rep-taj-sum');
    }
}
