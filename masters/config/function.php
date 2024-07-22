<?php

ob_start();
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');
ini_set("display_errors",0);
ini_set("log_errors",0);

function GetSequeceNoOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	MISuploadlogger("Inside Function...");
	if(file_exists('SequenceNo.txt'))
	{
		$contents = file_get_contents('SequenceNo.txt');
		MISuploadlogger("Content of function at opening".$contents);
		$libData = explode("^",$contents);

		$sequenceNo=intval($libData[1]);

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=date("dmY")."^".strval($sequenceNo);
	MISuploadlogger("Content of function".$contents);
	file_put_contents ('SequenceNo.txt',$contents);

	return $returnval;

}

function GetsequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('accountSequence.txt'))
	{
		$contents = file_get_contents('accountSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('accountSequence.txt',$contents);

	return $returnval;

}

function GetComSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('ComSequence.txt'))
	{
		$contents = file_get_contents('ComSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('ComSequence.txt',$contents);

	return $returnval;

}

function GetRecSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('RecSequence.txt'))
	{
		$contents = file_get_contents('RecSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('RecSequence.txt',$contents);

	return $returnval;

}

function GetVoucherSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('VoucherSequence.txt'))
	{
		$contents = file_get_contents('VoucherSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('VoucherSequence.txt',$contents);

	return $returnval;

}

function GetBRSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('BRSequence.txt'))
	{
		$contents = file_get_contents('BRSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('BRSequence.txt',$contents);

	return $returnval;

}

function GetBPSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('BPSequence.txt'))
	{
		$contents = file_get_contents('BPSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('BPSequence.txt',$contents);

	return $returnval;

}

// credit note and debit note
function GetCVSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('CVSequence.txt'))
	{
		$contents = file_get_contents('CVSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('CVSequence.txt',$contents);

	return $returnval;

}

function GetVISequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('VISequence.txt'))
	{
		$contents = file_get_contents('VISequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('VISequence.txt',$contents);

	return $returnval;

}

function GetBillSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('BillSequence.txt'))
	{
		$contents = file_get_contents('BillSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('BillSequence.txt',$contents);

	return $returnval;

}

function GetCommissionSequenceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('CommissionSequence.txt'))
	{
		$contents = file_get_contents('CommissionSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('CommissionSequence.txt',$contents);

	return $returnval;

}

function GetFromRange()
{
	$sequenceNo=1;
	$returnval=0;
	MISuploadlogger("Inside Function...");
	if(file_exists('SequenceNo.txt'))
	{
		$contents = file_get_contents('SequenceNo.txt');
		MISuploadlogger("Content of function at opening".$contents);
		$libData = explode("^",$contents);

		$sequenceNo=intval($libData[1]);

			$returnval=$sequenceNo;

	}
	$contents=date("dmY")."^".strval($sequenceNo);
	MISuploadlogger("Content of function".$contents);
	file_put_contents ('SequenceNo.txt',$contents);

	return $returnval;

}

function GetToRange($range)
{
	$sequenceNo=1;
	$returnval=0;
	MISuploadlogger("Inside Function...");
	if(file_exists('SequenceNo.txt'))
	{
		$contents = file_get_contents('SequenceNo.txt');
		MISuploadlogger("Content of function at opening".$contents);
		$libData = explode("^",$contents);

		$sequenceNo=intval($libData[1]);

		$sequenceNo += $range;


			$returnval=$sequenceNo;

	}
	$contents=date("dmY")."^".strval($sequenceNo);
	MISuploadlogger("Content of function".$contents);
	file_put_contents ('SequenceNo.txt',$contents);

	return $returnval;

}

function MISuploadlogger($errorlog)
{
	$newfile = 	'errorlog/Debuglog_'.date('dmy').'.txt';

	//rename('errorlog/miserrorlog.txt',$newfile);

	if(!file_exists($newfile))
	{
	  file_put_contents($newfile,'');
	}
	$logfile=fopen($newfile,'a');

	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('Asia/Kolkata');
	$time = date('d-m-Y h:i:s A',time());
	//$contents = file_get_contents('errorlog/errorlog.txt');
	$contents = "$ip\t$time\t$errorlog\r";
	fwrite($logfile,$contents);
	//file_put_contents('errorlog/errorlog.txt',$contents);
}

function MISuploadlogger_new($errorlog)
{
	$newfile = 	'errorlog/MISUploadData_'.date('dmy').'.txt';

	//rename('errorlog/miserrorlog.txt',$newfile);

	if(!file_exists($newfile))
	{
	  file_put_contents($newfile,'');
	}
	$logfile=fopen($newfile,'a');


	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('Asia/Kolkata');
	$time = date('d-m-Y h:i:s A',time());
	//$contents = file_get_contents('errorlog/errorlog.txt');
	$contents = "$ip\t$time\t$errorlog\r";
	fwrite($logfile,$contents);
	//file_put_contents('errorlog/errorlog.txt',$contents);
}


function checkduplicateentry($tablename, $select, $value)
{
	$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;


	$where = '"' . $select . '" = \'' . $value . '\'';

    $result = 'SELECT "' . $select . '" FROM ' . $tablename . ' WHERE ' . $where;
    MISuploadlogger($InfoMessage . "Query for CheckDupliicate - " . $result);
    $checkdublicate = pg_query(OpenCon(), $result);
    $numrows = pg_num_rows($checkdublicate);
    if ($numrows > 0) {
        return 'yes';
    } else {
        return 'no';
    }
}

function inserting($tablename, $name, $values) {
    $InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;

    $sql_val = 'VALUES('.$values.')';
    $result = 'INSERT INTO '.$tablename.'('.$name.') '.$sql_val;
    MISuploadlogger($InfoMessage."Query for inserting - ".$result);

    $db = OpenCon();
    $sql_ins = pg_query($db, $result);
    if ($sql_ins) {
        return 'yes';
    } else {
        $errorInfo = pg_last_error($db);
        MISuploadlogger($InfoMessage." SQL Error: ".$errorInfo);
        return 'no';
    }
}

function updatelisting($tablename,$name,$values,$where)
{
    $sql_val = '('.$values.')';
	$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
        $result = 'UPDATE '.$tablename.' SET ('.$name.') = '.$sql_val.' WHERE '.$where.'';
         MISuploadlogger($InfoMessage."Query for updatelisting - ".$result);

	$sql_ins = pg_query(OpenCon(), $result) ;
	if($sql_ins=='TRUE')
	{
	return  'yes';
	} else {
	return  'no';
	}
}
function ListProbleString($problemString)
{
	$newfile = 	'errorlog/MISProblematicData_'.date('dmy').'.txt';
	if(!file_exists($newfile))
	{
	  file_put_contents($newfile,'');
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('Asia/Kolkata');
	$time = date('d-m-Y h:i:s A',time());
	$StringToWrite = "==================================================================================="
				  ."\n|   DATE & TIME  :  ".$time
				."\n================================================================================\n"
				 .$problemString
				."\n-------------------------------------------------------------------------------\n\n";

	$contents = file_get_contents($newfile);
	$contents .= $StringToWrite;
	file_put_contents($newfile,$contents);


}

function findWrongString($myrecord,$startpos,&$prblemString)
{
	$TotalUpload = count($myrecord);
	$j=$startpos;
	//$prblemString="";
	$effectedRow=0;
	$sql_name='';
	$sql_val='';
	$query='';


	$activityLog="";
	$effectedRow=0;
	for($i=0; $i<$TotalUpload; $i++)
	{
		//$ValueString = str_replace("'","''",$myrecord[$i]);
		if (strlen(trim($myrecord[$i]))>0)
		{
			$MyMisData = explode("^",$myrecord[$i]);
			$akno = $MyMisData[2];
			$catego = $MyMisData[15];
			$formtype =  $MyMisData[12];

			$MString=$myrecord[$i]."\n";
			$activityLog = $akno."^".$UserName."^F~DGP~DE1~DU^".date('Y-m-d H:i:s');
			$sql_name = '"AKNOWLEDGEMENT-NO","APPLICANT-CATEGORY","FORM-TYPE","NSDL-PAN-MIS-STRING","ACTIVITY-LOG"';
			$sql_val = "'".$akno."','".$catego."','".$formtype."','".str_replace("'","''",$myrecord[$i])."','".$activityLog."'";
			$query = ' Insert into panprogres."tbl_pan_master" ('.$sql_name.') Values ('.$sql_val.')'.' ON CONFLICT ("AKNOWLEDGEMENT-NO") DO NOTHING;';



				$misinsert = pg_query(OpenCon(),$query);
				$effectedRow+=pg_affected_rows($misinsert);
				$dberror = pg_last_error(OpenCon());


					if ($dberror != null || trim($dberror)!="")
					{
						MISuploadlogger_new("[ERROR] -- "
											 ."============================================================================================== \n"
											.$query
											."\n\r-------------------------------------------------------------------------------------------\n "
											.$dberror
											."\n---------------------------------------------------------------------------------------------\n"
											."Error in Following String \n"
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											.$MString
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											);

						$prblemString.=$MString;


					}
					else
					{
						$j++;
						MISuploadlogger_new("[INFO] -- Record Processed  -- " .($i+$j). " out of  ".($TotalUpload+$j)."   Successfull Records ". $j ." out of " .($i+$j) );
					}


				$query="";
				$MString="";

		}
	}
	if (trim($prblemString)!="")
	{
		ListProbleString($prblemString);
	}
	return $j;
}

function findWrongStringTan($myrecord,$startpos,&$prblemString)
{
	$TotalUpload = count($myrecord);
	$j=$startpos;
	//$prblemString="";
	$effectedRow=0;
	$sql_name='';
	$sql_val='';
	$query='';


	$activityLog="";
	$effectedRow=0;
	for($i=0; $i<$TotalUpload; $i++)
	{
		//$ValueString = str_replace("'","''",$myrecord[$i]);
		if (strlen(trim($myrecord[$i]))>0)
		{
			$MyMisData = explode("^",$myrecord[$i]);
			$akno = $MyMisData[2];
			$catego = $MyMisData[15];
			$formtypecheck =  $MyMisData[12];

		if(trim($formtypecheck) == 'N'){
		$formtype = '49B';
		}else{
		$formtype = 'CR';
		}

			$MString=$myrecord[$i]."\n";
			$activityLog = $akno."^".$UserName."^F~DGP~DE1~DU^".date('Y-m-d H:i:s');
			$sql_name = '"ACKNOWLEDGEMENT-NO","APPLICANT-CATEGORY","FORM-TYPE","NSDL-TAN-MIS-STRING","ACTIVITY-LOG"';
			$sql_val = "'".$akno."','".$catego."','".$formtype."','".str_replace("'","''",$myrecord[$i])."','".$activityLog."'";
			$query = ' Insert into panprogres."tbl_tan_master" ('.$sql_name.') Values ('.$sql_val.')'.' ON CONFLICT ("ACKNOWLEDGEMENT-NO") DO NOTHING;';



				$misinsert = pg_query(OpenCon(),$query);
				$effectedRow+=pg_affected_rows($misinsert);
				$dberror = pg_last_error(OpenCon());


					if ($dberror != null || trim($dberror)!="")
					{
						MISuploadlogger_new("[ERROR] -- "
											 ."============================================================================================== \n"
											.$query
											."\n\r-------------------------------------------------------------------------------------------\n "
											.$dberror
											."\n---------------------------------------------------------------------------------------------\n"
											."Error in Following String \n"
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											.$MString
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											);

						$prblemString.=$MString;


					}
					else
					{
						$j++;
						MISuploadlogger_new("[INFO] -- Record Processed  -- " .($i+$j). " out of  ".($TotalUpload+$j)."   Successfull Records ". $j ." out of " .($i+$j) );
					}


				$query="";
				$MString="";

		}
	}
	if (trim($prblemString)!="")
	{
		ListProbleString($prblemString);
	}
	return $j;
}
function getStage($value){
    if(substr($value,6,3)=='DE1' && substr($value,10,2)=='DU'){
      return "Pdf Upload by Branch";
    }
    elseif(substr($value,6,3)=='DE1' && substr($value,10,2)=='IP'){
      return "Photo & Signature Cropping";
    }
    elseif(substr($value,6,3)=='DIE'){
      return "PAAM MIS Upload";
    }
    elseif(substr($value,6,3)=='QC1' && substr($value,0,1)=='F'){
      return "Data Entry 1";
    }
    elseif(substr($value,6,3)=='QC2' && substr($value,0,1)=='F'){
		return "Data Entry 2";
	}
    elseif(substr($value,2,3)=='QCP' && substr($value,0,1)=='I'){
      return "Rejection Resolved";
    }
    elseif(substr($value,2,3)=='QCF' && substr($value,0,1)=='I'){
      return "Rejection";
    }
    elseif(substr($value,2,3)=='BCP' && substr($value,10,2)=='BY'){
      return "QC";
    }
    elseif(substr($value,2,3)=='BCP' && substr($value,10,2)=='BC'){
      return "QC-Batch Creation";
    }
	elseif(substr($value,2,3)=='NSD' && substr($value,6,3)=='INS'){
      return "Batch confirmation";
    }
	elseif(substr($value,2,3)=='NSD' && substr($value,6,3)=='ACC'){
      return "NSDL confirmation";
    }
	elseif(substr($value,2,3)=='NSD' && substr($value,6,3)=='ALC'){
      return "PAN Allotment";
    }
  	elseif(substr($value,2,3)=='NSD' && substr($value,6,3)=='BSC'){
      return "Batch Status confirmation";
    }
	elseif(substr($value,6,3)=='DCM' && substr($value,10,2)=='CS'){
		return "Courier Sent";
	}
	elseif(substr($value,6,3)=='DCM' && substr($value,10,2)=='CR'){
		return "Courier Received";
	}
	elseif(substr($value,6,3)=='DCM' && substr($value,10,2)=='RC'){
		return "Receive";
	}



    // elseif(substr($value,6,3)=='BTN'){
    //   return "Batch Generated";
    // }elseif(substr($value,6,3)=='RBN'){
    //   return "Re-Batch";
    // }elseif(substr($value,6,3)=='FUV'){
    //   return "FUV Operation";
    // }elseif(substr($value,6,3)=='NWS'){
    //   return "NSDL Web Site Operation";
    // }elseif(substr($value,6,3)=='BTA'){
    //   return "BTA";
    // }elseif(substr($value,6,3)=='DCM'){
    //   return "Document Management";
    // }
    else{
      return "";
    }
  }


  // function getSubStage($value){
  //   if(substr($value,10,2)=='DU'){
  //     return "Document Upload";
  //   }elseif(substr($value,10,2)=='IP'){
  //     return "Crop Photo & Signature";
  //   }elseif(substr($value,10,2)=='DE'){
  //     return "Data Entry";
  //   }elseif(substr($value,10,2)=='DR'){
  //     return "Data Review";
  //   }elseif(substr($value,10,2)=='DM'){
  //     return "Data Matching";
  //   }elseif(substr($value,10,2)=='DV'){
  //     return "QC";
  //   }elseif(substr($value,10,2)=='QH'){
  //     return "QC Hold";
  //   }elseif(substr($value,10,2)=='QR'){
  //     return "Rejected From QC";
  //   }elseif(substr($value,10,2)=='QD'){
  //     return "QC PASS";
  //   }elseif(substr($value,10,2)=='BC'){
  //     return "Batch Created";
  //   }elseif(substr($value,10,2)=='BY'){
  //     return "Batch yet to Create";
  //   }elseif(substr($value,10,2)=='MU'){
  //     return "Uploaded Data";
  //   }else{
  //     return "";
  //   }
  // }

 function getCommissionRate($branchCode,$type){

$currentDate =  $currentDate = date("Y-m-d",time());

$DataEntryQuery = "SELECT \"commission\" FROM panprogres.\"commissionRateMaster\" WHERE \"Status\"=1 AND \"fromDate\" <= '_date' AND \"toDate\" >= '_date' AND \"Id\" in (SELECT \"commissionId\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='branch') ";

$DataEntryQuery =str_replace('_date',$currentDate,$DataEntryQuery);
$DataEntryQuery =str_replace('_branch',$branchCode,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if (pg_num_rows($getDatafromData) > 0) {

$dataList =  pg_fetch_assoc($getDatafromData);

return $dataList['commission'];

}
return 0;
  }


  function getUserId($userId){

$selQry =  "select \"FirstName\",\"LastName\" FROM panprogres.\"userMaster\" WHERE \"Id\"= '_ID'";
    $selQry = str_replace('_ID',$userId,$selQry);
    $result = pg_query(OpenCon(), $selQry);

    if (pg_num_rows($result) > 0) {
      $resultData = pg_fetch_assoc($result);
     return $user_id = $resultData['FirstName'].' '.$resultData['LastName'];
    }
    return "-";

  }

function getProductType($productId){

$DataEntryQuery = "SELECT \"ProductType\" FROM panprogres.\"productMaster\" WHERE \"Status\"=1 AND \"Id\"='_prodid' ";

$DataEntryQuery =str_replace('_prodid',$productId,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);
MISuploadlogger("=====product==".$DataEntryQuery);
if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return trim($resultData['ProductType']);
}
return 0;
}

function getBalance($accountName){

$DataEntryQuery = "SELECT \"Balance\" FROM masters.\"accountNameMaster\" WHERE \"Balance\" IS NOT NULL AND \"SubLedgerId\"='_account'";

$DataEntryQuery =str_replace('_account',$accountName,$DataEntryQuery);

MISuploadlogger("===Balance==".$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['Balance'];
}
return 0;
}

 function updateBalance($accountName,$balance){

$obsUpdateQuery =" Update masters.\"accountNameMaster\" set \"Balance\" ='_balance' where \"SubLedgerId\" = '_account' ;";

$obsUpdateQuery = str_replace('_account',$accountName, $obsUpdateQuery);
$obsUpdateQuery = str_replace('_balance',$balance, $obsUpdateQuery);

MISuploadlogger("===Update Balance==".$obsUpdateQuery);
$result = pg_query(OpenCon(),$obsUpdateQuery);

if(pg_affected_rows($result) > 0){

return true;

}
return false;
}

 function BranchAvailable($accountCode){

$selectQuery ="Select \"SubLedgerId\" from panprogres.\"accountNameMaster\" where \"status\"=1 and \"SubLedgerId\" = '_account' ;";

$selectQuery = str_replace('_account',$accountCode, $selectQuery);

$result = pg_query(OpenCon(),$selectQuery);

if(pg_num_rows($result) > 0){

return true;

}
return false;
}

function BranchExists($accountCode){

$selectQuery ="Select \"accountName\" from panprogres.\"accountNameMaster\" where \"status\"=1 and \"accountName\" = '_account' ;";

$selectQuery = str_replace('_account',$accountCode, $selectQuery);

$result = pg_query(OpenCon(),$selectQuery);

if(pg_num_rows($result) > 0){

return true;

}
return false;
}


function getGroupName($groupId){

$DataEntryQuery = "SELECT \"Name\" FROM masters.\"accountGroupMaster\" WHERE \"Id\"='_gid'";

$DataEntryQuery =str_replace('_gid',$groupId,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);
$aa = pg_num_rows($getDatafromData);

if(pg_num_rows($getDatafromData) > 0) {
	$resultData = pg_fetch_assoc($getDatafromData);
	return $resultData['Name'];
}
	return "";
}

function getSubGroupName($groupId){

$DataEntryQuery = "SELECT \"Name\" FROM masters.\"accountSubGroupMaster\" WHERE \"LedgerId\"='_gid'";

$DataEntryQuery =str_replace('_gid',$groupId,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['Name'];
}
return "";
}

function getSubLedgerId($accountName){

$DataEntryQuery = "SELECT \"SubLedgerId\" FROM panprogres.\"accountNameMaster\" WHERE \"accountName\"='_accName'";

$DataEntryQuery =str_replace('_accName',$accountName,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['SubLedgerId'];
}else{
return "";
}
}

function getAccountFromId($accountCode){

$DataEntryQuery = "SELECT \"accountName\" FROM panprogres.\"accountNameMaster\" WHERE \"SubLedgerId\"='_accCode'";

$DataEntryQuery =str_replace('_accCode',$accountCode,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['accountName'];
}else{
return "";
}
}

function getTypeName($typeId){
$type="";
if($typeId == 1){
$type = "Assets";
}
if($typeId == 2){
$type = "Liability";
}
if($typeId == 3){
$type = "Equity";
}
if($typeId == 4){
$type = "Income";
}
if($typeId == 5){
$type = "Expenses";
}
return $type;

}


function getBranchName($branchCode){

$DataEntryQuery = "SELECT \"Name\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='_gid'";

$DataEntryQuery =str_replace('_gid',$branchCode,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['Name'];
}
return "-";
}

function getBankName($bankId){

$DataEntryQuery = "SELECT \"accountName\" FROM panprogres.\"accountNameMaster\" WHERE \"Id\"='_bid'";

$DataEntryQuery =str_replace('_bid',$bankId,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);
return $resultData['accountName'];
}
return "-";
}



function getCommissionValidity($branchCode,$type){

$DataEntryQuery = "SELECT \"SchemeId\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='_bid'";

$DataEntryQuery =str_replace('_bid',$branchCode,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);

$CommissionId =  $resultData['SchemeId'];

$EntryQuery = "SELECT \"Days\" FROM panprogres.\"commissionRateMaster\" WHERE \"Type\"='_type' AND \"commissionId\"='_uid' AND '_date' BETWEEN \"fromDate\" AND \"toDate\" ";

$EntryQuery =str_replace('_uid',$CommissionId,$EntryQuery);

$EntryQuery =str_replace('_type',$type,$EntryQuery);

$EntryQuery =str_replace('_date',date('Y-m-d',time()),$EntryQuery);

$DatafromData = pg_query(OpenCon(), $EntryQuery);

if(pg_num_rows($DatafromData) > 0) {
$Data = pg_fetch_assoc($DatafromData);
return $Data['Days'];
}
}
return "0";
}

