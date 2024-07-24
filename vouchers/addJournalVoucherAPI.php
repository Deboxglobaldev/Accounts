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

$effectedRow = 0;

$dateAdded = $inputData->VoucherDate." ".date('H:i:s',time());
$transactionDate = $inputData->EntryDate;
// $Narration = $inputData->Narration;
// $FundType = $inputData->FundType;
$AddedBy = $inputData->UserId;
$ip = $inputData->ip;
$ListOfJson = json_encode($inputData->ListOfTransaction);
$voucherNo = "JV-".date('dmy')."-".GetVoucherSequenceOftheDay();
$Type = "journalVoucher";

foreach ($inputData->ListOfTransaction as $value) {

 $balance = getBalance($value->AccountName);

if($value->Credit != '0' && $value->Credit != ''){
$finalBalance = $balance + $value->Credit;
$TransferType = "Credit";
$Amount = $value->Credit;
}
if($value->Debit != '0' && $value->Debit != ''){
$finalBalance = $balance - $value->Debit;
$TransferType = "Debit";
$Amount = $value->Debit;
}

if(updateBalance($value->AccountName,$finalBalance)){

    $ActivityLog = $value->AccountName."^Journal Voucher^".$TransferType."^".$Amount."^".$voucherNo."^".$AddedBy."^".date('Y-m-d H:i:s')."^".$ip."^".$balance."^".$finalBalance;

  $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type","Balance","ActivityLog"';

  $sql_val = "'".$value->AccountName."','".$voucherNo."','".$value->Narration."','".$dateAdded."','".$value->Debit."','".$value->Credit."','".$Type."','".getBalance($value->AccountName)."','".$ActivityLog."'";

$query = ' Insert into vouchers."voucherMaster" ('.$sql_name.') Values ('.$sql_val.') ;';

  MISuploadlogger("Account Balance of Branch ".$value->AccountName." is updated");

}else{
    MISuploadlogger("Account Balance of Branch ".$value->AccountName." is not updated");
}

// MISuploadlogger("===insert====".$query);

$misinsert = pg_query(OpenCon(),$query);

$effectedRow+=pg_affected_rows($misinsert);

      $dberror = pg_last_error(OpenCon());

    if (!$dberror)
    {
        MISuploadlogger("Database error***".$dberror);

    }
    else
    {
        MISuploadlogger("Database operation is Successful....");
    }

}



$journal_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';

$journal_val = "'".$voucherNo."','".$dateAdded."','".$ListOfJson."','".$transactionDate."','".$AddedBy."','JV'";

$journal = ' Insert into vouchers."voucherEntry" ('.$journal_name.') Values ('.$journal_val.') ;';

MISuploadlogger("===Journal Insert====".$journal);

$journalinsert = pg_query(OpenCon(),$journal);

if($effectedRow > 0){
 echo "Saved Successfull";
}else{
  echo "Failed to Save";
}
?>