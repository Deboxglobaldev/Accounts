<?php

include "inc.php";

MISuploadlogger("Entering in Account Group Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$accountName = strtoupper($dataToExport->AccountName);
$subGroupId = $dataToExport->SubGroupId;
$subledgerId = $dataToExport->SubLedgerId;


class clsDataTable
{

  // public $Id;
  public $AccountName;
  public $SubGroupId;
  public $SubGroupName;
  public $SubLedgerId;
}

$arrayDataRows = array();

// ////---------------------- Extraction from DataBase --------------------------------

$DataEntryQuery = "SELECT * FROM masters.\"accountNameMaster\" WHERE true _name_subgroupId_subledgerId ORDER BY \"SubLedgerId\" ASC";

$DataEntryQuery = str_replace("_name",$accountName!=''?" and UPPER(\"accountName\") LIKE '%".$accountName."%' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_subgroupId",$subGroupId!=''?" and \"subGroupId\" LIKE '%".$subGroupId."%' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_subledgerId",$subledgerId!=''?" and \"SubLedgerId\" LIKE '%".$subledgerId."%' ":"",$DataEntryQuery );



MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

  $i=1;
  while ($dataList =  pg_fetch_assoc($getDatafromData)){

     $objDataTable = new clsDataTable();

     $objDataTable->SubLedgerId =$dataList['SubLedgerId'];
     $objDataTable->AccountName =$dataList['accountName'];
     $objDataTable->SubGroupName =getSubGroupName($dataList['subGroupId']);
     $objDataTable->SubGroupId =$dataList['subGroupId'];

     $a = array_push($arrayDataRows,$objDataTable);

     $i++;

     $total = count($arrayDataRows);

  }

echo json_encode(['status'=>0,'Total'=>$total,'Data'=>$arrayDataRows],JSON_PRETTY_PRINT);

?>