<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- ";
MISuploadlogger($InfoMessage."At beginning of API Call");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

$validates = ['AccountName'];
foreach ($validates as $validate) {
    if (!isset($data[$validate]) || empty($data[$validate])) {
        echo json_encode(array('Error' => $validate . ' is required'));
        exit();
    }
}

// Add branch basic information
if (isset($data['AccountName'])) {

    $accountName = $data['AccountName'];
    $subGroupId = $data['GroupId'];
    $status = $data['Status'];

    // Validate accountName
    if (preg_match('/^\d{5}$|^\d{7}$/', $accountName)) {
        $SubLedgerId = "SLB".$accountName;
    } else {
        $n = GetAccSequence();
        $n2 = str_pad($n, 4, '0', STR_PAD_LEFT); 
        $SubLedgerId = "SLB".$n2;
    }

    $sql_name = '"accountName","subGroupId","status","SubLedgerId"';
    $sql_val = "'".$accountName."','".$subGroupId."','".$status."','".$SubLedgerId."'";

    $add = inserting('masters."accountNameMaster"', $sql_name, $sql_val);

    if ($add == 'yes') {
        echo json_encode(['Status' => 1, 'Message' =>'Insert Data Successfully!']);
    } else {
        echo json_encode(['Status' => 0, 'Message' =>'Some Error Try Again!']);
    }

    // Log the query and result for debugging
    MISuploadlogger($InfoMessage." SQL Query: INSERT INTO masters.\"accountNameMaster\" ($sql_name) VALUES ($sql_val)");
    if ($add == 'no') {
        $db = OpenCon();
        $errorInfo = pg_last_error($db);
        MISuploadlogger($InfoMessage." SQL Error: ".$errorInfo);
    }
} else {
    echo "AccountName is required!";
}
?>
