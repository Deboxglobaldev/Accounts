<?php

include "inc.php";

MISuploadlogger("*********************   Inside Get Account Activity Log API *******************************");

define("INF","{INFO} -");
define ("ERR","{ERROR} -");
define ("DBG","{DEBUG} -");


header("Content-Type: application/json");

$parameterdata = file_get_contents('php://input');

$parameterdata = str_replace("null","\"\"",$parameterdata);

MISuploadlogger(DBG."Parameter Json \n".$parameterdata);

class clsDBResponse
{
    public $Status;
    public $DataTable=array();
}

class clsDataTable
{
    public $AccountCode;
    public $AccountName;
    public $UserName;
    public $Amount;
    public $AmountType;
    public $VoucherType;
    public $VoucherDate;
    public $Voucher;
    public $DateTime;
	public $IPAddress;
    public $Balance;
}


$dataToExtract= json_decode($parameterdata);

$voucherNo = $dataToExtract->voucherNo;
$accountCode = $dataToExtract->accountCode;
$fromDate = $dataToExtract->fromDate;
$toDate = $dataToExtract->toDate;

$sqlQuery = "select \"ActivityLog\" FROM vouchers.\"voucherMaster\" WHERE true _vouch _acc _from _to order by \"Id\" ASC ";

$sqlQuery = str_replace("_vouch",$voucherNo!=''?" and \"VoucherNo\" = '".$voucherNo."' ":"",$sqlQuery);

$sqlQuery = str_replace("_acc",$accountCode!=''?" and \"AccountName\" = '".$accountCode."' ":"",$sqlQuery);

$sqlQuery = str_replace("_from",$fromDate!=''?" and \"DateAdded\" >= '".$fromDate."' ":"",$sqlQuery);

$sqlQuery = str_replace("_to",$toDate!=''?" and \"DateAdded\" <= '".$toDate."' ":"",$sqlQuery);

    MISuploadlogger(DBG."Query to extract \n".$sqlQuery);

try
{

  $arrayDataRows = array();

  $RecordSet = pg_query(OpenCon(), $sqlQuery);

  $Rowcount = pg_num_rows($RecordSet);

if ($Rowcount > 0) {


    while($dataList =pg_fetch_assoc($RecordSet)){
    $data = explode('|', $dataList['ActivityLog']);
    $i=1;
	 foreach ($data as $key => $value) {

		$row = explode('^', $value);

    $selQry =  "select \"FirstName\",\"LastName\" FROM panprogres.\"userMaster\" WHERE \"Id\"= '_ID'";
    $selQry = str_replace('_ID',$row[5],$selQry);
    $result = pg_query(OpenCon(), $selQry);

    if (pg_affected_rows($result) > 0) {
      $resultData = pg_fetch_assoc($result);
      $user_id = $resultData['FirstName'].' '.$resultData['LastName'];
    }


    $objDataTable = new  clsDataTable();
    $objDataTable->AccountCode = $row[0];
    $objDataTable->AccountName = getAccountFromId($row[0]);
    $objDataTable->UserName = $user_id;
    $objDataTable->Amount = $row[3];
    $objDataTable->AmountType = $row[2];
    $objDataTable->VoucherType = $row[1];
    $objDataTable->VoucherDate = $row[10];
    $objDataTable->Voucher = $row[4];
    $objDataTable->DateTime = $row[6];
    $objDataTable->IPAddress = $row[7];
    $objDataTable->Balance = "Balance Updated from ".$row[8]." to ".$row[9];

	    $a = array_push($arrayDataRows,$objDataTable);

        $i++;
        $user_id= '';
	 }
	}
}

      $dberror = pg_last_error(OpenCon());
      if (!$dberror)
      {
          MISuploadlogger("****************************************************");
          MISuploadlogger($dberror);
          MISuploadlogger("===================================================");

      }
      else
      {
          MISuploadlogger("Database operation is Successful....");
      }

       $objResponse->Status = "0";
       $objResponse->listOfData = $arrayDataRows;

}catch (Exception $e){
  $objResponse->Status = "-1";
  MISuploadlogger( " Exception error ===>  ". $e->getMessage());
}

finally
{
    echo json_encode($objResponse,JSON_PRETTY_PRINT);
}


?>