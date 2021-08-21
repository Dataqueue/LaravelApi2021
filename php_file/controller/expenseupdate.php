<?php
/**
 * Created by.
 * User: Shameer Ahmed
 * Date: 06/10/2020
 * Time: 5:30
 */
define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"));
$tax=$_POST['tax'];
$company_name=$_POST['company_name'];
$paid_date=$_POST['paid_date'];
$referrence_bill_no=$_POST['referrence_bill_no'];
$amount=$_POST['amount'];
$paid_to=$_POST['paid_to'];
$paid_by=$_POST['paid_by'];
$description=$_POST['description'];
$created_by=$_POST['created_by'];
$payment_account_id=$_POST['payment_account_id'];
$account_category_id=$_POST['account_category_id'];
$id=$_POST['id'];
$target_dir="expenses/filePath/";
$image=$target_dir.basename($_FILES["file_path"]["name"]);


if($image)
{
$fname= $_SERVER["DOCUMENT_ROOT"]."/amaco_test/public/expenses/filePath/";
echo $fname;

 $name = $fname.basename($_FILES["file_path"]["name"]);
 move_uploaded_file($_FILES["file_path"]["tmp_name"],$name);
  
 $stmt =$admin->ret("UPDATE `expenses` SET `file_path`='".$image."',`company_name`='".$company_name."',`paid_date`='".$paid_date."',`referrence_bill_no`='".$referrence_bill_no."',`amount`='".$amount."',`paid_to`='".$paid_to."',`description`='".$description."',`account_category_id`='".$account_category_id."' WHERE id='".$id."'");

echo "accountcategoryid".$account_category_id;
  $someArray = json_decode($_POST['data'], true);
  $stmts =$admin->ret("SELECT * FROM `columns` where account_category_id='".intval($account_category_id)."'");
      $cnt = $stmts->rowCount();
 
    $del=$admin->cud("DELETE FROM `column_data` WHERE expense_id=".$id,"Deleted");
    foreach ($someArray as $row) {
      echo "length of arry".$row['id'];
    if($row['type']=='date')
    {
     $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$id."','".$row['id']."','".$row['date']."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);
      echo $row['id'];
    }
    else if($row['type']=='text')
    {
     $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$id."','".$row['id']."','".$row['value']."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);
      echo "success2";
    }
  }
}
else
{
	$stmt =$admin->ret("UPDATE `expenses` SET `referrence_bill_no`='".$referrence_bill_no."',`amount`='".$amount."',`paid_to`='".$paid_to."',`paid_date`='".$paid_date."',`company_name`='".$company_name."',`tax`='".$tax."',`description`='".$description."',`account_category_id`='".intval($account_category_id)."',`payment_account_id`='".intval($paid_by)."',`paid_by`='".intval($paid_by)."' WHERE id='".$id."'");
 echo "accountcategoryid".$account_category_id;
	$someArray = json_decode($_POST['data'], true);
  $stmts =$admin->ret("SELECT * FROM `columns` where account_category_id='".intval($account_category_id)."'");
      $cnt = $stmts->rowCount();
 
    $del=$admin->cud("DELETE FROM `column_data` WHERE expense_id=".$id,"Deleted");
    foreach ($someArray as $row) {
      echo "length of arry".$row['id'];
    if($row['type']=='date')
    {
     $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$id."','".$row['id']."','".$row['date']."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);
      echo $row['id'];
    }
    else if($row['type']=='text')
    {
     $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$id."','".$row['id']."','".$row['value']."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);
      echo "success2";
    }
     else if($row['type']=='file')
    {
      $subfname= $_SERVER["DOCUMENT_ROOT"]."/amaco_test/public/expenses/filePath/";
      echo $subfname;

    $subname = $fname.basename($_FILES["file".$row['id']]["name"]);
    move_uploaded_file($_FILES["file".$row['id']]["tmp_name"],$name);
    $subimage=$target_dir.basename($_FILES["file".$row['id']]["name"]);
     $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$id."','".$row['id']."','".$subimage."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);
      echo "success2";
    }

  }
  // }

}

?>

      
