<?php

include "inc.php";

MISuploadlogger("*******   Inside page Post Journal API ***********");

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

function updateTransaction($value, $voucherNo, $dateAdded, $AddedBy, $ip, $Type) {
    $balance = getBalance($value->AccountName);

    MISuploadlogger("Current Balance for {$value->AccountName}: {$balance}");

    // Ensure Credit and Debit are numeric
    $Credit = is_numeric($value->Credit) ? floatval($value->Credit) : 0;
    $Debit = is_numeric($value->Debit) ? floatval($value->Debit) : 0;

    MISuploadlogger("Processed Credit: {$Credit}, Debit: {$Debit}");

    if ($Credit != 0) {
        $finalBalance = $balance + $Credit;
        $TransferType = "Credit";
        $Amount = $Credit;
    } elseif ($Debit != 0) {
        $finalBalance = $balance - $Debit;
        $TransferType = "Debit";
        $Amount = $Debit;
    } else {
        return false;
    }

    MISuploadlogger("Final Balance for {$value->AccountName}: {$finalBalance}");

    if (updateBalance($value->AccountName, $finalBalance)) {
        $ActivityLog = "{$value->AccountName}^Journal Voucher^{$TransferType}^{$Amount}^{$voucherNo}^{$AddedBy}^" . date('Y-m-d H:i:s') . "^{$ip}^{$balance}^{$finalBalance}";

        $sql_name = '"AccountName","VoucherNo","Detail","DateAdded","Debit","Credit","Type","Balance","ActivityLog"';
        $sql_val = "'{$value->AccountName}','{$voucherNo}','{$value->Narration}','{$dateAdded}','{$Debit}','{$Credit}','{$Type}','" . getBalance($value->AccountName) . "','{$ActivityLog}'";

        $query = "INSERT INTO " . _VOUCHER_MASTER_ ."  ({$sql_name}) VALUES ({$sql_val});";

        MISuploadlogger("Query: {$query}");

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

function validateTransactions($transactions) {
    foreach ($transactions as $transaction) {
        if (is_numeric($transaction->Debit) && is_numeric($transaction->Credit) && ($transaction->Debit != '0' && $transaction->Debit != '') && ($transaction->Credit != '0' && $transaction->Credit != '')) {
            return false;
        }
    }
    return true;
}

if (!validateTransactions($inputData->ListOfTransaction)) {
    echo json_encode(["status" => 0, "message" => "Invalid data: Each transaction should have either a debit or a credit entry, but not both"], JSON_PRETTY_PRINT);
    exit;
}

foreach ($inputData->ListOfTransaction as $value) {
    $effectedRow += updateTransaction($value, $voucherNo, $dateAdded, $AddedBy, $ip, $Type);
}

$journal_name = '"voucherNo","dateAdded","listOfJson","transactionDate","addedBy","Type"';
$journal_val = "'{$voucherNo}','{$dateAdded}','{$ListOfJson}','{$transactionDate}','{$AddedBy}','JV'";

$journal = "INSERT INTO " . _VOUCHER_MASTER_ . " ({$journal_name}) VALUES ({$journal_val});";

MISuploadlogger("===Journal Insert====" . $journal);

$journalinsert = pg_query(OpenCon(), $journal);

if ($effectedRow > 0) {
    echo json_encode(["status" => 1, "message" => "Saved Successfully"], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => 0, "message" => "Failed to Save"], JSON_PRETTY_PRINT);
}

pg_close(OpenCon());
?>