<?php
include "inc.php";

MISuploadlogger("Entering in Edit/Delete Branch Recharge Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);


$currentTime = date("Y-m-d H:i:s");
$editId = $dataToExport->editId;
$bankName = $dataToExport->bankName;
$attachment = $dataToExport->attachment;
$chequeDate = $dataToExport->chequeDate;
$chequeNo = $dataToExport->chequeNo;
$bankAc = $dataToExport->bankAc;
$productType = $dataToExport->productType;
$userId = $dataToExport->userId;
$credit = $dataToExport->credit;
$narration = $dataToExport->narration;
$type = $dataToExport->type;

if($type == 'delete'){
$obsUpdateQuery ="UPDATE vouchers.\"branchWalletMaster\" SET \"status\"=1 WHERE \"Id\" = '_editId';";

$obsUpdateQuery = str_replace('_editId',$editId, $obsUpdateQuery);

MISuploadlogger("Query for delete stage : ".$obsUpdateQuery);

$result = pg_query(OpenCon(),$obsUpdateQuery);

$count = pg_affected_rows($result);

    if ($count > 0)
    {
       echo "Delete Successful";

    }else{

       echo "Not Successful";
  }

}else
{

$obsUpdateQuery ="UPDATE vouchers.\"branchWalletMaster\" SET \"bankAccount\"='_abank',\"credit\"='_credit',\"cheque\"='_cheque',\"chequeDate\"='_dcheque',\"narration\"='_narration',\"attachment\"='_attach',\"bankName\"='_nbank',\"productType\"='',\"updatedBy\"='_user',\"updateDate\"='_DTime',\"productType\"='_prod' WHERE \"Id\" = '_editId';";

$obsUpdateQuery = str_replace('_editId',$editId, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_user',$userId, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_DTime',$currentTime, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_abank',$bankAc, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_credit',$credit, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_cheque',$chequeNo, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_dcheque',$chequeDate, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_narration',$narration, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_nbank',$bankName, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_prod',$productType, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_attach',$attachment, $obsUpdateQuery);

MISuploadlogger("Query for update stage : ".$obsUpdateQuery);

$result = pg_query(OpenCon(),$obsUpdateQuery);

$count = pg_affected_rows($result);

    if ($count > 0)
    {
       echo "Update Successful";
    }else{
       echo "Not Successful";
     }

}


?>