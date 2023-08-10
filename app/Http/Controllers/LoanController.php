<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\DummyLoan;
use App\Models\Loan;
use App\Models\Payment;

class LoanController extends Controller
{

	// public $email_address = Client::where('id','1')->get();

    //  Loan Product ID

  public $base_url = 'https://palla.techsavanna.technology:7000/fineract-provider/api/v1/';
  public $username = 'admin';

  public $password = 'password';
  public $tenant = 'default';

  public $localkey = "bWlmb3M6cGFzc3dvcmQ=";
  public $productionkey = "YWRtaW46cGFzc3dvcmQ=";

  public $localproductid = "1";
  public $productionproductid = "5";

	public $payed = 0;
	public $totalloan = 0;
	public $loancounter = 0;


 
	
	// Apply per loan criteria


	public function initializeperloan(){
		$loans = $this->getClientLoans('0799 - 945989');
		// return $loans

		
		foreach($loans as $loan){
			$email_address2 = $this->formatnumber($loan->phone);
			$this->setCount();
			// dd($this->formatnumber($loan->phone));
			if (isset($loan->phone)) {
				$client = $this->getClient($loan->phone);
				 //dd($client);
				 
			}
			
			if (isset($client)) {
				$checkLoanExists = $this->checkLoanExists($client->id,$loan);
				if($checkLoanExists == 0){	
					$this->applyLoan($client->id,$loan);
			    }
			    else{
			    	$this->updateAppliedLoan($loan->phone);
			    	echo "Loan exists:".$this->getCount()."</br>";
			    }
			} else{

				echo "Client does not exist:".$this->getCount()."Name = ".$loan->client_name."|||phone = ".$loan->phone."</br>";
				var_dump($client);
			}
		}
	
	
	}



	//Function to initialize the repayments per loan.

	//  Less than or equal to
	//  Check if payment has already been made.
	//  Use outstanding 
   	//  

   	// Function to check if the loan has partial / full payment. If outstandng < the total amount to be re
	public function initloanpayment(){
	 	$totalamount = 0;
	 	$loans = $this->getApprovedLoans();
		//echo json_encode($loans);
   
	 	foreach($loans as $loan){
	 		if($this->checkOutstanding($loan->id)==1){
	 		$start_date = $this->formatedate4($loan->disbursedon_date);
	 		$end_date = $this->formatedate4($loan->expected_maturedon_date);

	 		$totaltoberepaid = $this->getLoanTotalAmount($loan->id);
	 		if (isset($loan->client->mobile_no)) {
	 			$repayments = $this->getRepayments($loan->client->mobile_no);
	 		}
	 		echo json_encode($repayments);
	 		
	 		
	 		foreach($repayments  as $repayment){
			if(isset($repayment->date)){
			echo json_encode($repayment);
			
	 			$repayment->date = $this->formatedate3($repayment->date);

	 			  $totalamount+= (double)$repayment->amount;
	 			 
	 			  $dateTimestamp1 = strtotime($end_date);
                   $dateTimestamp2 = strtotime($start_date);

	 			  $repdate = strtotime($repayment->date);
	 			if ($repdate > $dateTimestamp2  && $repayment->used==0 && $repdate < $dateTimestamp1 ) {
	 				if ($totalamount>=$totaltoberepaid) {
	 					$totalamount = 0;
	 					//echo "</br></br>";
	 					//echo "Loan already payed: Total to be repaid=".$totaltoberepaid."Total amount paid:".$totalamount;
	 				}else{
					
	 					$this->repay($loan->id,$repayment);
	 						//echo json_encode($repayment)."</br></br></br></br>";
	 					
	 				}
	 				
	 			}
	 			}
	 		}
	 	}
	 		
	 	}

	}


