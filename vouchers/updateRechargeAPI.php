<?php

include "inc.php";

MISuploadlogger("Entering in Update Branch Recharge Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$InsertFlag = $Message = "";

$currentTime = date("Y-m-d H:i:s");

$userId = $dataToExport->userId;

$ip = $dataToExport->ip;

try{

    $obsUpdateQuery = "";
    $InsertQuery = "";

foreach($dataToExport->ListOfVoucher as $value) {

$DataEntryQuery = "SELECT * FROM vouchers.\"branchWalletMaster\" WHERE true _voucher";

$DataEntryQuery = str_replace("_voucher",$value->voucherNumber!=''?" and \"voucherNo\"='".$value->voucherNumber."' ":"",$DataEntryQuery );

MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

$dataList = pg_fetch_assoc($getDatafromData);

$rechargeAmnt = $dataList['credit'];
$branchCode = $dataList['branchCode'];
$productType = $dataList['productType'];
$voucherNo = $dataList['voucherNo'];
$religareBankName = $dataList['religareBankName'];

$countrows = pg_num_rows($getDatafromData);

if($countrows > 0){

$obsUpdateQuery .=" Update vouchers.\"branchWalletMaster\" set \"walletFlag\" = 1, \"approvedDate\"='_DTime', \"approvedBy\"='_USER' where \"voucherNo\" = '_voucher';";

$obsUpdateQuery = str_replace('_voucher',$dataList['voucherNo'], $obsUpdateQuery);
$obsUpdateQuery = str_replace('_DTime',$currentTime, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_USER',$userId, $obsUpdateQuery);

$result = pg_query(OpenCon(),$obsUpdateQuery);

$Balance = getBalance($branchCode);

$Balance1 = getBalance($religareBankName);

$updatedBalance = $Balance + $rechargeAmnt;

$BalanceResult = updateBalance($branchCode,$updatedBalance);

$updatedBalance1 = $Balance1 - $rechargeAmnt;

$BalanceResult1 = updateBalance($religareBankName,$updatedBalance1);

$ActivityLog = $branchCode."^Wallet Recharge^Credit^".$rechargeAmnt."^".$voucherNo."^".$userId."^".date('Y-m-d H:i:s')."^".$ip."^".$Balance."^".$updateBalance;

$ActivityLog1 = $religareBankName."^Wallet Recharge^Debit^".$rechargeAmnt."^".$voucherNo."^".$userId."^".date('Y-m-d H:i:s')."^".$ip."^".$Balance1."^".$updatedBalance1;

$sql_name = '"AccountName","DateAdded","Detail","Type","Credit","Debit","Balance","VoucherNo","ActivityLog"';

$sql_val = "'".$branchCode."','".date("Y-m-d h:i:s",time())."','Branch','recharge','".$rechargeAmnt."','0','".getBalance($branchCode)."','".$voucherNo."','".$ActivityLog."'";

$sql_val1 = "'".$religareBankName."','".date("Y-m-d h:i:s",time())."','Wallet Recharge','recharge','0','".$rechargeAmnt."','".getBalance($religareBankName)."','".$voucherNo."','".$ActivityLog1."'";

$InsertQuery .= ' Insert into vouchers."voucherMaster" ('.$sql_name.') Values ('.$sql_val.'),('.$sql_val1.') ;';

}

}

// MISuploadlogger("======Update Query====".$obsUpdateQuery."\n");

// MISuploadlogger("=======Insert Query====".$InsertQuery."\n");

$result = pg_query(OpenCon(),$obsUpdateQuery);

$effectedUpdatedRow=pg_affected_rows($result);

if($effectedUpdatedRow > 0){

$Status = "0";

$Message = "Update Successful";

$MisInsert = pg_query(OpenCon(),$InsertQuery);

$effectedInsertRow=pg_affected_rows($MisInsert);

if($effectedInsertRow > 0){

$InsertFlag = "Insert Successful";

}

}else{

$Status = "1";

$Message = "Update Not Successful";

$InsertFlag = "Insert Not Successful";

}

}
catch(Exception $e){
  $Status = "-1";
    MISuploadlogger( " Exception in Update Account API  ===>  ". $e->getMessage());
}

finally
{

echo json_encode(['Status'=>$Status,'Message'=>$Message,'Insertflag'=>$InsertFlag,'BalanceUpdated'=>$BalanceResult],JSON_PRETTY_PRINT);

}

?>