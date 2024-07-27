<?php
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

//add branch basic information
if(isset($_POST['branchAc']))
{

  $VoucherNumber = "RVR-".date('dmy')."-".GetRecSequenceOftheDay();;
  $BankAccount = $_POST['bankAc'];
  $currentTime = date("Y-m-d H:i:s");
  $BranchCode = $_POST['branchAc'];
  $Credit = $_POST['credit'];
  $Cheque = $_POST['chequeNo'];
  $ChequeDate = $_POST['chequeDate'];
  $Narration = $_POST['narration'];
  $BankName = $_POST['bankName'];
  $ProductType = $_POST['productType'];
  $Attachment = $_POST['attachment'];
  $Status = $_POST['status'];
  $AddedBy = $_POST['addedBy'];

$sql_name = '"voucherNo","bankAccount","voucherDate","branchCode","credit","cheque","chequeDate","narration","status","attachment","bankName","productType","addedBy","dateAdded"';
$sql_val = "'".$VoucherNumber."','".$BankAccount."','".$currentTime."','".$BranchCode."','".$Credit."','".$Cheque."','".$ChequeDate."','".$Narration."','".$Status."','".$Attachment."','".$BankName."','".$ProductType."','".$AddedBy."','".$currentTime."'";

	$add = inserting('vouchers."branchWalletMaster"',$sql_name,$sql_val);
	if($add!=''){
	echo "Insert Data Successfully";
	}else{
	echo "Some Error Try Again!";
	}
}
?>