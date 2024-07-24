<?php
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

$validates = ['name'];
foreach ($validates as $validate) {
    if (!isset($data[$validate]) || empty($data[$validate])) {
        echo json_encode(array('Message' => $validate . ' is required'));
        exit();
    }
}

//add branch basic information
if(isset($data['name']))
{

  $accountGroup = $data['accountGroup'];
  $name = $data['name'];
  $LedgerId = $data['ledgerId'];

	$sql_name = '"Name","GroupId","LedgerId"';
	$sql_val = "'".$name."','".$accountGroup."','".$LedgerId."'";

	// print_r($sql_val);die;

	$add = inserting(_ACCOUNT_SUBGROUP_MASTER_,$sql_name,$sql_val);

	if($add){
		echo json_encode(['Status' => 1, 'Message' =>'Data Added Successfully!']);
		}else{
			echo json_encode(['Status' => 0, 'Message' =>'Error!']);
		}

}


?>