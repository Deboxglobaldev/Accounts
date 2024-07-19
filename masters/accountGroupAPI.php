<?php

include "inc.php";

MISuploadlogger("Entering in Account Group Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$name = strtoupper($dataToExport->name);
$accountGroup = $dataToExport->accountGroup;
$status = $dataToExport->status;

class clsDataTable
{

  public $Number;
  public $Id;
  public $Name;
  public $TypeName;
  public $TypeId;
}

$arrayDataRows = array();

// ////---------------------- Extraction from DataBase --------------------------------

$DataEntryQuery = "SELECT * FROM masters.\"accountGroupMaster\" WHERE true _accGrp _name ORDER BY \"Id\" ASC";

$DataEntryQuery = str_replace("_accGrp",$accountGroup!=''?" and \"TypeId\"='".$accountGroup."' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_name",$name!=''?" and UPPER(\"Name\") LIKE '%".$name."%' ":"",$DataEntryQuery );


MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

  $i=1;
  while ($dataList =  pg_fetch_assoc($getDatafromData)){

     $objDataTable = new clsDataTable();

     $objDataTable->Number =$i;
     $objDataTable->Id =$dataList['Id'];
     $objDataTable->Name =$dataList['Name'];
     $objDataTable->TypeName =getTypeName($dataList['TypeId']);
     $objDataTable->TypeId =$dataList['TypeId'];

     $a = array_push($arrayDataRows,$objDataTable);

     $i++;

  }

  $totalRecords = count($arrayDataRows);

  echo json_encode(['status' => 0, 'totalRecords' => $totalRecords, 'AccountGroupData' => $arrayDataRows], JSON_PRETTY_PRINT);

?>