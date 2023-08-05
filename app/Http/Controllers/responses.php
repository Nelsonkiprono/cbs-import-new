<?php 

    // Curl Request

  //  curl 'https://localhost:8443/fineract-provider/api/v1/loans' \
  // -H 'Accept: application/json, text/plain, */*' \
  // -H 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8' \
  // -H 'Authorization: Basic bWlmb3M6cGFzc3dvcmQ=' \
  // -H 'Connection: keep-alive' \
  // -H 'Content-Type: application/json;charset=UTF-8' \
  // -H 'Cookie: autologin=a%3A2%3A%7Bs%3A7%3A%22user_id%22%3Bs%3A1%3A%229%22%3Bs%3A3%3A%22key%22%3Bs%3A16%3A%223934d80bc6a8a2df%22%3B%7D' \
  // -H 'Fineract-Platform-TenantId: default' \
  // -H 'Origin: https://localhost:8443' \
  // -H 'Referer: https://localhost:8443/palla-credit/' \
  // -H 'Sec-Fetch-Dest: empty' \
  // -H 'Sec-Fetch-Mode: cors' \
  // -H 'Sec-Fetch-Site: same-origin' \
  // -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36' \
  // -H 'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"' \
  // -H 'sec-ch-ua-mobile: ?0' \
  // -H 'sec-ch-ua-platform: "Linux"' \
  // --data-raw '{"clientId":"12","productId":1,"disbursementData":[],"principal":3000,"loanTermFrequency":30,"loanTermFrequencyType":0,"numberOfRepayments":30,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":25,"amortizationType":1,"isEqualAmortization":false,"interestType":1,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"transactionProcessingStrategyId":1,"rates":[],"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"11 August 2022","submittedOnDate":"11 August 2022"}' \
  // --compressed \
  // --insecure

//  The sample response

  // {"officeId":2,"clientId":12,"loanId":2,"resourceId":2}


// Sample curl for approval

	// curl 'https://localhost:8443/fineract-provider/api/v1/loans/1?command=approve' \
 //  -H 'Accept: application/json, text/plain, */*' \
 //  -H 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8' \
 //  -H 'Authorization: Basic bWlmb3M6cGFzc3dvcmQ=' \
 //  -H 'Connection: keep-alive' \
 //  -H 'Content-Type: application/json;charset=UTF-8' \
 //  -H 'Cookie: autologin=a%3A2%3A%7Bs%3A7%3A%22user_id%22%3Bs%3A1%3A%229%22%3Bs%3A3%3A%22key%22%3Bs%3A16%3A%223934d80bc6a8a2df%22%3B%7D' \
 //  -H 'Fineract-Platform-TenantId: default' \
 //  -H 'Origin: https://localhost:8443' \
 //  -H 'Referer: https://localhost:8443/palla-credit/' \
 //  -H 'Sec-Fetch-Dest: empty' \
 //  -H 'Sec-Fetch-Mode: cors' \
 //  -H 'Sec-Fetch-Site: same-origin' \
 //  -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36' \
 //  -H 'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"' \
 //  -H 'sec-ch-ua-mobile: ?0' \
 //  -H 'sec-ch-ua-platform: "Linux"' \
 //  --data-raw '{"approvedOnDate":"11 August 2022","approvedLoanAmount":3000,"note":"","expectedDisbursementDate":"11 August 2022","disbursementData":[],"locale":"en","dateFormat":"dd MMMM yyyy"}' \
 //  --compressed \
 //  --insecure


	// Sample approval response 

	// {"officeId":2,"clientId":40,"loanId":1,"resourceId":1,"changes":{"status":{"id":200,"code":"loanStatusType.approved","value":"Approved","pendingApproval":false,"waitingForDisbursal":true,"active":false,"closedObligationsMet":false,"closedWrittenOff":false,"closedRescheduled":false,"closed":false,"overpaid":false},"locale":"en","dateFormat":"dd MMMM yyyy","approvedOnDate":"11 August 2022","expectedDisbursementDate":{}}}



