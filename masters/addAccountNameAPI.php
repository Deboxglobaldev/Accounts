<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

//add branch basic information
if(isset($_POST['AccountName']))
{

  $accountName = $_POST['AccountName'];
  $subGroupId = $_POST['GroupId'];
  $status = $_POST['Status'];

if (preg_match('/^\d{5}$|^\d{7}$/', $accountName)) {

    $SubLedgerId = "SLB".$accountName;

} else {

$n = GetAccSequence();

$n2 = str_pad($n, 4, 0, STR_PAD_LEFT); 

$SubLedgerId = str_pad("SLB",7,$n2);

}

$sql_name = '"accountName","subGroupId","status","SubLedgerId"';
$sql_val = "'".$accountName."','".$subGroupId."','".$status."','".$SubLedgerId."'";

	$add = inserting('panprogres."accountNameMaster"',$sql_name,$sql_val);
	if($add!=''){
	echo "Insert Data Successfully";
	}else{
	echo "Some Error Try Again!";
	}
}
?>