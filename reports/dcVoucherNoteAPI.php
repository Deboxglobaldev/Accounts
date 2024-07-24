<?php

include "inc.php";

MISuploadlogger("*********************   Inside page Debit/Credit API *******************************");

define("INF","{INFO} -");
define ("ERR","{ERROR} -");
define ("DBG","{DEBUG} -");


// {
//   "VoucherDate": "27-10-2022",
//   "AccountHead": "Credit Account Name",
//   "EntryDate": "27-10-2022",
//   "UserId": "2",
//   "Narration": "This is just ramark column",
//   "VoucherType": "DEBIT",
//   "ListOfTransaction": [
//     {
//       "AccountName": "HDFC Bank",
//       "Code": "56465",
//       "Amount": "500"
//     },
//     {
//       "AccountName": "ICICI Bank",
//       "Code": "565",
//       "Amount": "400"
//     }
//   ]
// }

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$inputData = json_decode($parameterdata);

MISuploadlogger("Parameter Json \n".$parameterdata);

class clsDBResponse
{
  public $AccountHead;
  public $Narration;
  public $Amount;
  public $listOfData=array();
}

$effectedRow = 0;
if($inputData->VoucherType == 'DEBIT'){
$Type = 'DN';
}
if($inputData->VoucherType == 'CREDIT'){
$Type = 'CN';
}
// if($inputData->VoucherType == 'CONTRA'){
// $type = 'CV';
// }
$dateAdded = $inputData->VoucherDate." ".date('H:i:s',time());
$transactionDate = $inputData->EntryDate;
$AddedBy = $inputData->UserId;
$Narration = $inputData->Narration;
$AccountHead = $inputData->AccountHead;
$voucherNo = $Type."-".date('dmy')."-".GetCVSequenceOftheDay();


foreach ($inputData->ListOfTransaction as $value) {
if($inputData->VoucherType == 'DEBIT'){
$debit = $value->Amount;
$credit=0;
}
if($inputData->VoucherType == 'CREDIT'){
$credit = $value->Amount;
$debit=0;
}
  if($value->AccountName != ""){

    $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Credit","Debit","Type"';

    $sql_val = "'".$value->AccountName."','".$voucherNo."','','".$dateAdded."','".$credit."','".$debit."','".$Type."'";

    $query = ' Insert into vouchers."voucherMaster" ('.$sql_name.') Values ('.$sql_val.') ;';

    MISuploadlogger("===insert====".$query);

    $misinsert = pg_query(OpenCon(),$query);

    $effectedRow+=pg_affected_rows($misinsert);

    $totalAmount += $value->Amount;

  }
}

if($inputData->VoucherType == 'DEBIT'){
$totalDebit = $totalAmount;
$totalCredit=0;
}
if($inputData->VoucherType == 'CREDIT'){
$totalCredit = $totalAmount;
$totalDebit=0;
}


  $sql_name1 = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type"';

  $sql_val1 = "'".$AccountHead."','".$voucherNo."','".$Narration."','".$dateAdded."','".$totalDebit."','".$totalCredit."','".$Type."'";

  $query1 = ' Insert into vouchers."voucherMaster" ('.$sql_name1.') Values ('.$sql_val1.') ;';

  MISuploadlogger("===insert1====".$query1);

  $misinsert1 = pg_query(OpenCon(),$query1);

  $objResponse = new clsDBResponse();
  $objResponse->AccountHead = $AccountHead;
  $objResponse->Amount = $totalAmount;
  $objResponse->Amount = $Narration;
  $objResponse->listOfData = $inputData->ListOfTransaction;

  $ListOfJson = json_encode($objResponse,JSON_PRETTY_PRINT);

  $voucher_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';

  $voucher_val = "'".$voucherNo."','".$dateAdded."','".$ListOfJson."','".$transactionDate."','".$AddedBy."','".$Type."'";

  $journal = ' Insert into vouchers."voucherEntry" ('.$voucher_name.') Values ('.$voucher_val.') ;';

  MISuploadlogger("==Voucher Insert====".$journal);

  $journalinsert = pg_query(OpenCon(),$journal);

  if($effectedRow > 0){
  echo "Saved Successfull";
  }else{
  echo "Failed to Save";
  }
?>