// Sample Dispurse curl 

	// curl 'https://localhost:8443/fineract-provider/api/v1/loans/1?command=disburse' \
 //  -H 'Accept: application/json, text/plain, */*' \
 //  -H 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8' \
 //  -H 'Authorization: Basic bWlmb3M6cGFzc3dvcmQ=' \
 //  -H 'Connection: keep-alive' \
 //  -H 'Content-Type: application/json;charset=UTF-8' \
 //  -H 'Cookie: autologin=a%3A2%3A%7Bs%3A7%3A%22user_id%22%3Bs%3A1%3A%229%22%3Bs%3A3%3A%22key%22%3Bs%3A16%3A%223934d80bc6a8a2df%22%3B%7D' \
 //  -H 'Fineract-Platform-TenantId: default' \
 //  -H 'Origin: https://localhost:8443' \
 //  -H 'Referer: https://localhost:8443/palla-credit/' \
 //  -H 'Sec-Fetch-Dest: empty' \
 //  -H 'Sec-Fetch-Mode: cors' \
 //  -H 'Sec-Fetch-Site: same-origin' \
 //  -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36' \
 //  -H 'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"' \
 //  -H 'sec-ch-ua-mobile: ?0' \
 //  -H 'sec-ch-ua-platform: "Linux"' \
 //  --data-raw '{"paymentTypeId":1,"transactionAmount":3000,"actualDisbursementDate":"11 August 2022","receiptNumber":"4381407","locale":"en","dateFormat":"dd MMMM yyyy"}' \
 //  --compressed \
 //  --insecure


  // Apply and repay loans per client

  public function initializeperclient(){
    $clients = $this->getClients();

    foreach($clients as $client){
      $loans = $this->getClientLoans($client->mobile_no);
      foreach($loans as $loan){
         $this->applyLoan($client->id,$loan);
         }
    }

  }

// Repayment curl

  // curl 'https://localhost:8443/fineract-provider/api/v1/loans/2/transactions?command=repayment' \
  // -H 'Accept: application/json, text/plain, */*' \
  // -H 'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8' \
  // -H 'Authorization: Basic bWlmb3M6cGFzc3dvcmQ=' \
  // -H 'Connection: keep-alive' \
  // -H 'Content-Type: application/json;charset=UTF-8' \
  // -H 'Cookie: autologin=a%3A2%3A%7Bs%3A7%3A%22user_id%22%3Bs%3A1%3A%229%22%3Bs%3A3%3A%22key%22%3Bs%3A16%3A%223934d80bc6a8a2df%22%3B%7D' \
  // -H 'Fineract-Platform-TenantId: default' \
  // -H 'Origin: https://localhost:8443' \
  // -H 'Referer: https://localhost:8443/palla-credit/' \
  // -H 'Sec-Fetch-Dest: empty' \
  // -H 'Sec-Fetch-Mode: cors' \
  // -H 'Sec-Fetch-Site: same-origin' \
  // -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36' \
  // -H 'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"' \
  // -H 'sec-ch-ua-mobile: ?0' \
  // -H 'sec-ch-ua-platform: "Linux"' \
  // --data-raw '{"paymentTypeId":1,"transactionAmount":"200","transactionDate":"16 July 2022","receiptNumber":"2414151","locale":"en","dateFormat":"dd MMMM yyyy"}' \
  // --compressed \
  // --insecure


  public $base_url = 'https://techsavanna.net:7000/fineract-provider/api/v1/';
  public $username = 'admin';
  public $password = 'password';
  public $tenant = 'palla';

  public $payed = 0;
  public $totalloan = 0;

  public $loancounter = 0;


  public $base_url = 'https://localhost:8443/fineract-provider/api/v1/';
  public $username = 'mifos';
  public $password = 'password';
  public $tenant = 'default';

?>
