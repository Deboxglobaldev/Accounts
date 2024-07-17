<?php

include "inc.php"; 

MISuploadlogger("Entering in Update account Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$currentTime = date("Y-m-d H:i:s");

$InsertFlag = $Message = "";

$userId = $dataToExport->userId;

try{
 
    $obsUpdateQuery = "";
    $InsertQuery = "";
    $BalanceResult = 1;

foreach($dataToExport->ListOfACKO as $value) {

$DataEntryQuery = "SELECT * FROM panprogres.\"accountMaster\" WHERE true _ackno ";

$DataEntryQuery = str_replace("_ackno",$value->AcknowledgementNumber!=''?" and \"ACKNOWLEDGEMENT-NO\"='".$value->AcknowledgementNumber."' ":"",$DataEntryQuery);    

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

$dataList = pg_fetch_assoc($getDatafromData);

$countrows = pg_num_rows($getDatafromData);

if($countrows > 0){

 if(strlen($dataList['ACKNOWLEDGEMENT-NO']) == '15'){
$productType = "PAN";
 }else{
  $productType= "TAN";
 } 

$obsUpdateQuery .=" Update panprogres.\"accountMaster\" set \"FEE_FLAG\" = 1,\"APPROVED_DATE\"='_DTime',\"APPROVED_BY\"='_User' where \"ACKNOWLEDGEMENT-NO\" = '_AKNONO';";
 

$obsUpdateQuery = str_replace('_AKNONO',$dataList['ACKNOWLEDGEMENT-NO'], $obsUpdateQuery);
$obsUpdateQuery = str_replace('_DTime',$currentTime, $obsUpdateQuery);    
$obsUpdateQuery = str_replace('_User',$userId, $obsUpdateQuery);    

$updatedBalance = getBalance($dataList['BRANCH_CODE'],$productType) - round(substr($dataList['FEES'],1));

 if(updateBalance($dataList['BRANCH_CODE'],$updatedBalance,$productType)){
  $BalanceResult *=1;
 }else{
  $BalanceResult *=0;
 }

$sql_name = '"AcknowledgementNo","AccountName","DateAdded","Detail","Type","Debit","Credit","Balance","VoucherNo"';

$sql_val = "'".$dataList['ACKNOWLEDGEMENT-NO']."','".$dataList['BRANCH_CODE']."','".date("Y-m-d h:i:s",time())."','Branch','fee','0','".round(substr($dataList['FEES'],1))."','".getBalance($dataList['BRANCH_CODE'],$productType)."','".$dataList['VoucherNo']."'";

$sql_val1 = "'".$dataList['ACKNOWLEDGEMENT-NO']."','NSDL','".date("Y-m-d h:i:s",time())."','NSDL','fee','".round(substr($dataList['FEES'],1))."','0',NULL,'".$dataList['VoucherNo']."'";

$InsertQuery .=' Insert into panprogres."voucherMaster" ('.$sql_name.') Values ('.$sql_val.'),('.$sql_val1.');';

}

}

MISuploadlogger("======Update Query====".$obsUpdateQuery."\n");

MISuploadlogger("=======Insert Query====".$InsertQuery."\n");

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