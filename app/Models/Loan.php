<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public $table = "m_loan";

    public function client(){
        return $this->belongsTo('App\Models\Client','client_id','id');
    }
}
