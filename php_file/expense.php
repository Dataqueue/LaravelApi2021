<?php
/**
 * Created by PhpStorm.
 * User: your name
 * Date: todays date
 * Time: todays time

 */
define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();
 header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


     $folderPath = "../images/";
   
    
   //  $certificate=$folderPath.basename($_FILES["file"]["name"]);
   //   move_uploaded_file($_FILES["file"]["tmp_name"],$certificate);
   
   // return json_encode(['status'=>true]);
     
    $data = json_decode(file_get_contents("php://input"));
    echo "received data111";
    $images = count($_FILES);
   echo "selected image";
   echo $images;


    
    mkdir("../images/");
    $target_dir = "../images/";
    $name=$_FILES["file_path"]["name"];
    $target_file = $target_dir . basename($_FILES["file_path"]["name"]);
    move_uploaded_file($_FILES["file_path"]["name"], $target_file);
    // print_r($data);
    // echo $data;
 
   
  $amount=$_POST['amount'];
  $referrence_bill_no=$_POST['referrence_bill_no'];
  $payment_account_id=$_POST['payment_account_id'];
  $description=$_POST['description'];
  $account_category_id=$_POST['account_category_id'];
  $created_by=$_POST['created_by'];
  $paid_to=$_POST['paid_to'];
  if($_POST['tax'])
  {
    
    $rfqdb= "INSERT INTO `expenses`(`created_by`,`referrence_bill_no`, `paid_date`, `paid_to`, `amount`, `payment_account_id`, `description`, `created_at`, `updated_at`,`file_path`,`tax`,) VALUES ('".$created_by."','".$referrence_bill_no."','".$paid_date."','".$paid_to."','".$amount."','".$payment_account_id."','".$description."',now(),now(),'".$name."','".$_POST['tax']."')";
    $stmtrfq =$admin->Rcud($rfqdb);
  }
  else
  {
    $rfqdb= "INSERT INTO `expenses`(`created_by`,`referrence_bill_no`, `paid_date`, `paid_to`, `amount`, `payment_account_id`, `description`, `created_at`, `updated_at`,`file_path`) VALUES ('".$created_by."','".$referrence_bill_no."','".$paid_date."','".$paid_to."','".$amount."','".$payment_account_id."','".$description."',now(),now(),'".$name."')";
    $stmtrfq =$admin->Rcud($rfqdb);
  }
 
 $someArray = json_decode($_POST['data'], true);
  foreach ($someArray as $row) {


 $stmt =$admin->ret("SELECT * FROM `columns` where account_category_id='".$account_category_id."'");
 while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row1['name']==$row['name'])
        {
          if($row['type']==='file')
          {
            mkdir("../images/");
            $target_dir1 = "../images/";
            $name=$_FILES["file_path"]["name"];
            $target_file = $target_dir . basename($_FILES["file_path"]["name"]);
          move_uploaded_file($_FILES["file_path"]["name"], $target_file);
          }
      $details="INSERT INTO `column_data`(`expense_id`, `column_id`, `value`,`created_at`, `updated_at`) VALUES ('".$stmtrfq."','".$row1['id']."','".$row['text']."',now(),now())";
      $stmtrfqdetaildb =$admin->ret($details);

        }
        else
        {
          echo 'failure';
        }


      }
  
}
 
 

 
       
?>