function getCommission($branchCode,$type){

$DataEntryQuery = "SELECT \"SchemeId\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='_bid'";

$DataEntryQuery =str_replace('_bid',$branchCode,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0) {
$resultData = pg_fetch_assoc($getDatafromData);

$CommissionId =  $resultData['SchemeId'];

$EntryQuery = "SELECT \"commission\" FROM panprogres.\"commissionRateMaster\" WHERE \"Status\"=1 AND \"Type\"='_type' AND \"commissionId\"='_uid' AND '_date' BETWEEN \"fromDate\" AND \"toDate\" ";

$EntryQuery =str_replace('_uid',$CommissionId,$EntryQuery);

$EntryQuery =str_replace('_type',$type,$EntryQuery);

$EntryQuery =str_replace('_date',date('Y-m-d',time()),$EntryQuery);

$DatafromData = pg_query(OpenCon(), $EntryQuery);

if(pg_num_rows($DatafromData) > 0) {
$Data = pg_fetch_assoc($DatafromData);
return $Data['commission'];
}
}
return "0";
}

function findWrongStringEtds($myrecord,$startpos,&$prblemString)
{
	$TotalUpload = count($myrecord);
	$j=$startpos;
	//$prblemString="";
	$effectedRow=0;
	$sql_name='';
	$sql_val='';
	$query='';


	$activityLog="";
	$effectedRow=0;
	for($i=0; $i<$TotalUpload; $i++)
	{
		//$ValueString = str_replace("'","''",$myrecord[$i]);
		if (strlen(trim($myrecord[$i]))>0)
		{
			$MyMisData = explode("^",$myrecord[$i]);
			$refno = $MyMisData[1];
			$tokenno = $MyMisData[2];
			$receiptno = $MyMisData[3];
			$tokendate = $MyMisData[4];
			$barcode = $MyMisData[5];
			$type = $MyMisData[6];
			$namedeductee = str_replace("'","''",$MyMisData[7]);
			$tanno = $MyMisData[8];
			$financeyear = $MyMisData[9];
			$period = $MyMisData[10];
			$form = $MyMisData[11];
			$aocode = $MyMisData[12];
			$correctionno = $MyMisData[13];
			$othertype = $MyMisData[14];
			$otherrrr = $MyMisData[15];
			$amount = $MyMisData[16];
			$branchcode = $MyMisData[17];
			$nodeductor = $MyMisData[18];

			$MString=$myrecord[$i]."\n";
			$sql_name = '"REFERENCE-NO","TOKEN-NO","RECEIPT-NO","TOKEN-DATE","BAR-CODE","TYPE","NAME-DEDUCTOR","TAN-NO","FINANCE-YEAR","PERIOD","FORM","AO-CODE","CORRECTION-NO","AMOUNT","BRANCH-CODE","NO-DEDUCTOR","OTHER-TYPE","NSDL-ETDS-MIS-STRING","UPLOAD-DATE"';
			$sql_val = "'".$refno."','".$tokenno."','".$receiptno."','".$tokendate."','".$barcode."','".$type."','".$namedeductee."','".$tanno."','".$financeyear."','".$period."','".$form."','".$aocode."','".$correctionno."','".$amount."','".$branchcode."','".$nodeductor."','".$othertype."','".str_replace("'","''",$myrecord[$i])."','".date('Y-m-d')."'";
			$query .= ' Insert into panprogres."tbl_etds_master" ('.$sql_name.') Values ('.$sql_val.')'.' ON CONFLICT ("REFERENCE-NO") DO NOTHING;';



				$misinsert = pg_query(OpenCon(),$query);
				$effectedRow+=pg_affected_rows($misinsert);
				$dberror = pg_last_error(OpenCon());


					if ($dberror != null || trim($dberror)!="")
					{
						MISuploadlogger_new("[ERROR] -- "
											 ."============================================================================================== \n"
											.$query
											."\n\r-------------------------------------------------------------------------------------------\n "
											.$dberror
											."\n---------------------------------------------------------------------------------------------\n"
											."Error in Following String \n"
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											.$MString
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											);

						$prblemString.=$MString;


					}
					else
					{
						$j++;
						MISuploadlogger_new("[INFO] -- Record Processed  -- " .($i+$j). " out of  ".($TotalUpload+$j)."   Successfull Records ". $j ." out of " .($i+$j) );
					}


				$query="";
				$MString="";

		}
	}
	if (trim($prblemString)!="")
	{
		ListProbleString($prblemString);
	}
	return $j;
}

