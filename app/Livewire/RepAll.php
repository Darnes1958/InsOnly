<?php

namespace App\Livewire;

use App\Livewire\Traits\AksatTrait;
use App\Livewire\Traits\MainTrait;
use App\Models\Bank;
use App\Models\Main;
use App\Models\Taj;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Http\Controllers\PdfController;
use Illuminate\Database\Query\Builder;
use Filament\Tables\Columns\Summarizers\Summarizer;



class RepAll extends Component implements HasTable, HasForms
{
    use InteractsWithTable,InteractsWithForms;
    use AksatTrait;

public $bank_id;
public $bank;
public $taj;
public $By=1;
public $is_show=false;
public $field='id';
public $query;
public $rep_name='All';
public $Date1;
public $Date2;
public $Baky=3;

public $kst;


  public array $data_list= [
    'calc_columns' => [
      'acc',
      'sul',
      'pay',
      'raseed',
    ],
  ];



  public function form(Form $form): Form
  {
    return $form
      ->schema([

        Select::make('bank')
          ->columnSpan(2)
          ->inlineLabel()
          ->options(Bank::all()->pluck('BankName', 'id')->toArray())

          ->searchable()
          ->reactive()
          ->Label('فرع المصرف')
          ->visible($this->By==1)
          ->afterStateUpdated(function (callable $get) {
            $this->bank_id=$get('bank');
            $this->field='id';


          }),
        Select::make('taj')
            ->columnSpan(2)
          ->inlineLabel()
          ->options(Taj::all()->pluck('TajName', 'id')->toArray())
          ->searchable()
          ->Label('المصرف التجميعي')
          ->reactive()
          ->visible($this->By==2)
          ->afterStateUpdated(function (callable $get) {
            $this->bank_id=$get('taj');
            $this->field='taj_id';

          }),
        Select::make('rep_name')
           ->columnSpan(2)
          ->inlineLabel()
          ->label('التقرير')
          ->default('All')
          ->reactive()

          ->options([
            'All' => 'كشف بالأسماء',
            'Motakra' => 'المتأخرة',
            'Mohasla' => 'المحصلة',
            'Not_Mohasla' => 'الغير محصلة',
          ]),

          TextInput::make('Baky')
              ->inlineLabel()
              ->label('عدد أشهر التأخير')
              ->reactive()
              ->numeric()
              ->visible(fn (Forms\Get $get): bool =>  $get('rep_name')=='Motakra'),

          DatePicker::make('Date1')
            ->inlineLabel()
            ->label('من')
            ->reactive()
            ->visible(fn (Forms\Get $get): bool => $get('rep_name')=='Mohasla' || $get('rep_name')=='Not_Mohasla'),
          DatePicker::make('Date2')
            ->inlineLabel()
            ->label('إلي')
            ->reactive()
              ->visible(fn (Forms\Get $get): bool => $get('rep_name')=='Mohasla' || $get('rep_name')=='Not_Mohasla'),

      ])->columns(7);
  }



    public function table(Table $table):Table
    {
      return $table
        ->query(function (Main $main)  {
            if ($this->By==1) {
                 $main=Main::where('bank_id',$this->bank_id)

                 ->when($this->rep_name=='Motakra' , function ($q) {
                    $q->where('late','>=',$this->Baky); }) ;
            }
            if ($this->By==2) {
                $main=Main::whereIn('bank_id',function ($q){
                    $q->select('id')->from('banks')->where('taj_id',$this->bank_id);
                    })

                    ->when($this->rep_name=='Motakra' , function ($q) {
                        $q->where('late','>=',$this->Baky); }) ;
            }
          $this->kst=number_format($main->sum('kst'),0, '', ',')  ;
            return  $main;
        })
        ->columns([
            TextColumn::make('id')
                ->label('رقم العقد'),
            TextColumn::make('acc')
                ->label('رقم الحساب'),
            TextColumn::make('name')
             ->label('الاسم'),
            TextColumn::make('kst')
              ->label('القسط'),

            TextColumn::make('Late')
                ->label('متأخرة')
                ->visible(fn (Forms\Get $get): bool =>$this->rep_name =='Motakra')
                ->color('danger')
              ,
            TextColumn::make('sul_begin')
                ->label('تاريخ العقد')
                ->visible(fn (Forms\Get $get): bool =>$this->rep_name =='Motakra')
                ->color('info'),
            TextColumn::make('LastKsm')
                ->label('ت.أخر قسط')
                ->visible(fn (Forms\Get $get): bool =>$this->rep_name =='Motakra')
                ->color('danger'),


        ])
        ->contentFooter(view('sum-footer', $this->data_list));
    }

    public function mount(){
     $this->Date1=date('Y-m-d');
     $this->Date2=date('Y-m-d');

     $this->LateChk();
    }
    public function render()
    {

        return view('livewire.rep-all');
    }
}
