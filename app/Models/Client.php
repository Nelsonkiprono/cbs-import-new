<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DummyLoan;
use App\Models\Payment;

class Client extends Model
{
    use HasFactory;

    public $table = "m_client";


    public function loans(){
        return $this->hasMany('App\Models\DummyLoan','phone','mobile_no');
    }

    public function payments(){
        return $this->hasMany('App\Models\Payment','phone','mobile_no');
    }

    public function office(){
        return $this->hasOne('App\Models\Office','id','office_id');
    }
}
