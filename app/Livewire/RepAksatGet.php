<?php

namespace App\Livewire;

use App\Models\Main;
use App\Models\Tran;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Filament\Forms\Get;

class RepAksatGet extends Component implements HasTable, HasForms
{


    use InteractsWithTable,InteractsWithForms;
  #[Reactive]
public $bank_id;
  #[Reactive]
public $Date1;
  #[Reactive]
public $Date2;
  #[Reactive]
public $By;

  public $kst;




  public function table(Table $table):Table
    {
        return $table
            ->query(function (Tran $tran)  {
               $tran= Tran::whereBetween('ksm_date',[$this->Date1,$this->Date2])
                   ->when($this->By==1,function ($query){
                       $query->wherein('main_id',function ($q){
                           $q->select('id')->from('mains')->where('bank_id',$this->bank_id);
                       });
                           })
                   ->when($this->By==2,function ($query){
                       $query->wherein('main_id',function ($q){
                           $q->select('id')->from('mains')->whereIn('bank_id',function ($qq){
                               $qq->select('id')->from('banks')->where('taj_id',$this->bank_id);
                           });
                       });
                   });
              $this->kst=0;

               return  $tran;
            })
            ->columns([
                TextColumn::make('main_id')
                    ->label('رقم العقد'),
                TextColumn::make('Main.name')
                    ->label('الاسم'),
                TextColumn::make('Main.Bank.BankName')
                    ->label('المصرف')
                    ->visible(fn (Get $get): bool =>$this->By ==2),
                TextColumn::make('Main.kst')
                    ->label('القسط')
                 ,

              TextColumn::make('ksm_date')
                    ->label('تاريخ الخصم'),
              TextColumn::make('ksm')
                    ->label('الخصم'),
            ]);
    }

    public function mount($Date1,$Date2,$bank_id){
     $this->Date1=$Date1;
     $this->Date2=$Date2;
     $this->bank_id=$bank_id;

    }

    public function render()
    {
        return view('livewire.rep-aksat-get');
    }
}
