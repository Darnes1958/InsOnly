<?php

namespace App\Livewire;


use App\Livewire\Forms\TransForm;
use App\Models\Bank;
use App\Models\Main;
use App\Models\Tran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class InpKst extends Component implements HasForms,HasTable
{
    use InteractsWithForms,InteractsWithTable;

    public $bank_id;
    public $ksm_date;
    public $ksm_notes;

    public TransForm $transForm;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bank_id')
                    ->options(Bank::all()->pluck('BankName','id'))
                    ->label('المصرف')
                    ->reactive()
                    ->live()
                    ->preload()
                    ->columnSpan(2)
                    ->extraAttributes([
                        'wire:change' => "\$dispatch('goto', { test: 'ksmdate' })",
                    ]),
                DatePicker::make('ksm_date')
                    ->label('تاريخ الخصم')
                    ->reactive()
                    ->extraAttributes([
                        'wire:keydown.enter' => "\$dispatch('goto', { test: 'ksmnotes' })",
                    ])
                    ->id('ksmdate'),
                TextInput::make('ksm_notes')
                    ->label('ملاحظات')
                    ->columnSpan(3)
                    ->id('ksmnotes')
            ])->columns(6);
    }

    public function table(Table $table):Table
    {
        return $table
            ->query(function (Main $main)  {
                $main=Main::where('bank_id',$this->bank_id);
                return  $main;
            })
            ->columns([
                TextColumn::make('id')
                    ->label('رقم العقد')
                    ->sortable(),
                TextColumn::make('name')->sortable()->searchable()
                    ->label('الاسم')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('acc')->sortable()->searchable()
                    ->label('رقم الحساب')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kst')->sortable()->searchable()
                    ->label('القسط'),
            ])

            ->bulkActions([
                BulkAction::make('خصم')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as  $item)
                        {
                            $this->transForm->FillTrans($item->id,$this->ksm_date,$this->ksm_notes);
                           Tran::create($this->transForm->all());
                        }

                    })->deselectRecordsAfterCompletion(),
            ])
            ->striped();
    }
    public function mount(){
        $this->ksm_date=date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.inp-kst');
    }
}
