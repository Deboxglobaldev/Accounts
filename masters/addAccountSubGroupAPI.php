<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

//add branch basic information
if(isset($_POST['Name']))
{

  $accountGroup = $_POST['GroupId'];
  $name = $_POST['Name'];

  	if (preg_match('/^\d{5}$|^\d{7}$/', $accountGroup)) {
	$LedgerId = "LB".$accountGroup;
	} else {
	$n = GetAccSequence();
	$n2 = str_pad($n, 4, '0', STR_PAD_LEFT); 
	$LedgerId = "LB".$n2;
	}

	$sql_name = '"Name","GroupId","LedgerId"';
	$sql_val = "'".$name."','".$accountGroup."','".$LedgerId."'";

	// print_r($sql_val);die;

	$add = inserting('masters."accountSubGroupMaster"',$sql_name,$sql_val);

	if($add!=''){
		echo "Data Add Successfully";
		}else{
		echo "Some Error Try Again!";
		}

	}


?>