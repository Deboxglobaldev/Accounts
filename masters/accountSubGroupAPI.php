<?php

include "inc.php"; 

MISuploadlogger("Entering in Account Sub Group Page");

header("Content-Type: application/json");
$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$name = strtoupper($dataToExport->name);
$accountGroup = $dataToExport->accountGroup;

class clsDataTable
{

  public $Number;
  public $Id;
  public $Name;
  public $GroupName;
  public $GroupId;
}

$arrayDataRows = array();

// ////---------------------- Extraction from DataBase --------------------------------

$DataEntryQuery = "SELECT * FROM panprogres.\"accountSubGroupMaster\" WHERE true _accGrp _name ORDER BY \"LedgerId\" ASC";

$DataEntryQuery = str_replace("_accGrp",$accountGroup!=''?" and \"GroupId\"='".$accountGroup."' ":"",$DataEntryQuery );

$DataEntryQuery = str_replace("_name",$name!=''?" and UPPER(\"Name\") LIKE '%".$name."%' ":"",$DataEntryQuery );


MISuploadlogger("Query to extract the records-----\n".$DataEntryQuery);    

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

  $i=1;
  while ($dataList =  pg_fetch_assoc($getDatafromData)){

     $objDataTable = new clsDataTable();

     $objDataTable->Number =$i;
     $objDataTable->Id =$dataList['LedgerId'];
     $objDataTable->Name =$dataList['Name'];
     $objDataTable->GroupName =getGroupName($dataList['GroupId']);
     $objDataTable->GroupId =$dataList['GroupId'];
     
     $a = array_push($arrayDataRows,$objDataTable);

     $i++;

  }



echo json_encode(['status'=>0,'AccountSubGroupData'=>$arrayDataRows],JSON_PRETTY_PRINT);

?>