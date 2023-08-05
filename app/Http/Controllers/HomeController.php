<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\DummyLoan;
use App\Models\Payment;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $base_url = 'https://localhost:8443/fineract-provider/api/v1/';

    public $username = 'mifos';
    public $password = 'password';

    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = Client::with('office')->get();
        return view('home', compact("clients"));
    }


    public function dummy(){
        $loans = DummyLoan::all();
        return view('dummy', compact("loans"));
    }



    public function joined(){
        $loans = DummyLoan::with('client')->get();
        return view('joined', compact("loans"));
    }


    public function getusers(){
        $client = Client::where('id','1');
    }

    public function formatedate($date = ''){
        $date = '15-Aug-22';

        return date('m d Y',strtotime($date));  // January 30, 2015, for example.
    }

    public function startofpaymentdate()
    {
       $date = date_create("10-Aug-22");
       date_add($date, date_interval_create_from_date_string("1 days"));
 
       return date_format($date, "j F Y");
    }

    public function getRepayments(){
        $phone = "0700 - 160483";
        $start_date = "17-Jun-22";
        $end_date = "17-Jul-22";
        $payments = Payment::where('phone',$phone)->where('date','>',$start_date)->where('date','<=',$end_date)->get();

        return $payments;
     }

     public function clientstatus($id){
         $client = Client::where('id',$id)->firstOrFail();

         return $client;
     }

    public function compareDates(){

        $past = new DateTime("09/04/22");
        $now = new DateTime("now");
        $dist_past = new DateTime("2002-09-21 18:15:00");
        $dist_future = new DateTime("12-09-2036");
         
         
        if($past < $now) {
            echo 'The first date is in the past.';
        }
        else{
            echo 'This is a wrong date.';
        }
     
    }
}