function findWrongString24g($myrecord,$startpos,&$prblemString)
{
	$TotalUpload = count($myrecord);
	$j=$startpos;
	//$prblemString="";
	$effectedRow=0;
	$sql_name='';
	$sql_val='';
	$query='';


	$activityLog="";
	$effectedRow=0;
	for($i=0; $i<$TotalUpload; $i++)
	{
		//$ValueString = str_replace("'","''",$myrecord[$i]);
		if (strlen(trim($myrecord[$i]))>0)
		{
			$MyMisData = explode("^",$myrecord[$i]);
			$type = $MyMisData[1];
			$refno = $MyMisData[2];
			$statementtype = $MyMisData[3];
			$status = $MyMisData[4];
			$prnNo = $MyMisData[5];
			$prnDate = $MyMisData[6];
			$ain = $MyMisData[7];
			$transactionType = $MyMisData[8];
			$aoName = str_replace("'","''",$MyMisData[9]);
			$financialYear = $MyMisData[10];
			$ddoCategory = $MyMisData[11];
			$month = $MyMisData[12];
			$samVersion = $MyMisData[13];
			$fillingFees = $MyMisData[14];
			$ddoDetails = $MyMisData[15];
			$uploadDate = date('Y-m-d');

			$MString=$myrecord[$i]."\n";
			$sql_name = '"TYPE","REFERENCE-NO","STATEMENT-TYPE","STATUS","PRN_NO","PRN-DATE","AIN","TRANSACTION-TYPE","AO-NAME","FINANCIAL-DATE","DDO-CATEGORY","MONTH","SAM-VERSION","FILLING-FEES","DDA-DETAILS","UPLOAD-DATE","NSDL-24G-MIS-STRING"';
			$sql_val = "'".$type."','".$refno."','".$statementtype."','".$status."','".$prnNo."','".$prnDate."','".$ain."','".$transactionType."','".$aoName."','".$financialYear."','".$ddoCategory."','".$month."','".$samVersion."','".$fillingFees."','".$ddoDetails."','".$uploadDate."','".str_replace("'","''",$myrecord[$i])."'";
			$query .= ' Insert into panprogres."tbl_24g_master" ('.$sql_name.') Values ('.$sql_val.')'.' ON CONFLICT ("PRN_NO") DO NOTHING;';



				$misinsert = pg_query(OpenCon(),$query);
				$effectedRow+=pg_affected_rows($misinsert);
				$dberror = pg_last_error(OpenCon());


					if ($dberror != null || trim($dberror)!="")
					{
						MISuploadlogger_new("[ERROR] -- "
											 ."============================================================================================== \n"
											.$query
											."\n\r-------------------------------------------------------------------------------------------\n "
											.$dberror
											."\n---------------------------------------------------------------------------------------------\n"
											."Error in Following String \n"
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											.$MString
											."+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++\n"
											);

						$prblemString.=$MString;


					}
					else
					{
						$j++;
						MISuploadlogger_new("[INFO] -- Record Processed  -- " .($i+$j). " out of  ".($TotalUpload+$j)."   Successfull Records ". $j ." out of " .($i+$j) );
					}


				$query="";
				$MString="";

		}
	}
	if (trim($prblemString)!="")
	{
		ListProbleString($prblemString);
	}
	return $j;
}

