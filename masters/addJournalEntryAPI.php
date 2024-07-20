<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- " ;
MISuploadlogger($InfoMessage."At begining of API Call");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

$validates = ['accountName'];
foreach ($validates as $validate) {
    if (!isset($data[$validate]) || empty($data[$validate])) {
        echo json_encode(array('Error' => $validate . ' is required'));
        exit();
    }
}

//add branch basic information
if(isset($data['accountName']))
{

  $accountName = $data['accountName'];
  $accountType = $data['accountType'];
  $transactionDate = $data['transactionDate'];
  $narration = $data['narration'];
  $debit = $data['debit'];
  $credit = $data['credit'];
  $fundType = $data['fundType'];
  $addedBy = $data['addedBy'];
  $userId = $data['userId'];
  $dateAdded = date('Y-m-d H:i:s');

$sql_name = '"accountName","accountType","transactionDate","narration","debit","credit","fundType","addedBy","userId","dateAdded"';
$sql_val = "'".$accountName."','".$accountType."','".$transactionDate."','".$narration."','".$debit."','".$credit."','".$fundType."','".$addedBy."','".$userId."','".$dateAdded."'";

	$add = inserting(_JOURNAL_ENTRY_MASTER_,$sql_name,$sql_val);

  // print_r($add);die;

  if ($add == 'yes') {
    echo json_encode(['Status' => 1, 'Message' =>'Insert Data Successfully!']);
} else {
    echo json_encode(['Status' => 0, 'Message' =>'Some Error Try Again!']);
}

// Log the query and result for debugging
MISuploadlogger($InfoMessage." SQL Query: INSERT INTO masters.\"journalEntryMaster\" ($sql_name) VALUES ($sql_val)");
if ($add == 'no') {
    $db = OpenCon();
    $errorInfo = pg_last_error($db);
    MISuploadlogger($InfoMessage." SQL Error: ".$errorInfo);
}
} else {
echo "accountName is required!";

	// if($add!=''){
  //   echo json_encode(['Status' => 1, 'Message' =>'Insert Data Successfully!']);
	// }else{
  //   echo json_encode(['Status' => 0, 'Message' =>'Some Error Try Again!']);
	// }
}
?>