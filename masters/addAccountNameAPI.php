<?php 
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- ";
MISuploadlogger($InfoMessage."At beginning of API Call");

// Add branch basic information
if (isset($_POST['AccountName'])) {

    $accountName = $_POST['AccountName'];
    $subGroupId = $_POST['GroupId'];
    $status = $_POST['Status'];

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

    if ($add) {
        echo "Insert Data Successfully";
    } else {
        echo "Some Error Try Again!";
    }

    // Log the query and result for debugging
    MISuploadlogger($InfoMessage." SQL Query: INSERT INTO masters.\"accountNameMaster\" ($sql_name) VALUES ($sql_val)");
    if (!$add) {
        $errorInfo = $db->errorInfo();
        MISuploadlogger($InfoMessage." SQL Error: ".$errorInfo[2]);
    }
} else {
    echo "AccountName is required!";
}
?>