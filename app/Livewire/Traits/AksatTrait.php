<?php
namespace App\Livewire\Traits;


use App\Models\Main;
use App\Models\Salary;
use App\Models\Salarytran;
use App\Models\Tran;
use Carbon\Carbon;
use DateTime;

trait AksatTrait {

  public function TarseedTrans(){
    $res=Salary::all();
    foreach ($res as $item)
      Salary::find($item->id)->update([
        'raseed'=>
          Salarytran::where('salary_id',$item->id)->where('tran_type','مرتب')->sum('val')+
          Salarytran::where('salary_id',$item->id)->where('tran_type','اضافة')->sum('val')-
          Salarytran::where('salary_id',$item->id)->where('tran_type','سحب')->sum('val')-
          Salarytran::where('salary_id',$item->id)->where('tran_type','خصم')->sum('val')
        ]);
  }
  public function setMonth($begin){
      $month = date('m', strtotime($begin));
      $year = date('Y', strtotime($begin));
      $date=$year.$month.'28';
      $date = DateTime::createFromFormat('Ymd',$date);
      $date=$date->format('Y-m-d');
      return $date;
  }
    public function getKst_date($main_id){
        $res=Tran::where('main_id',$main_id)->get();
        if (count($res)>0) {
            $date=$res->max('kst_date');
            $date= date('Y-m-d', strtotime($date . "+1 month"));
            return $date;
        } else
        {
            $begin=Main::find($main_id)->sul_begin;

            return $this->setMonth($begin);

        }
    }

  public function RetLate($main_id,$nextKst){
    $toDate = Carbon::parse($nextKst);
    $fromDate = Carbon::now();

    if ($fromDate>$toDate)
      $months = $toDate->diffInMonths($fromDate);
    else $months=0;

    return $months;

  }
    public function LateChk(){
        $Main=Main::where('LastUpd','<',now())->get();
        foreach ($Main as $main)
            Main::where('id',$main->id)->
            update([
                'LastUpd'=>now(),
                'Late'=>$this->RetLate($main->id,$main->NextKst),
            ]);
    }



}