function getMonth($branchCode,$sequence,$year){

$DataEntryQuery = "SELECT SUM(\"Debit\") AS debit,SUM(\"Credit\") AS credit FROM panprogres.\"voucherMaster\" WHERE \"AccountName\"='_bid' AND EXTRACT(MONTH FROM \"DateAdded\")='_month' AND EXTRACT(YEAR FROM \"DateAdded\")='_year' GROUP BY EXTRACT(MONTH FROM \"DateAdded\") ";

$DataEntryQuery =str_replace('_bid',$branchCode,$DataEntryQuery);

$DataEntryQuery =str_replace('_year',$year,$DataEntryQuery);

$DataEntryQuery =str_replace('_month',$sequence+1,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0){

$resultData = pg_fetch_assoc($getDatafromData);

$total = $resultData['credit'] - $resultData['debit'];

return $total;

}

return 0;

}


function getYear($branchCode,$sequence){

$DataEntryQuery = "SELECT SUM(\"Debit\") AS debit,SUM(\"Credit\") AS credit FROM panprogres.\"voucherMaster\" WHERE \"AccountName\"='_bid' AND EXTRACT(YEAR FROM \"DateAdded\")='_year' GROUP BY EXTRACT(YEAR FROM \"DateAdded\") ";

$year = date("Y") - $sequence;

$DataEntryQuery =str_replace('_bid',$branchCode,$DataEntryQuery);

$DataEntryQuery =str_replace('_year',$year,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0){

$resultData = pg_fetch_assoc($getDatafromData);

$total = $resultData['credit'] - $resultData['debit'];

return $total;

}

return 0;

}

