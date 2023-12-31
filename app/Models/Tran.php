<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tran extends Model
{
    protected $connection = 'other';

    public function KsmType(){
        return $this->belongsTo(KsmType::class);
    }

    public function Main(){
        return $this->belongsTo(Main::class);
    }
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (Auth::check()) {
            $this->connection = Auth::user()->company;
        }
    }
}