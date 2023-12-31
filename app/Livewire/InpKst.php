<?php

namespace App\Livewire;


use App\Livewire\Forms\TransForm;
use App\Models\Main;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
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

    public $bank=1;
    public $ksm_date;

    public TransForm $transForm;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bank')
                    ->relationship('Bank','bank_name')
                    ->reactive()
                    ->preload(),
                DatePicker::make('ksm_date')
                    ->label('تاريخ الخصم')
                    ->reactive()
                    ->inlineLabel()
            ]);
    }

    public function table(Table $table):Table
    {
        return $table
            ->query(function (Main $main)  {
                $main=Main::where('bank',$this->bank);
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
                    ->label('رقم الحساب'),
            ])

            ->bulkActions([

                BulkAction::make('خصم')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as  $item)
                        {
                            $this->transForm->FillTrans($records->main_id,$this->ksm_date);
                            $this->transForm->Save($this->transForm->all());
                        }

                    }),
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
