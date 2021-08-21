<?php
define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();
$s='new';
$stmt =$admin->ret("SELECT dl.paid_to,dl.amount,dl.id,dt.name,dl.payment_account_id,dl.referrence_bill_no,dl.created_at,ac.name as account_name FROM `expenses` as dl inner join `payment_accounts` as dt inner join `account_categories` as ac on dl.payment_account_id=dt.id and ac.id=dl.account_category_id and dl.status='".$s."'");


while ($resultset = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($result['id'])) {
        $result[$resultset['id']] = array("id" => $resultset['id'],"paid_to" => $resultset['paid_to'], "amount" => $resultset['amount'],"referrence_bill_no" => $resultset['referrence_bill_no'],"created_at" => $resultset['created_at'],"account_name" => $resultset['account_name'],"payment_account" => $resultset);
      }
      else
      {
        $result[$resultset['id']]["payment_account"][] = array_slice($resultset,0);
      }
}

if (!isset($result)) {   // don't need to check rowCount() at all
    $result = '';
} else {
    $result = array_values($result);
}

echo json_encode($result, JSON_PRETTY_PRINT);


    ?>