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
    
    // print_r($data);
    // echo $data;
 
    $res=array($data);
    // var_dump($res);
    
    // var_dump("requested_date".$_POST['requested_date']);
    // var_dump("requested_date".$_POST['requested_date']);
    // var_dump("rfqid".$_POST['rfqid']);
//     $rfqdet = $_POST['rfq_details'];
//     $rfqdd = (array)$rfqdet;
//     var_dump($_POST['tags']);
       $someArray = json_decode($_POST['rfq'], true);
      // var_dump($someArray['rfq']);        // Dump all data of the Array
      
      $rdate =$someArray["requested_date"];
      $ddate=$someArray["require_date"];
      $rfqid=$someArray["rfqid"];
//  // $rfqdb= "INSERT INTO `r_f_q_s`(`requested_date`, `require_date`, `party_id`,`created_at`, `updated_at`) VALUES ('$rdate','$ddate','$pid',now(),now())";
 $rfqdb="UPDATE `r_f_q_s` SET `requested_date`='".$rdate."',`require_date`='".$ddate."',`created_at`=now(),`updated_at`=now() WHERE id='".$rfqid."'";

//  $stmtrfq =$admin->Rcud($rfqdb);
 $del=$admin->cud("DELETE FROM `r_f_q_details` WHERE rfq_id=".$rfqid,"Deleted");
  foreach ($someArray['rfq'] as $row) {

   
 
    echo "hi";
    $details="INSERT INTO `r_f_q_details`(`rfq_id`, `product_id`, `description`, `quantity_required`,`created_at`, `updated_at`) VALUES ('".$rfqid."','".$row['product_id']."','".$row['description']."','".$row['quantity_required']."',now(),now())";
    $stmtrfqdetaildb =$admin->ret($details);
 
  // else
  // {
  //      echo $row['id'];
  //      echo $row['description'];
  //      echo $row['product_name'];
  //      echo $row['quantity_required'];
  //     $details="UPDATE `r_f_q_details` SET  `rfq_id`='".$rfqid."',`product_id`='".$row['product_id']."',`description`='".$row['description']."',`quantity_required`='".$row['quantity_required']."',`created_at`=now(),`updated_at`=now() WHERE id='".$row['id']."'";
  //     $stmtrfqdetaildb =$admin->ret($details); 
  // }
}
//     //print_r($res);
   $images = count($_FILES);
//    echo "selected image";
//    echo $images;

for($a = 0; $a<$images; $a++)
{
    
    mkdir("../images/".$rfqid);
    $target_dir = "../images/".$rfqid."/";
    $name=$_FILES["myFile".$a]["name"];
    $target_file = $target_dir . basename($_FILES["myFile".$a]["name"]);
    
    //moving multiple images inside folder
    if (move_uploaded_file($_FILES["myFile".$a]["tmp_name"], $target_file)) {
      $sql ="INSERT INTO `file_uploads`(`rfq_id`, `file_name`) VALUES ('$rfqid','$name')";
       $stmt =$admin->ret($sql);
    echo "The file ". basename( $_FILES["myFile".$a]["name"]). " has been uploaded.";
    } else {
    echo "Sorry, there was an error uploading your file.";
    }
    
}

 
       
?>