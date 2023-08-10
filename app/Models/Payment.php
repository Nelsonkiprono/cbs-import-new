<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table = "dummy_receipts";

    public function client(){
        return $this->belongsTo('App\Models\Client','mobile_no','phone');
    }
}
