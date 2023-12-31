<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Main_arc extends Model
{
  public function Bank(){
    return $this->belongsTo(Bank::class);
  }
  public function Customer(){
    return $this->belongsTo(Customer::class);
  }

  public function Sell(){
    return $this->belongsTo(Sell::class);
  }

  public function Trans_arc(){
    return $this->belongsTo(Trans_arc::class);
  }


  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (Auth::check()) {
      $this->connection=Auth::user()->company;
    }
  }

}
