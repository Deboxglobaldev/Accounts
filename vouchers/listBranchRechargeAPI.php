<?php

include "inc.php";

MISuploadlogger("Entering in Branch Wallet List Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$fromDate = $dataToExport->fromDate=='1970-01-01'?'':$dataToExport->fromDate;
$toDate = $dataToExport->toDate=='1970-01-01'?'':$dataToExport->toDate;
$BranchCode = $dataToExport->branchCode;
$VoucherNo = $dataToExport->voucherNo;
// $ProductType = $dataToExport->productType;

class clsDataTable
{

  public $Number;
  public $Id;
  public $VoucherNo;
  public $BankAccount;
  public $VoucherDate;
  public $BranchCode;
  public $Credit;
  public $Cheque;
  public $ChequeDate;
  public $Narration;
  public $BankName;
  public $Attachment;
  public $Status;
  public $WalletFlag;
  public $ReligareBankName;
  public $AddedBy;
  public $AddedDate;
  public $ApprovedBy;
  public $ApprovedDate;

}

$arrayDataRows = array();

// ////---------------------- Extraction from DataBase --------------------------------

$DataEntryQuery = "SELECT * FROM vouchers.\"branchWalletMaster\" WHERE \"status\"=0 AND \"walletFlag\"=0 _branch _from _to _voucher ORDER BY \"Id\" ASC";

  $DataEntryQuery = str_replace("_from",$fromDate!=''?" and CAST(\"dateAdded\" AS DATE) >='".$fromDate."' ":"",$DataEntryQuery );
  $DataEntryQuery = str_replace("_to",$toDate!=''?" and CAST(\"dateAdded\" AS DATE) <='".$toDate."' ":"",$DataEntryQuery );
  $DataEntryQuery = str_replace("_voucher",$VoucherNo!=''?" and \"voucherNo\"='".$VoucherNo."' ":"",$DataEntryQuery );
  $DataEntryQuery = str_replace("_branch",$BranchCode!=''?" and \"branchCode\"='".$BranchCode."' ":"",$DataEntryQuery);
  // $DataEntryQuery = str_replace("_product",$ProductType!=''?" and \"productType\"='".$ProductType."' ":"",$DataEntryQuery);


MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

$countrows = pg_num_rows($getDatafromData);
if($countrows > 0){
  $i=1;
  while ($dataList =  pg_fetch_assoc($getDatafromData)){

    $ChequeDate = ($dataList['chequeDate'] == '' || $dataList['chequeDate'] == '1970-01-01')?'':$dataList['chequeDate'];


     $objDataTable = new clsDataTable();

     $objDataTable->Number =$i;
     $objDataTable->Id =$dataList['Id'];
     $objDataTable->VoucherNo =$dataList['voucherNo'];
     $objDataTable->BankAccount = $dataList['bankAccount'];
     $objDataTable->VoucherDate = $dataList['voucherDate'];
     $objDataTable->BranchCode = getAccountFromId($dataList['branchCode']);
     $objDataTable->Credit = $dataList['credit'];
     $objDataTable->Cheque = $dataList['cheque'];
     $objDataTable->ChequeDate = $ChequeDate;
     $objDataTable->Narration = $dataList['narration'];
     $objDataTable->BankName = $dataList['bankName'];
     $objDataTable->Attachment = $dataList['attachment'];
     $objDataTable->Status = $dataList['status'];
     $objDataTable->WalletFlag = $dataList['walletFlag'];
     $objDataTable->ReligareBankName = getAccountFromId($dataList['religareBankName']);
     $objDataTable->AddedBy = getUserId($dataList['addedBy']);
     $objDataTable->AddedDate = $dataList['dateAdded'];
     $objDataTable->ApprovedBy = getUserId($dataList['approvedBy']);
     $objDataTable->ApprovedDate = $dataList['approvedDate'];

     $a = array_push($arrayDataRows,$objDataTable);

     $i++;

  }

}


echo json_encode(['status'=>0,'WalletData'=>$arrayDataRows],JSON_PRETTY_PRINT);

?>