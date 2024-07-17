<?php
include "inc.php";
header("Content-Type: application/json");

MISuploadlogger("Inside account MasterAPI log--");

$pageSize = 5000;
$effectedRow = 0;
$querySQL = '(SELECT "NSDL-PAN-MIS-STRING" AS "misstring" FROM panprogres."tbl_pan_master" WHERE "AREACODE" IS NULL AND SUBSTRING("AKNW-DATE",5,4) = \'2024\' AND "ISBILL" = \'0\' LIMIT 20000) UNION (SELECT "NSDL-TAN-MIS-STRING" AS "misstring" FROM panprogres."tbl_tan_master" WHERE "AREACODE" IS NULL AND SUBSTRING("AKNW-DATE",5,4) = \'2024\' AND "ISBILL" = \'0\' LIMIT 20000)';

// $querySQL = "SELECT \"NSDL-TAN-MIS-STRING\" AS misstring FROM panprogres.\"tbl_tan_master\" WHERE \"AREACODE\" IS NULL AND SUBSTRING(\"AKNW-DATE\",5,4) = '2024' LIMIT 10000";

$res = pg_query(OpenCon(), $querySQL);

$TotalUpload = pg_num_rows($res);
$countrest = $TotalUpload - ($TotalUpload % $pageSize);
$i = 1;
$query = '';
if ($TotalUpload > 0) {

	while ($dataList =  pg_fetch_assoc($res)) {

		if ($i > $countrest) {			
			$MyMisData = explode("^", $dataList['misstring']);
			$akno = $MyMisData[2];

			if (substr($akno, 0, 2) == '83') {
				$bCode = substr($akno, 0, 7);
			} else {
				$bCode = substr($akno, 0, 5);
			}

			// if(BranchExists($bCode)){

			if (strlen($akno) == '15') {
				$ackdate = substr($MyMisData[3], 4, 4) . '-' . substr($MyMisData[3], 2, 2) . '-' . substr($MyMisData[3], 0, 2);
				$Type = "PAN";
				$panFees = $fees = $MyMisData[11];
				$tanFees = 0;
				$panLength = 1;
				$tanLength = 0;
			} else {
				$ackdate = substr($MyMisData[3], 0, 4) . '-' . substr($MyMisData[3], 4, 2) . '-' . substr($MyMisData[3], 6, 2);
				$Type = "TAN";
				$tanFees = $fees = $MyMisData[11];
				$panFees = 0;
				$tanLength = 1;
				$panLength = 0;
			}


			// $catego = $MyMisData[15];
			// $formtype =  $MyMisData[12];

			$checkBillQuery = "SELECT \"ACKNOWLEDGEMENT-NO\" FROM panprogres.\"bill_detail_info\" WHERE \"ACKNOWLEDGEMENT-NO\" = '_akno';";

			$checkBillQuery = str_replace("_akno", $akno, $checkBillQuery);

			$getDatafromBill = pg_query(OpenCon(), $checkBillQuery);

			$billExists = pg_num_rows($getDatafromBill);

			if ($billExists == 0) {

				$accActivitylog = "|" . $akno . "^Automate^Fee^" . date('Y-m-d H:i:s') . "^Automate";

				$sql_name = '"ACKNOWLEDGEMENT-NO","FEES","DATE_ADDED","BRANCH_CODE","TYPE","ACTIVITY_LOG"';
				$sql_val = "'" . $akno . "','" . $fees . "','" . $ackdate . "','" . $bCode . "','" . $Type . "','" . $accActivitylog . "'";
				$query .= ' Insert into panprogres."bill_detail_info" (' . $sql_name . ') Values (' . $sql_val . ');';


				$DataEntryQuery = "SELECT \"Id\",\"panTotal\",\"panCount\",\"tanTotal\",\"tanCount\" FROM panprogres.\"bill_cycle_info\" WHERE \"isApproved\"= 0 AND \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' AND \"branchCode\" = '_bname';";

				$DataEntryQuery = str_replace("_adate", $ackdate, $DataEntryQuery);
				$DataEntryQuery = str_replace("_bname", $bCode, $DataEntryQuery);

				$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

				$cycleExists = pg_num_rows($getDatafromData);

				$dataList = pg_fetch_object($getDatafromData);

				if ($cycleExists < 1) {

					$billPeriod = "SELECT \"fromDate\",\"toDate\" FROM panprogres.\"billInformationMaster\" WHERE \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' ;";

					$billPeriod = str_replace("_adate", $ackdate, $billPeriod);

					$getPeriodfromData = pg_query(OpenCon(), $billPeriod);

					$periodList = pg_fetch_object($getPeriodfromData);

					$fdate = $periodList->fromDate;
					$tdate = $periodList->toDate;

					$entry_name = '"fromDate","toDate","branchCode","panTotal","panCount","tanTotal","tanCount"';
					$entry_val = "'" . $fdate . "','" . $tdate . "','" . $bCode . "','" . $panFees . "','" . $panLength . "','" . $tanFees . "','" . $tanLength . "'";
					$entry = ' Insert into panprogres."bill_cycle_info" (' . $entry_name . ') Values (' . $entry_val . ')';
					$entryinsert = pg_query(OpenCon(), $entry);
				} else {

					$editId = $dataList->Id;

					$panTotal = $dataList->panTotal + $panFees;

					$panCount = $dataList->panCount + $panLength;

					$tanTotal = $dataList->tanTotal + $tanFees;

					$tanCount = $dataList->tanCount + $tanLength;

					$obsUpdateQuery = " Update panprogres.\"bill_cycle_info\" set \"panTotal\" = '_pantotal',\"panCount\"='_pancount',\"tanTotal\" = '_tantotal',\"tanCount\"='_tancount' where \"Id\" = '_aid';";

					$obsUpdateQuery = str_replace('_aid', $editId, $obsUpdateQuery);
					$obsUpdateQuery = str_replace('_pancount', $panCount, $obsUpdateQuery);
					$obsUpdateQuery = str_replace('_pantotal', $panTotal, $obsUpdateQuery);
					$obsUpdateQuery = str_replace('_tancount', $tanCount, $obsUpdateQuery);
					$obsUpdateQuery = str_replace('_tantotal', $tanTotal, $obsUpdateQuery);

					$result = pg_query(OpenCon(), $obsUpdateQuery);
				}
			}

			$obsPanQuery = " Update panprogres.\"tbl_pan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

			$obsPanQuery = str_replace('_aid', $akno, $obsPanQuery);
			$obsPanResult = pg_query(OpenCon(), $obsPanQuery);

			$obsTanQuery = " Update panprogres.\"tbl_tan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

			$obsTanQuery = str_replace('_aid', $akno, $obsTanQuery);
			$obsTanResult = pg_query(OpenCon(), $obsTanQuery);
			// }

		} else {
			if ($i % $pageSize > 0) {				
				$MyMisData = explode("^", $dataList['misstring']);
				$akno = $MyMisData[2];
				$ackdate = substr($MyMisData[3], 4, 4) . '-' . substr($MyMisData[3], 2, 2) . '-' . substr($MyMisData[3], 0, 2);

				if (substr($akno, 0, 2) == '83') {
					$bCode = substr($akno, 0, 7);
				} else {
					$bCode = substr($akno, 0, 5);
				}

				// if(BranchExists($bCode)){

				if (strlen($akno) == '15') {
					$ackdate = substr($MyMisData[3], 4, 4) . '-' . substr($MyMisData[3], 2, 2) . '-' . substr($MyMisData[3], 0, 2);
					$Type = "PAN";
					$panFees = $fees = $MyMisData[11];
					$tanFees = 0;
					$panLength = 1;
					$tanLength = 0;
				} else {
					$ackdate = substr($MyMisData[3], 0, 4) . '-' . substr($MyMisData[3], 4, 2) . '-' . substr($MyMisData[3], 6, 2);
					$Type = "TAN";
					$tanFees = $fees = $MyMisData[11];
					$panFees = 0;
					$tanLength = 1;
					$panLength = 0;
				}
				// $catego = $MyMisData[15];
				// $formtype =  $MyMisData[12];

				$checkBillQuery = "SELECT \"ACKNOWLEDGEMENT-NO\" FROM panprogres.\"bill_detail_info\" WHERE \"ACKNOWLEDGEMENT-NO\" = '_akno';";

				$checkBillQuery = str_replace("_akno", $akno, $checkBillQuery);

				$getDatafromBill = pg_query(OpenCon(), $checkBillQuery);

				$billExists = pg_num_rows($getDatafromBill);

				if ($billExists == 0) {

					$accActivitylog = "|" . $akno . "^Automate^Fee^" . date('Y-m-d H:i:s') . "^Automate";

					$sql_name = '"ACKNOWLEDGEMENT-NO","FEES","DATE_ADDED","BRANCH_CODE","TYPE","ACTIVITY_LOG"';
					$sql_val = "'" . $akno . "','" . $fees . "','" . $ackdate . "','" . $bCode . "','" . $Type . "','" . $accActivitylog . "'";
					$query .= ' Insert into panprogres."bill_detail_info" (' . $sql_name . ') Values (' . $sql_val . ');';


					$DataEntryQuery = "SELECT \"Id\",\"panTotal\",\"panCount\",\"tanTotal\",\"tanCount\" FROM panprogres.\"bill_cycle_info\" WHERE \"isApproved\"= 0 AND \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' AND \"branchCode\" = '_bname';";

					$DataEntryQuery = str_replace("_adate", $ackdate, $DataEntryQuery);
					$DataEntryQuery = str_replace("_bname", $bCode, $DataEntryQuery);

					$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

					$cycleExists = pg_num_rows($getDatafromData);

					$dataList = pg_fetch_object($getDatafromData);

					if ($cycleExists < 1) {

						$billPeriod = "SELECT \"fromDate\",\"toDate\" FROM panprogres.\"billInformationMaster\" WHERE \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' ;";

						$billPeriod = str_replace("_adate", $ackdate, $billPeriod);

						$getPeriodfromData = pg_query(OpenCon(), $billPeriod);

						$periodList = pg_fetch_object($getPeriodfromData);

						$fdate = $periodList->fromDate;
						$tdate = $periodList->toDate;

						$entry_name = '"fromDate","toDate","branchCode","panTotal","panCount","tanTotal","tanCount"';
						$entry_val = "'" . $fdate . "','" . $tdate . "','" . $bCode . "','" . $panFees . "','" . $panLength . "','" . $tanFees . "','" . $tanLength . "'";
						$entry = ' Insert into panprogres."bill_cycle_info" (' . $entry_name . ') Values (' . $entry_val . ')';
						$entryinsert = pg_query(OpenCon(), $entry);
					} else {

						$editId = $dataList->Id;

						$panTotal = $dataList->panTotal + $panFees;

						$panCount = $dataList->panCount + $panLength;

						$tanTotal = $dataList->tanTotal + $tanFees;

						$tanCount = $dataList->tanCount + $tanLength;

						$obsUpdateQuery = " Update panprogres.\"bill_cycle_info\" set \"panTotal\" = '_pantotal',\"panCount\"='_pancount',\"tanTotal\" = '_tantotal',\"tanCount\"='_tancount' where \"Id\" = '_aid';";

						$obsUpdateQuery = str_replace('_aid', $editId, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_pancount', $panCount, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_pantotal', $panTotal, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_tancount', $tanCount, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_tantotal', $tanTotal, $obsUpdateQuery);

						$result = pg_query(OpenCon(), $obsUpdateQuery);
					}
				}

				// }

				$obsPanQuery = " Update panprogres.\"tbl_pan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

				$obsPanQuery = str_replace('_aid', $akno, $obsPanQuery);
				$obsPanResult = pg_query(OpenCon(), $obsPanQuery);

				$obsTanQuery = " Update panprogres.\"tbl_tan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

				$obsTanQuery = str_replace('_aid', $akno, $obsTanQuery);
				$obsTanResult = pg_query(OpenCon(), $obsTanQuery);
			} else {
				$MyMisData = explode("^", $dataList['misstring']);
				$akno = $MyMisData[2];
				$ackdate = substr($MyMisData[3], 4, 4) . '-' . substr($MyMisData[3], 2, 2) . '-' . substr($MyMisData[3], 0, 2);

				if (substr($akno, 0, 2) == '83') {
					$bCode = substr($akno, 0, 7);
				} else {
					$bCode = substr($akno, 0, 5);
				}

				// if(BranchExists($bCode)){

				if (strlen($akno) == '15') {
					$ackdate = substr($MyMisData[3], 4, 4) . '-' . substr($MyMisData[3], 2, 2) . '-' . substr($MyMisData[3], 0, 2);
					$Type = "PAN";
					$panFees = $fees = $MyMisData[11];
					$tanFees = 0;
					$panLength = 1;
					$tanLength = 0;
				} else {
					$ackdate = substr($MyMisData[3], 0, 4) . '-' . substr($MyMisData[3], 4, 2) . '-' . substr($MyMisData[3], 6, 2);
					$Type = "TAN";
					$tanFees = $fees = $MyMisData[11];
					$panFees = 0;
					$tanLength = 1;
					$panLength = 0;
				}
				// $catego = $MyMisData[15];
				// $formtype =  $MyMisData[12];

				$checkBillQuery = "SELECT \"ACKNOWLEDGEMENT-NO\" FROM panprogres.\"bill_detail_info\" WHERE \"ACKNOWLEDGEMENT-NO\" = '_akno';";

				$checkBillQuery = str_replace("_akno", $akno, $checkBillQuery);

				$getDatafromBill = pg_query(OpenCon(), $checkBillQuery);

				$billExists = pg_num_rows($getDatafromBill);

				if ($billExists == 0) {

					$accActivitylog = "|" . $akno . "^Automate^Fee^" . date('Y-m-d H:i:s') . "^Automate";

					$sql_name = '"ACKNOWLEDGEMENT-NO","FEES","DATE_ADDED","BRANCH_CODE","TYPE","ACTIVITY_LOG"';
					$sql_val = "'" . $akno . "','" . $fees . "','" . $ackdate . "','" . $bCode . "','" . $Type . "','" . $accActivitylog . "'";
					$query .= ' Insert into panprogres."bill_detail_info" (' . $sql_name . ') Values (' . $sql_val . ');';


					$DataEntryQuery = "SELECT \"Id\",\"panTotal\",\"panCount\",\"tanTotal\",\"tanCount\" FROM panprogres.\"bill_cycle_info\" WHERE \"isApproved\"= 0 AND \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' AND \"branchCode\" = '_bname';";

					$DataEntryQuery = str_replace("_adate", $ackdate, $DataEntryQuery);
					$DataEntryQuery = str_replace("_bname", $bCode, $DataEntryQuery);

					$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

					$cycleExists = pg_num_rows($getDatafromData);

					$dataList = pg_fetch_object($getDatafromData);

					if ($cycleExists < 1) {

						$billPeriod = "SELECT \"fromDate\",\"toDate\" FROM panprogres.\"billInformationMaster\" WHERE \"fromDate\" <= '_adate' AND \"toDate\" >= '_adate' ;";

						$billPeriod = str_replace("_adate", $ackdate, $billPeriod);

						$getPeriodfromData = pg_query(OpenCon(), $billPeriod);

						$periodList = pg_fetch_object($getPeriodfromData);

						$fdate = $periodList->fromDate;
						$tdate = $periodList->toDate;

						$entry_name = '"fromDate","toDate","branchCode","panTotal","panCount","tanTotal","tanCount"';
						$entry_val = "'" . $fdate . "','" . $tdate . "','" . $bCode . "','" . $panFees . "','" . $panLength . "','" . $tanFees . "','" . $tanLength . "'";
						$entry = ' Insert into panprogres."bill_cycle_info" (' . $entry_name . ') Values (' . $entry_val . ')';
						$entryinsert = pg_query(OpenCon(), $entry);
					} else {

						$editId = $dataList->Id;

						$panTotal = $dataList->panTotal + $panFees;

						$panCount = $dataList->panCount + $panLength;

						$tanTotal = $dataList->tanTotal + $tanFees;

						$tanCount = $dataList->tanCount + $tanLength;

						$obsUpdateQuery = " Update panprogres.\"bill_cycle_info\" set \"panTotal\" = '_pantotal',\"panCount\"='_pancount',\"tanTotal\" = '_tantotal',\"tanCount\"='_tancount' where \"Id\" = '_aid';";

						$obsUpdateQuery = str_replace('_aid', $editId, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_pancount', $panCount, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_pantotal', $panTotal, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_tancount', $tanCount, $obsUpdateQuery);
						$obsUpdateQuery = str_replace('_tantotal', $tanTotal, $obsUpdateQuery);

						$result = pg_query(OpenCon(), $obsUpdateQuery);
					}
				}
				// }
				$obsPanQuery = " Update panprogres.\"tbl_pan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

				$obsPanQuery = str_replace('_aid', $akno, $obsPanQuery);
				$obsPanResult = pg_query(OpenCon(), $obsPanQuery);

				$obsTanQuery = " Update panprogres.\"tbl_tan_master\" set \"ISBILL\" = '1' where \"AKNOWLEDGEMENT-NO\" = '_aid';";

				$obsTanQuery = str_replace('_aid', $akno, $obsTanQuery);
				$obsTanResult = pg_query(OpenCon(), $obsTanQuery);

				// $misinsert = pg_query(OpenCon(), $query);
				// $dberror = pg_last_error(OpenCon());
				// $query = "";
			}
		}
		$i++;
		$tanCount = 0;
		$tanTotal = 0;
		$panCount = 0;
		$panTotal = 0;
	}
	$misinsert = pg_query(OpenCon(), $query);
	// $effectedRow+=pg_affected_rows($misinsert);
	// $dberror = pg_last_error(OpenCon());
	// MISuploadlogger("====Effected Row==".$effectedRow);
	// $query = "";
}
MISuploadlogger("Inside account MasterAPI log end--");