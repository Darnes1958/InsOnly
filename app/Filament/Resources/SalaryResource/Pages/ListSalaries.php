<?php

namespace App\Filament\Resources\SalaryResource\Pages;

use App\Filament\Resources\SalaryResource;
use App\Models\Main;
use App\Models\Salary;
use App\Models\Salarytran;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('إضافة مرتب جديد'),
            Actions\Action::make('إدارج_مرتبات')
                ->color('success')
                ->form([
                    DatePicker::make('month')
                    ->label('عن شهر')
                    ->required()

                    ->format('Y/m'),

                ])
                ->action(function (array $data) {
                  if (! Salarytran::where('month',$data['month'])->exists())
                  {
                      $main=Salary::where('status','فعال')->get();

                      foreach ($main as $item) {
                          $tran=new Salarytran;
                          $tran->salary_id=$item->id;
                          $tran->tran_date=now();
                          $tran->tran_type='مرتب';
                          $tran->val=$item->sal;
                          $tran->notes='مرتب شهر '.$data['month'];
                          $tran->month=$data['month'];
                          $tran->save();
                      }
                      Notification::make()
                          ->title('تم إدراج المرتب بنجاح ')
                          ->icon('heroicon-o-check')
                          ->duration(5000)
                          ->iconColor('success')
                          ->send();

                  }
                  else
                      Notification::make()
                          ->title('سبق إدراج هذا المرتب')
                          ->body('يرجي مراجعة المرتبات المدخلة سابقا')
                          ->icon('heroicon-o-x-mark')
                          ->color('danger')
                          ->duration(10000)
                          ->iconColor('danger')
                          ->send();
                }),

            Actions\Action::make('إلغاء_مرتب')
                ->color('success')
                ->form([
                    Select::make('month')
                    ->options(Salarytran::distinct()->pluck('month', 'month'))

                ])
                ->action(function (array $data) {
                    if (! Salarytran::where('month',$data['month'])->exists())
                    {
                        $main=Salary::where('status','فعال')->get();

                        foreach ($main as $item) {
                            $tran=new Salarytran;
                            $tran->salary_id=$item->id;
                            $tran->tran_date=now();
                            $tran->tran_type='مرتب';
                            $tran->val=$item->sal;
                            $tran->notes='مرتب شهر '.$data['month'];
                            $tran->month=$data['month'];
                            $tran->save();
                        }
                        Notification::make()
                            ->title('تم إدراج المرتب بنجاح ')
                            ->icon('heroicon-o-check')
                            ->duration(5000)
                            ->iconColor('success')
                            ->send();

                    }
                    else
                        Notification::make()
                            ->title('سبق إدراج هذا المرتب')
                            ->body('يرجي مراجعة المرتبات المدخلة سابقا')
                            ->icon('heroicon-o-x-mark')
                            ->color('danger')
                            ->duration(10000)
                            ->iconColor('danger')
                            ->send();
                })
        ];
    }
}