function getBranchEmail($branchCode){

	$DataEntryQuery = "SELECT \"PrimaryEmail\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='_gid'";

	$DataEntryQuery =str_replace('_gid',$branchCode,$DataEntryQuery);

	$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

	if(pg_num_rows($getDatafromData) > 0) {
	$resultData = pg_fetch_assoc($getDatafromData);
	return $resultData['PrimaryEmail'];
	}
	return "-";
	}

	function getBranchContactPerson($branchCode){

		$DataEntryQuery = "SELECT \"ContactPerson\" FROM panprogres.\"branchInfoMaster\" WHERE \"BranchCode\"='_gid'";

		$DataEntryQuery =str_replace('_gid',$branchCode,$DataEntryQuery);

		$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

		if(pg_num_rows($getDatafromData) > 0) {
		$resultData = pg_fetch_assoc($getDatafromData);
		return $resultData['ContactPerson'];
		}
		return "-";
		}


function BilledBalance($accountCode){

$DataEntryQuery = "SELECT SUM(\"Debit\") AS debit,SUM(\"Credit\") AS credit FROM panprogres.\"voucherMaster\" WHERE \"AccountName\"='_bid' AND \"DateAdded\" >= '_date' ";

$DataEntryQuery =str_replace('_bid',$accountCode,$DataEntryQuery);

$DataEntryQuery =str_replace('_date',"2022-04-01",$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0){

$resultData = pg_fetch_assoc($getDatafromData);

$total = $resultData['credit'] - $resultData['debit'];

return $total;

}

return 0;

}

