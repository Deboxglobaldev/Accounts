<?php

include "inc.php";

MISuploadlogger("*********************   Inside page Post Journal API *******************************");

define("INF","{INFO} -");
define("ERR","{ERROR} -");
define("DBG","{DEBUG} -");

header("Content-Type: application/json");

$parameterdata = file_get_contents('php://input');
$inputData = json_decode($parameterdata);

MISuploadlogger("Parameter Json \n" . $parameterdata);

$effectedRow = 0;
$dateAdded = $inputData->VoucherDate . " " . date('H:i:s', time());
$transactionDate = $inputData->EntryDate;
$AddedBy = $inputData->UserId;
$ip = $inputData->ip;
$ListOfJson = json_encode($inputData->ListOfTransaction);
$voucherNo = "JV-" . date('dmy') . "-" . GetVoucherSequenceOftheDay();
$Type = "journalVoucher";
// print_r($inputData);
// die;

function updateTransaction($value, $voucherNo, $dateAdded, $AddedBy, $ip, $Type) {
    $balance = getBalance($value->AccountName);

    if ($value->Credit != '0' && $value->Credit != '') {
        $finalBalance = $balance + $value->Credit;
        $TransferType = "Credit";
        $Amount = $value->Credit;
    } elseif ($value->Debit != '0' && $value->Debit != '') {
        $finalBalance = $balance - $value->Debit;
        $TransferType = "Debit";
        $Amount = $value->Debit;
    } else {
        return false;
    }
    

    if (updateBalance($value->AccountName, $finalBalance)) {
        $ActivityLog = "{$value->AccountName}^Journal Voucher^{$TransferType}^{$Amount}^{$voucherNo}^{$AddedBy}^" . date('Y-m-d H:i:s') . "^{$ip}^{$balance}^{$finalBalance}";

        $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type","Balance","ActivityLog"';
        $sql_val = "'{$value->AccountName}','{$voucherNo}','{$value->Narration}','{$dateAdded}','{$value->Debit}','{$value->Credit}','{$Type}','" . getBalance($value->AccountName) . "','{$ActivityLog}'";

        $query = "INSERT INTO " . _VOUCHER_MASTER_ ."  ({$sql_name}) VALUES ({$sql_val});";

        MISuploadlogger("Account Balance of Branch {$value->AccountName} is updated");

        $misinsert = pg_query(OpenCon(), $query);

        if ($misinsert) {
            return pg_affected_rows($misinsert);
        } else {
            MISuploadlogger("Database error: " . pg_last_error(OpenCon()));
            return 0;
        }
    } else {
        MISuploadlogger("Account Balance of Branch {$value->AccountName} is not updated");
        return 0;
    }
}

foreach ($inputData->ListOfTransaction as $value) {
    $effectedRow += updateTransaction($value, $voucherNo, $dateAdded, $AddedBy, $ip, $Type);
}

$journal_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';
$journal_val = "'{$voucherNo}','{$dateAdded}','{$ListOfJson}','{$transactionDate}','{$AddedBy}','JV'";

$journal = "INSERT INTO " . _VOUCHER_ENTRY_ . " ({$journal_name}) VALUES ({$journal_val});";

// echo $journal;
// die;
MISuploadlogger("===Journal Insert====" . $journal);

$journalinsert = pg_query(OpenCon(), $journal);

if ($journalinsert && $effectedRow > 0) {
    echo json_encode(["status" => 1, "message" => "Saved Successfully"], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => 0, "message" => "Failed to Save"], JSON_PRETTY_PRINT);
}

pg_close(OpenCon());
?>
