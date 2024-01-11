<?php

namespace App\Livewire\Forms;

use App\Livewire\Traits\AksatTrait;
use App\Models\Main;
use App\Models\Overkst;
use App\Models\Tran;
use App\Models\Trans_arc;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TransForm extends Form
{
use AksatTrait;
    public $main_id = '';
    public $ser = '';
    public $ksm = '';
    public $ksm_date = '';
    public $kst_date ='';
    public $ksm_type = 'مصرفي';
    public $ksm_notes = '';
    public $user_id = '';


    public function SetTrans(Tran $rec){
      $this->main_id=$rec->main_id;
      $this->ser=$rec->ser;
      $this->ksm=$rec->ksm;
      $this->ksm_date=$rec->ksm_date;
      $this->kst_date=$rec->kst_date;
      $this->ksm_type=$rec->ksm_type;
      $this->ksm_notes=$rec->ksm_notes;
      $this->user_id=Auth::user()->id;
    }
  public function SetTransArc(Trans_arc $rec){
    $this->main_id=$rec->main_id;
    $this->ser=$rec->ser;
    $this->ksm=$rec->ksm;
    $this->ksm_date=$rec->ksm_date;
    $this->kst_date=$rec->kst_date;
    $this->ksm_type=$rec->ksm_type;
    $this->ksm_notes=$rec->ksm_notes;
    $this->user_id=Auth::user()->id;
  }

    public function FillTrans($main_id,$ksm_date,$ksm_notes,$ksm_type){
        $this->main_id=$main_id;
        $this->ksm_type=$ksm_type;
        $this->ksm_notes=$ksm_notes;
        $this->ser=Tran::where('main_id',$main_id)->max('ser')+1;
        $this->ksm=Main::find($main_id)->kst;
        $this->kst_date=$this->getKst_date($main_id);
        $this->ksm_date=$ksm_date;
        $this->user_id=Auth::user()->id;
    }
    public function TransDelete($id){

      Tran::where('id',$id)->delete();
      $this->SortTrans($this->main_id);
      $this->SortKstDate($this->main_id);
    }
    public function DoOver($main_id){
        $this->StoreOver($main_id,$this->ksm_date,$this->ksm);
    }
    public function DoBaky($main_id,$raseed){

        $this->over_id=$this->StoreOver($main_id,$this->ksm_date,$this->ksm-$raseed);
        $this->baky=$this->ksm-$raseed;
        $this->ksm=$raseed;

    }
}
