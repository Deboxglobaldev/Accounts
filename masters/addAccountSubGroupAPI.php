<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

$validates = ['Name'];
foreach ($validates as $validate) {
    if (!isset($data[$validate]) || empty($data[$validate])) {
        echo json_encode(array('Error' => $validate . ' is required'));
        exit();
    }
}

//add branch basic information
if(isset($data['Name']))
{

  $accountGroup = $data['GroupId'];
  $name = $data['Name'];

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

	if($add){
		echo json_encode(['Status' => 1, 'Message' =>'Data Added Successfully!']);
		}else{
			echo json_encode(['Status' => 0, 'Message' =>'Error!']);
		}

}


?>