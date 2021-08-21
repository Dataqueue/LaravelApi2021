<?php
define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();
$id=$_GET['id'];


$stmt =$admin->ret("SELECT dl.paid_to,dl.amount,dl.id,dt.name,dl.payment_account_id,dl.referrence_bill_no,dl.created_at,dl.file_path,dl.description FROM `expenses` as dl inner join `payment_accounts` as dt on dl.payment_account_id=dt.id where dl.id='".$id."'");
$stmt1 =$admin->ret("SELECT cd.id,cd.expense_id,cd.column_id,cd.value,cd.created_at,cd.updated_at,cl.account_category_id,cl.name,cl.type FROM `column_data` as cd left join columns as cl on cd.column_id=cl.id Where cd.expense_id='".$id."'");

while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
  $arr[] =$row;
}

while ($resultset = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($result['id'])) {
        $result[$resultset['id']] = array("id" => $resultset['id'],"paid_to" => $resultset['paid_to'], "amount" => $resultset['amount'],"referrence_bill_no" => $resultset['referrence_bill_no'],"created_at" => $resultset['created_at'],"payment_account" => $resultset,
     "column_data"=>
       $arr,
       "column"=>$arr,
       0=>$arr,
       1=>$arr
  ,"referrenceImgUrl"=>$resultset['file_path']
       );
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

echo json_encode($result);


    ?>