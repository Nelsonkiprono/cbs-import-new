<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Client;

class DummyLoan extends Model
{
    use HasFactory;
    
    public $table = "dummy_loans";

    public function client(){
        return $this->hasOne('App\Models\Client','mobile_no','phone');
    }

    public function payments(){
        return $this->hasMany('App\Models\Payment','phone','phone');
    }
}
