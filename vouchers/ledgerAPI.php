<?php
include "inc.php";

header("Content-Type: application/json");
MISuploadlogger("Entering in VOUCHER API");

$parameterdata = file_get_contents('php://input');
$parameterdata = str_replace("null","\"\"",$parameterdata);
MISuploadlogger($parameterdata);
$dataToExport = json_decode($parameterdata);

$Type = $dataToExport->Type;
$Branch = $dataToExport->Branch;
$fromDate = $dataToExport->fromDate;
$toDate = $dataToExport->toDate;

class clsSummaryData
{
	public $LedgerList = array();
}

class clsListData
{
	public $VoucherNo;
	public $Date;
	public $AccountName;
	public $BillNo;
	public $BillPeriodId;
	public $Detail;
	public $Debit;
	public $Credit;
	public $Balance;
	public $AckNo;
	public $Type;
}

$listArray=array();
try
{
	$listSql = "SELECT * FROM vouchers.\"voucherMaster\" WHERE true _from _to _branch ORDER BY \"Id\" ";

	if($Type == 'Branch'){
		$listSql = str_replace("_branch",$Branch!=''?" and \"AccountName\"='".$Branch."' ":"",$listSql );
	}else{
		$listSql = str_replace("_branch",$Branch!=''?" and \"AccountName\"='".$Branch."' ":"",$listSql);
	}

	// $listSql = str_replace("_type",($Type!='Religare' && $Type!='')?" and \"Detail\"='".$Type."' ":"",$listSql );
	$listSql = str_replace("_from",($fromDate!='' && $fromDate != '1970-01-01')?" and CAST(\"DateAdded\" AS DATE) >='".$fromDate."' ":"",$listSql );
	$listSql = str_replace("_to",($toDate!='' && $toDate != '1970-01-01')?" and CAST(\"DateAdded\" AS DATE) <='".$toDate."' ":"",$listSql );

 	MISuploadlogger("Query to get the list of Ledger \n".$listSql);

	$DataQuery = pg_query(OpenCon(), $listSql);

	if(!$DataQuery)
	{
		MISuploadlogger("Inside Excpeton throw Condition");
		throw new Exception("Error in Query -- ");
	}

	while($DataList = pg_fetch_object($DataQuery)){

		// if($Type == 'Branch'){

			$objListData = new clsListData();
			$objListData->VoucherNo = $DataList->VoucherNo;
			$objListData->Date = $DataList->DateAdded;
			$objListData->Detail= $DataList->Detail;
			$objListData->Debit= $DataList->Debit;
			$objListData->Credit= $DataList->Credit;
			$objListData->Balance= $DataList->Balance < 0?abs($DataList->Balance)." Dr":$DataList->Balance." Cr";
			$objListData->AckNo= $DataList->AcknowledgementNo;
			$objListData->Type = $DataList->Type;
			$objListData->AccountName= $DataList->AccountName;
			$objListData->BillPeriodId= $DataList->BillPeriodId;
			$objListData->BillNo= $DataList->BillNo;
			$a=array_push($listArray, $objListData);
		// }else{
		//     $objListData = new clsListData();
		// 	$objListData->Date = $DataList->DateAdded;
		// 	$objListData->Detail= $DataList->Detail;
		// 	$objListData->Debit= $DataList->Debit;
		// 	$objListData->Credit= $DataList->Credit;
		// 	$objListData->Balance= $DataList->Balance;
		// 	$objListData->AckNo= $DataList->AcknowledgementNo;
		// 	$objListData->BranchCode= $DataList->BranchCode;
		// 	$a=array_push($listArray, $objListData);

		// }

	}
	$objSummaryData = new clsSummaryData();
	$objSummaryData->LedgerList= $listArray;

	echo json_encode($objSummaryData,JSON_PRETTY_PRINT);
	// echo json_encode(['Status'=>'0','Message'=>'Success','Rejectionlist'=>$objSummaryData],JSON_PRETTY_PRINT);
}
catch(Exception $e)
{
	MISuploadlogger ("Error in Query ...." .$e);
	echo json_encode(['Status'=>'-1','Message'=>'Failed','LedgerList'=>""],JSON_PRETTY_PRINT);
}

?>