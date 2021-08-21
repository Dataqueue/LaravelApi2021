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
    // print_r($data);
    // echo $data;
 
    $res=array($data);
    var_dump("pid".$_POST['party_id']);
    var_dump("requested_date".$_POST['requested_date']);
    var_dump("requested_date".$_POST['requested_date']);
    $rfqdet = $_POST['rfq_details'];
    $rfqdd = (array)$rfqdet;
    var_dump($_POST['tags']);
    $someArray = json_decode($_POST['tags'], true);
  print_r($someArray);        // Dump all data of the Array
  echo $someArray[0]["name"];
  $rdate =$_POST['requested_date'];
  $ddate=$_POST['require_date'];
  $pid=$_POST['party_id'];
  $date=date('Y-m-d');
 $rfqdb= "INSERT INTO `r_f_q_s`(`requested_date`, `require_date`, `party_id`,`created_at`, `updated_at`) VALUES ('$rdate','$ddate','$pid',now(),now())";
 $stmtrfq =$admin->Rcud($rfqdb);
  foreach ($someArray as $row) {
    echo "new year";
    echo $stmtrfq;
    echo $row['id'];
    echo $row['description'];
    echo $row['quantity'];
  
    // echo $stmt['id'];
 $details="INSERT INTO `r_f_q_details`(`rfq_id`, `product_id`, `description`, `quantity_required`,`created_at`, `updated_at`) VALUES ('".$stmtrfq."','".$row['id']."','".$row['description']."','".$row['quantity']."',now(),now())";
  $stmtrfqdetaildb =$admin->ret($details);
}
    //print_r($res);
   $images = count($_FILES);
   echo "selected image";
   echo $images;

for($a = 0; $a<$images; $a++)
{
    
    mkdir("../images/".$stmtrfq);
    $target_dir = "../images/".$stmtrfq."/";
    $name=$_FILES["myFile".$a]["name"];
    $target_file = $target_dir . basename($_FILES["myFile".$a]["name"]);
    
    //moving multiple images inside folder
    if (move_uploaded_file($_FILES["myFile".$a]["tmp_name"], $target_file)) {
      $sql ="INSERT INTO `file_uploads`(`rfq_id`, `file_name`) VALUES ('1','$name')";
       $stmt =$admin->ret($sql);
    echo "The file ". basename( $_FILES["myFile".$a]["name"]). " has been uploaded.";
    } else {
    echo "Sorry, there was an error uploading your file.";
    }
    
}

 
       
?>