function UnBilledBalance($accountCode){

$subCode = getSubLedgerId($accountCode);

$BillEntryQuery = "SELECT \"panTotal\",\"tanTotal\",\"eReturnTotal\" FROM panprogres.\"bill_cycle_info\" WHERE \"branchCode\"='_bid' AND \"isApproved\"=0 AND \"fromDate\" >= '_date' ";

$BillEntryQuery =str_replace('_bid',$accountCode,$BillEntryQuery);

$BillEntryQuery =str_replace('_date',"2022-04-01",$BillEntryQuery);

$getBillfromData = pg_query(OpenCon(), $BillEntryQuery);

MISuploadlogger($BillEntryQuery);

if(pg_num_rows($getBillfromData) > 0){

while($resultBillData = pg_fetch_assoc($getBillfromData)){

$BillTotal += $resultBillData['panTotal'] + $resultBillData['tanTotal'] + $resultBillData['eReturnTotal'];

}
}

$CommissionEntryQuery = "SELECT \"panTotal\",\"tanTotal\",\"eReturnTotal\" FROM panprogres.\"commission_cycle_info\" WHERE \"branchCode\"='_bid' AND \"isApproved\"=0 AND \"fromDate\" >= '_date' ";

$CommissionEntryQuery =str_replace('_bid',$accountCode,$CommissionEntryQuery);

$CommissionEntryQuery =str_replace('_date',"2022-04-01",$CommissionEntryQuery);

$getCommissionfromData = pg_query(OpenCon(), $CommissionEntryQuery);

MISuploadlogger($CommissionEntryQuery);

if(pg_num_rows($getCommissionfromData) > 0){

while($resultCommissionData = pg_fetch_assoc($getCommissionfromData)){

$CommissionTotal += $resultCommissionData['panTotal'] + $resultCommissionData['tanTotal'] + $resultCommissionData['eReturnTotal'];

}
}

$WalletEntryQuery = "SELECT \"credit\" FROM panprogres.\"branchWalletMaster\" WHERE \"branchCode\"='_bid' AND \"walletFlag\"=0 AND \"dateAdded\" >= '_date' ";

$WalletEntryQuery =str_replace('_bid',$subCode,$WalletEntryQuery);

$WalletEntryQuery =str_replace('_date',"2022-04-01",$WalletEntryQuery);

$getWalletfromData = pg_query(OpenCon(), $WalletEntryQuery);

MISuploadlogger($WalletEntryQuery);

if(pg_num_rows($getWalletfromData) > 0){

while($resultWalletData = pg_fetch_assoc($getWalletfromData)){

$WalletTotal += $resultWalletData['credit'] ;

}
}

$total= $BillTotal + $CommissionTotal + $WalletTotal;

return $total;
}

