<?php

include "inc.php";

MISuploadlogger("*********************   Inside page Post Journal API *******************************");

define("INF","{INFO} -");
define ("ERR","{ERROR} -");
define ("DBG","{DEBUG} -");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$inputData = json_decode($parameterdata);

MISuploadlogger("Parameter Json \n".$parameterdata);

class clsDBResponse
{
  public $AccountName;
  public $Amount;
  public $listOfData=array();
}


$effectedRow = 0;
$totalCredit = 0;
$dateAdded = $inputData->VoucherDate." ".date('H:i:s',time());
$transactionDate = $inputData->EntryDate;
$AddedBy = $inputData->UserId;
$ip = $inputData->ip;
$BankAccount = $inputData->BankAccount;
$ListOfJson = json_encode($inputData->ListOfTransaction);
$voucherNo = "BP-".date('dmy')."-".GetBPSequenceOftheDay();
$Type = "bankPayment";

foreach ($inputData->ListOfTransaction as $value) {

  if($value->AccountName != ""){

    $balance = getBalance($value->AccountName);

    $finalBalance = $balance - $value->Debit;

    $ActivityLog = $value->AccountName."^Bank Payment^Debit^".$value->Debit."^".$voucherNo."^".$AddedBy."^".date('Y-m-d H:i:s')."^".$ip."^".$balance."^".$finalBalance;

    if(updateBalance($value->AccountName,$finalBalance)){

    $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type","Balance","ActivityLog"';

    $sql_val = "'".$value->AccountName."','".$voucherNo."','".$value->Narration."','".$dateAdded."','".$value->Debit."','0','".$Type."','".getBalance($value->AccountName)."','".$ActivityLog."'";

    $query = ' Insert into vouchers."voucherMaster" ('.$sql_name.') Values ('.$sql_val.') ;';

    MISuploadlogger("Account Balance of Branch ".$value->AccountName." is updated");

    }else{

    MISuploadlogger("Account Balance of Branch ".$value->AccountName." is not updated");

    }

    // MISuploadlogger("===insert====".$query);

    $misinsert = pg_query(OpenCon(),$query);

    $effectedRow+=pg_affected_rows($misinsert);

    $totalCredit += $value->Debit;

  }
}

if($totalCredit > 0){

    $balance1 = getBalance($BankAccount);

    $finalBalance1 = $balance1 + $totalCredit;

    $ActivityLog = $BankAccount."^Bank Payment^Credit^".$totalCredit."^".$voucherNo."^".$AddedBy."^".date('Y-m-d H:i:s')."^".$ip."^".$balance1."^".$finalBalance1;

    if(updateBalance($BankAccount,$finalBalance1)){

  $sql_name1 = '"AccountName","VoucherNo","Detail","DateAdded","Credit","Debit","Type","Balance","ActivityLog"';

  $sql_val1 = "'".$BankAccount."','".$voucherNo."','','".$dateAdded."','".$totalCredit."','0','".$Type."','".getBalance($BankAccount)."','".$ActivityLog."'";

  $query1 = ' Insert into vouchers."voucherMaster" ('.$sql_name1.') Values ('.$sql_val1.') ;';

    MISuploadlogger("Account Balance of Branch ".$BankAccount." is updated");

    }else{

    MISuploadlogger("Account Balance of Branch ".$BankAccount." is not updated");

    }

  // MISuploadlogger("===insert1====".$query1);

  $misinsert1 = pg_query(OpenCon(),$query1);

  $objResponse = new clsDBResponse();
  $objResponse->AccountName = $BankAccount;
  $objResponse->Amount = $totalCredit;
  $objResponse->listOfData = $inputData->ListOfTransaction;

  $ListOfJson = json_encode($objResponse,JSON_PRETTY_PRINT);

  $journal_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';

  $journal_val = "'".$voucherNo."','".$dateAdded."','".$ListOfJson."','".$transactionDate."','".$AddedBy."','BP'";

  $journal = ' Insert into vouchers."voucherEntry" ('.$journal_name.') Values ('.$journal_val.') ;';

  MISuploadlogger("===Journal Insert====".$journal);

  $journalinsert = pg_query(OpenCon(),$journal);

}

if($effectedRow > 0){
 echo "Saved Successfull";
}else{
  echo "Failed to Save";
}
?>