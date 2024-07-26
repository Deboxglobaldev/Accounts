<?php

include "inc.php";

MISuploadlogger("*********************   Inside page Debit/Credit API *******************************");

define("INF","{INFO} -");
define ("ERR","{ERROR} -");
define ("DBG","{DEBUG} -");

header("Content-Type: application/json");

$parameterdata = file_get_contents('php://input');
$inputData = json_decode($parameterdata);
MISuploadlogger("Parameter Json \n".$parameterdata);

class clsDBResponse
{
  public $Narration;
  // public $Amount;
  public $Debit;
  public $Credit;
  public $listOfData=array();
}

$effectedRow = 0;
if($inputData->VoucherType == 'CONTRA'){
$type = 'CV';
}
$dateAdded = $inputData->VoucherDate." ".date('H:i:s',time());
$transactionDate = $inputData->EntryDate;
$AddedBy = $inputData->UserId;
$Narration = $inputData->Narration;
$voucherNo = $type."-".date('dmy')."-".GetCVSequenceOftheDay();


foreach ($inputData->ListOfTransaction as $value) {
  
  if($inputData->VoucherType == 'CONTRA'){
    $debit = $value->Debit;
    $credit = $value->Credit;
    }
  if($value->AccountName != ""){
   
    $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Credit","Debit","Type"';

    $sql_val = "'".$value->AccountName."','".$voucherNo."','','".$dateAdded."','".$credit."','".$debit."','".$type."'";

    $query = ' Insert into vouchers."voucherMaster" ('.$sql_name.') Values ('.$sql_val.') ';

    // print_r($Type);die;

    MISuploadlogger("===insert====".$query);
    $misinsert = pg_query(OpenCon(),$query);
    //$misinsert = pg_query($dbconn, $query);
    if (!$misinsert) {
        echo "An error occurred.\n";
        exit;
    }
    
    $effectedRow += pg_affected_rows($misinsert);
      $totalAmount += $value->Amount;
   
  }
}

  if($inputData->VoucherType == 'CONTRA'){
  $totalDebit = $value->Debit;
  $totalCredit = $value->Credit;
  }

  // if($inputData->debit == 'DEBIT'){
  // $totalDebit = $value->Amount;
  // $totalCredit=0;
  // }
  // if($inputData->credit == 'CREDIT'){
  // $totalCredit = $value->Amount;
  // $totalDebit=0;
  // }


  $sql_name1 = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type"';

  $sql_val1 = "'".$value->AccountName."','".$voucherNo."','".$Narration."','".$dateAdded."','".$totalDebit."','".$totalCredit."','".$type."'";

  $query1 = ' Insert into vouchers."voucherMaster" ('.$sql_name1.') Values ('.$sql_val1.') ';

  MISuploadlogger("===insert1====".$query1);

  $misinsert1 = pg_query(OpenCon(),$query1);

  $objResponse = new clsDBResponse();
  $objResponse->Amount = $totalAmount;
  $objResponse->Amount = $Narration;
  $objResponse->listOfData = $inputData->ListOfTransaction;

  $ListOfJson = json_encode($objResponse,JSON_PRETTY_PRINT);

  $voucher_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';

  $voucher_val = "'".$voucherNo."','".$dateAdded."','".$ListOfJson."','".$transactionDate."','".$AddedBy."','".$type."'";

  $journal = ' Insert into vouchers."voucherEntry" ('.$voucher_name.') Values ('.$voucher_val.') ;';

  MISuploadlogger("==Voucher Insert====".$journal);

  $journalinsert = pg_query(OpenCon(),$journal);

  if($effectedRow > 0){
  echo "Saved Successfull";
  }else{
  echo "Failed to Save";
  }
?>