function GetBunchSequeceOftheDay()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('BunchSequence.txt'))
	{
		$contents = file_get_contents('BunchSequence.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents ('BunchSequence.txt',$contents);

	return $returnval;

}


function getCommissionType($ValueofField){
       $ArrayApplStatus = array( "PAN Acc"=>"1"
        ,"PAN Dig"=>"2"
        ,"PAN Inc"=>"3"
        ,"NEW TAN Acc"=>"4"
        ,"NEW TAN Dig"=>"5"
        ,"NEW TAN Inc"=>"6"
        ,"eTDS"=>"7"
        ,"24G"=>"8"
        ,"Mobile PAN"=>"9"
    );
   if( !array_search(strtoupper($ValueofField),array_map('strtoupper',$ArrayApplStatus)))
   {
        return "";
   }
   return trim(array_search(strtoupper($ValueofField),array_map('strtoupper',$ArrayApplStatus)));

}

function getSchemeName($Id){

$DataEntryQuery = "SELECT \"SchemeName\" FROM panprogres.\"commissionSchemeMaster\" WHERE \"Id\"='_sid' ";

$DataEntryQuery =str_replace('_sid',$Id,$DataEntryQuery);

$getDatafromData = pg_query(OpenCon(), $DataEntryQuery);

if(pg_num_rows($getDatafromData) > 0){

$resultData = pg_fetch_assoc($getDatafromData);

$SchemeName = $resultData['SchemeName'];

return $SchemeName;

}

return "_";

}

function GetAccSequence()
{
	$sequenceNo=1;
	$returnval=0;
	if(file_exists('SequenceAccNo.txt'))
	{
		$contents = file_get_contents('SequenceAccNo.txt');

		$sequenceNo=$contents;

			$sequenceNo++;

			$returnval=$sequenceNo;

	}
	$contents=strval($sequenceNo);
	file_put_contents('SequenceAccNo.txt',$contents);

	return $returnval;

}
?>