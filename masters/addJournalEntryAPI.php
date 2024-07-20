<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

//add branch basic information
if(isset($_POST['accountName']))
{

  $accountName = $_POST['accountName'];
  $accountType = $_POST['accountType'];
  $transactionDate = $_POST['transactionDate'];
  $narration = $_POST['narration'];
  $debit = $_POST['debit'];
  $credit = $_POST['credit'];
  $fundType = $_POST['fundType'];
  $userId = $_POST['userId'];
  $dateAdded = date('Y-m-d H:i:s');

$sql_name = '"accountName","accountType","transactionDate","narration","debit","credit","fundType","addedBy","dateAdded"';
$sql_val = "'".$accountName."','".$accountType."','".$transactionDate."','".$narration."','".$debit."','".$credit."','".$fundType."','".$userId."','".$dateAdded."'";

	$add = inserting('panprogres."journalEntryMaster"',$sql_name,$sql_val);
	if($add!=''){
	echo "Insert Data Successfully";
	}else{
	echo "Some Error Try Again!";
	}
}
?>