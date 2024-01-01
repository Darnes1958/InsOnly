<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Main;
use App\Models\Overkst;
use App\Models\Tarkst;
use App\Models\Wrongkst;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Component;

class RepBank extends Component
{
    public $By=1;
    public $kst;

    public $count;
    public $over;
    public $tar;
    public $wrong;
    public array $data_list= [
        'calc_columns' => [
            'main_count',
            'main_sum_kst',
            'main_sum_over_kst',
            'main_sum_tar_kst',
            'wrong_kst_sum_kst',
            'BankName'
        ],
    ];
    public function table(Table $table):Table
    {
        return $table
            ->query(function (Bank $bank)  {
                Bank::all();
                $this->kst=number_format(Main::sum('kst'),0, '', ',')  ;
                $this->count=number_format(Main::count(),0, '', ',')  ;
                $this->over=number_format(Overkst::sum('kst'),0, '', ',')  ;
                $this->tar=number_format(Tarkst::sum('kst'),0, '', ',')  ;
                $this->wrong=number_format(Wrongkst::sum('kst'),0, '', ',')  ;
                return  $bank;
            })
            ->columns([
                TextColumn::make('id')
                    ->label('رقم المصرف'),
                TextColumn::make('BankName')
                    ->label('الاسم'),
                TextColumn::make('main_count')
                    ->counts('Main')
                    ->label('عدد العقود'),
                TextColumn::make('main_sum_kst')
                    ->sum('Main','kst')
                    ->label('اجمالي العقود'),
                TextColumn::make('main_sum_over_kst')
                    ->sum('Main','over_kst')
                    ->label('الفائض'),
                TextColumn::make('main_sum_tar_kst')
                    ->sum('Main','tar_kst')
                    ->label('الترجيع'),
                TextColumn::make('wrong_kst_sum_kst')
                    ->sum('WrongKst','kst')
                    ->label('بالخطأ'),
            ])
            ->contentFooter(view('sum-footer',$this->data_list))
            ;
    }
    public function render()
    {
        return view('livewire.rep-bank');
    }
}