   public function initpartialpayment(){
	 	$totalamount = 0;
	 	$loans = $this->getApprovedLoans();
		 //echo json_encode($loans);
   
	 	foreach($loans as $loan){
	 		if($this->checkOutstanding($loan->id)==2){
			$repaidamount=getrepaid($loan->id);
	 		$start_date = $this->formatedate4($loan->disbursedon_date);
	 		$end_date = $this->formatedate4($loan->expected_maturedon_date);

	 		$totaltoberepaid = $this->getLoanTotalAmount($loan->id);
	 		if (isset($loan->client->mobile_no)) {
	 			$repayments = $this->getRepayments($loan->client->mobile_no);
	 		}
	 		
	 		echo json_encode($repayments);
	 		
	 		foreach($repayments  as $repayment){
			//echo json_encode($repayment);
	 			 $repayment->date = $this->formatedate3($repayment->date);

	 			  $repaidamount += (double)$repayment->amount;
	 			 
	 			  $dateTimestamp1 = strtotime($end_date);
                  $dateTimestamp2 = strtotime($start_date);

	 			  $repdate = strtotime($repayment->date);
	 			if ($repdate > $dateTimestamp2  && $repayment->used==0 && $repdate < $dateTimestamp1 ) {
	 				if ($repaidamount >= $totaltoberepaid) {
	 					$repaidamount = 0;
	 					echo "</br></br>";
	 					echo "Loan already payed: Total to be repaid=".$totaltoberepaid."Total amount paid:".$repaidamount;
	 				}else{
	 					$this->repay($loan->id,$repayment);
	 						// echo json_encode($repayment)."</br></br></br></br>";
	 				}
	 				
	 			}
	 			
	 		}
	 	}
	 		
	 	}

	}

	public function getLoanTotalAmount($loanId){
	    //set_time_limit(0);
		$url = $this->base_url."loans/".$loanId."?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant;

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$headers = array(
			   "Authorization: Basic ".$this->productionkey,
			);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			//for debug only!
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 0);

