<?php

include "inc.php";

MISuploadlogger("Entering in Account Group Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$accountName = strtoupper($dataToExport->AccountName);
$groupId = $dataToExport->GroupId;
$notGroupId = $dataToExport->notGroupId;
$status = $dataToExport->Status;

class clsDataTable
{

  // public $Id;
  public $SubLedgerId;
  public $AccountName;
  public $SubGroupName;
  public $SubGroupId;
  public $GroupType;
  public $Status;
}

$arrayDataRows = array();

// ////---------------------- Extraction from DataBase --------------------------------

$DataEntryQuery = "SELECT * FROM masters.\"accountNameMaster\" WHERE true _status _accGrp _name _ntaccGrp ORDER BY \"SubLedgerId\" ASC";

$DataEntryQuery = str_replace("_accGrp",$groupId!=''?" and \"subGroupId\"='".$groupId."' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_ntaccGrp",$notGroupId!=''?" and \"subGroupId\"!='".$notGroupId."' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_name",$accountName!=''?" and UPPER(\"accountName\") LIKE '%".$accountName."%' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_status",$status!=''?" and \"status\"='".$status."' ":"",$DataEntryQuery );


MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

  $i=1;
  while ($dataList =  pg_fetch_assoc($getDatafromData)){

     $objDataTable = new clsDataTable();

     $objDataTable->SubLedgerId =$dataList['SubLedgerId'];
     $objDataTable->AccountName =$dataList['accountName'];
     $objDataTable->SubGroupName =getSubGroupName($dataList['subGroupId']);
     $objDataTable->SubGroupId =$dataList['subGroupId'];
     $objDataTable->GroupType =$dataList['groupType'];
     $objDataTable->Status =$dataList['status'];

     $a = array_push($arrayDataRows,$objDataTable);

     $i++;

     $total = count($arrayDataRows);

  }



echo json_encode(['status'=>0,'Total'=>$total,'AccountNameData'=>$arrayDataRows],JSON_PRETTY_PRINT);

?>