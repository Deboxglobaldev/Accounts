<?php
include "inc.php";
$InfoMessage = "[Info] - File location ".$_SERVER['PHP_SELF']." Message:- ";
MISuploadlogger($InfoMessage."At beginning of API Call");

// Get the raw input data
$json = file_get_contents('php://input');

MISuploadlogger($InfoMessage."REQUEST COMES FROM ADD ACCOUNT GROUP: ".$json);
// Decode the JSON data
$data = json_decode($json, true);

// Add branch basic information
if (isset($data['name']) && $data['name'] != '') {
    $accountGroup = $data['accountGroup'];
    $name = $data['name'];

    $sql_name = '"TypeId","Name"';
    $sql_val = "'".$accountGroup."','".$name."'";

    $add = inserting(_ACCOUNT_GROUP_MASTER_, $sql_name, $sql_val);
    if ($add != '') {
        echo json_encode(["status" => 1, "message" => "Insert Data Successfully"], JSON_PRETTY_PRINT);
    } else {
		echo json_encode(["status" => 0, "message" => "Some Error Try Again!"], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode(["status" => 0, "message" => "Name is required"], JSON_PRETTY_PRINT);
}
?>