			$resp = curl_exec($curl);
			curl_close($curl);
			// var_dump($resp);
			$data = json_decode($resp, true);
			if(isset($data['summary'])){
			 return $data['summary']['totalExpectedRepayment'];
			}
			else{
				echo "</br></br>";
				var_dump($resp);
			}
			
	}

	public function getrepaid($loanId){
		$url = $this->base_url."loans/".$loanId."?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant ;

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$headers = array(
			   "Authorization: Basic ".$this->productionkey,
			);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			//for debug only!
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 0);

			$resp = curl_exec($curl);
			// dd($resp);
			curl_close($curl);
			// var_dump($resp);
			$data = json_decode($resp, true);
			if(isset($data['summary'])){
				 $totalamount = $data['summary']['totalExpectedRepayment'];
				 $totaloutstanding = $data['summary']['totalOutstanding'];
				$repaid=$totaloutstanding-$totalamount;
				return $repaid;
				 
			}else{
				return 0;
			}	 
			
	}

	// Adding the counter
	public function setCount(){
		$this->loancounter+=1;
	}
	// Getting the counter
	public function getCount(){
		return $this->loancounter;
	}

	// Get one client

	public function getClient($email_address = ''){

		 $client = Client::where('mobile_no',$email_address)->first();

		 return $client;
	}

   public function getTransactions($loanId = ''){

		$url =$this->base_url."loans/".$loanId."?associations=all&exclude=guarantors,futureSchedule&username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant;
		$trans_dates = [];
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		$resp = curl_exec($curl);
		$data = json_decode($resp, true);
		curl_close($curl);
		// dd($data['transactions']);
		
		foreach($data['transactions'] as $trans){
			// echo "</br></br></br>";
			$date= $trans['date'][0]."-".$trans['date'][1]."-".$trans['date'][2];
			$formatteddate = $this->formatedate2($date);
			array_push($trans_dates, $formatteddate);
		}

		
		/*
			Get all the transations
			Get all the dates / receipts of a transaction.

			Get the repayments of the loan where the date is not in the date fetched from transactions 

			Initialize the loan repayment

		*/
	
		return $trans_dates;
	}

	// Get the loans for a client
	public function getClientLoans($email_address=1){

		$email_address =Client::all();
		foreach($email_address as $email){
			$id = $email->email_address;
			$loan= DummyLoan::where('member_id', $id)->get();

			// var_dump($loan);
			
			foreach($loan as $s_loan){
				
				$loan = $s_loan;
				
				//$loan_id will be used as external id in m_loan table
				$loan_id = $s_loan->id;

				// echo $loan." : ".$id."<br>";
			 $this->applyLoan($id,$loan,$loan_id);

			}
	

			}


			
	}

	public function updateAppliedLoan($email_address){
		  DummyLoan::where("phone", $email_address)->update(["applied" => "1"]);
	}
	 // Funtion to get repayments of a loan

	 public function getRepayments($email_address){
	 	// implode(', ', $mystaff)
	 	// ->whereNotIn('date',implode(', ', $mystaff));
	 	$payments = Payment::where('used','0')->where('phone',$email_address)->get();
	 	return $payments;
	 }

	 // Function to get all the loans 
	 public function getApprovedLoans(){

	 	$loans = Loan::with('client')->where('loan_status_id',300)->where('submittedon_date','>','2022-05-01')->where('submittedon_date','<','2022-05-31')->get();
		//$loans = Loan::with('client')->where('loan_status_id',300)->get();

	 	return $loans;

	 }

	// format date to i.e 15 August 2022
	public function formatedate($date = ''){
  
        return date('j F Y',strtotime($date));
    }

   // format date to i.e 2022-07-15
	public function formatedate2($date = ''){
  
        return date('Y-m-d',strtotime($date));
    }

   // format date to i.e 2022-07-15
	public function formatedate3($date = ''){
  		     
      //       $string = $date;
		// $str_arr = explode ("/", $string); 
		
		// $realdate = $str_arr[0]."-".$str_arr[1]."-20".$str_arr[2];
		
        return date('d-m-Y',strtotime($date));
    }

 // format date to i.e 2022-07-15
	public function formatedate4($date = ''){
  
        return date('d-m-Y',strtotime($date));
    }
    // remove decimals and comma from amount
    public function formatamount($var = ''){
		$var = intval(preg_replace('/[^\d.]/', '', $var));
		return $var;
    }

 // remove decimals and comma from amount
    public function formatnumber($var = ''){
		 preg_replace('/[^A-Za-z0-9\-]/', '', $var);
		 $res = str_replace( array( '\'', '"',
      ',' , '-', ' ', '>' ), ' ', $var);
		 $res1 = preg_replace('/[^A-Za-z0-9\-]/', '', $res);
		return $res1;
    }

	// Add the total amount payed for current loan
    public function setPayed($amount){
    	$this->payed=$this->payed+$amount;
    }

    // Get the total amount payed for current loan
    public function getPayed(){
    	return $this->payed;
    }

    // Reset the payed amount
    public function resetPayed(){
    	$this->payed = 0;
    }
	// Check the number of loans that the client has
	public function getLoanNo($email_address = '')
	{
		$number = DummyLoan::where('phone',$email_address)->count();
		return $number;
	}

	// Get the date for start of payment 
	// public function startofpaymentdate($date = '')
	// {
	// 	 $date = date_create("10-Aug-22");
	//      date_add($date, date_interval_create_from_date_string("1 days"));
	 
	//      return date_format($date, "Y-m-d");
	// }

	// Getting the client status
	public function clientstatus($id)
	{
         $client = Client::where('id',$id)->first();

         return $client->payed_status;
    }

    // Update to 1 if a particular loan has been used.
    public function updateUsed($receipt_no,$resp)
    {
    	$affectedRows = Payment::where("receipt_no", $receipt_no)->update(["used" => "1"]);
    	if ($affectedRows) {
    		var_dump(json_encode($resp));
    	}
    }

    // Check if loan exists in the databases before application
    public function checkLoanExists($id,$loan){
    	if (isset($loan->start_date)) {
    		$presentloan = Loan::where('client_id',$id)->where('submittedon_date',$this->formatedate2($loan->start_date))->count();

    	     return $presentloan;
    	}
    
    }

    // Check if loan exists from the api

    public function loanExists($id,$loan)
    {
	 	$url = "https://palla.techsavanna.technology:7000/fineract-provider/api/v1/loans?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant;
 
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		$resp = curl_exec($curl);
		curl_close($curl);
		//var_dump($resp);
    }


	// Apply loan for a client
	public function applyLoan($id,$loan,$loan_id){
		
		ini_set('max_execution_time', 216000); //3 minutes
		$url = $this->base_url."loans?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant;

		$date = $this->formatedate($loan->application_date);


		$amount = $this->formatamount($loan->amount);

		

		$curl = curl_init($url);
		//$url="https://ussdhost.000webhostapp.com/jsonreceive.php";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = <<<DATA
		{
		  "external_id": $loan_id,
		  "clientId": $id,
		  "productId": 5,
		  "disbursementData": [],
		  "principal": $amount,
		  "loanTermFrequency": 30,
		  "loanTermFrequencyType": 0,
		  "numberOfRepayments": 30,
		  "repaymentEvery": 1,
		  "repaymentFrequencyType": 0,
		  "interestRatePerPeriod": 25,
		  "amortizationType": 1,
		  "isEqualAmortization": false,
		  "interestType": 1,
		  "interestCalculationPeriodType": 1,
		  "allowPartialPeriodInterestCalcualtion": false,
		  "transactionProcessingStrategyId": 1,
		  "rates": [],
		  "locale": "en",
		  "dateFormat": "dd MMMM yyyy",
		  "loanType": "individual",
		  "expectedDisbursementDate": "$date",
		  "submittedOnDate": "$date"
		}
		DATA;

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		$resp = json_decode($resp);
	
		if(isset($resp->loanId)){
			$this->approve($resp->loanId,$loan);
		}
		
	}

	// Approve all loans 

	public function approve($loanId = '',$loan){


		$url = $this->base_url."loans/".$loanId."?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant."&command=approve";

		$date = $this->formatedate($loan->start_date);


		$amount = $this->formatamount($loan->amount);


		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = <<<DATA
		{
		  "approvedOnDate": "$date",
		  "approvedLoanAmount": $amount,
		  "note": "",
		  "expectedDisbursementDate": "$date",
		  "disbursementData": [],
		  "locale": "en",
		  "dateFormat": "dd MMMM yyyy"
		}
		DATA;

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp);

		if(isset($resp->loanId)){
			$this->dispurse($resp->loanId,$loan);
		}

	}
		// Dispurse all loans

	 public function dispurse($loanId = '',$loan){

	 	$url = $this->base_url."loans/".$loanId."?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant."&command=disburse";

	 	$date = $this->formatedate($loan->start_date);


		$amount = $this->formatamount($loan->amount);

		$receipt = $loan->trans_no;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);

		$data = <<<DATA
		{
		  "paymentTypeId": 1,
		  "transactionAmount": $amount,
		  "actualDisbursementDate": "$date",
		  "receiptNumber": "$receipt",
		  "locale": "en",
		  "dateFormat": "dd MMMM yyyy"
		}
		DATA;

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		echo "</br></br>";
		var_dump($resp);

	 }

	 	 // Funtion to repay loan
	 

	 public function repay($loanId='',$repayment){
	 	$url = $this->base_url."loans/".$loanId."/transactions?username=".$this->username."&password=".$this->password."&tenantIdentifier=".$this->tenant."&command=repayment";
			 if(isset($repayment->amount)){
			 	$amount = $this->formatamount($repayment->amount);
			 }
			 if(isset($repayment->date)){
			 	$date = $this->formatedate($repayment->date);
			 }
			 if(isset($repayment->receipt_no)){
			 	$receipt =$repayment->receipt_no;
			 }
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		

		$headers = array(
		   "Authorization: Basic ".$this->productionkey,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = <<<DATA
		{
		  "paymentTypeId": 1,
		  "transactionAmount": $amount,
		  "transactionDate": "$date",
		  "receiptNumber": "$receipt",
		  "locale": "en",
		  "dateFormat": "dd MMMM yyyy"
		}
		DATA;

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp);

		if(isset($resp->loanId)){

			 $this->updateUsed($repayment->receipt_no,$resp);
			 //echo "</br></br>";
			 //var_dump($resp);

		}

	 }

}

