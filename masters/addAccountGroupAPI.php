<?php
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

//add branch basic information
if(isset($_POST['name']))
{

  $accountGroup = $_POST['accountGroup'];
  $name = $_POST['name'];

$sql_name = '"TypeId","Name"';
$sql_val = "'".$accountGroup."','".$name."'";

	$add = inserting('masters."accountGroupMaster"',$sql_name,$sql_val);
	if($add!=''){
	echo "Insert Data Successfully";
	}else{
	echo "Some Error Try Again!";
	}
}
?>