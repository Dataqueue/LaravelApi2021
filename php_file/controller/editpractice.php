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



// $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
 	// $dname= $_POST["dname"];
      
      // $gender = $_POST["gender"];
      // $mrcouncil = $_POST["mrcouncil"];
      // $mrno = $_POST["mrno"];
     // $contact=$_POST['contact'];
     // $mryear=$_POST['mryear'];
     // $dob=$_POST['dob'];
      // $certificate = $_POST["certificate"];
      
      // $_SESSION['doctor_id'];
      if(!isset($_GET['id']))
      {
      	$method = $_SERVER['REQUEST_METHOD'];
      	  $center_name= $_POST["center_name"];
          $address = $_POST["address"];
           $id =$_POST["id"];
      	 
          $city = $_POST["city"];
          $acontact2 = $_POST["acontact2"];
          $pin=$_POST['pin'];
          $acontact1 = $_POST["acontact1"];
          $fees = $_POST["fees"];
          $date=date('Y-m-d');
          $drid=104;
          $sql ="UPDATE `doctor_location` SET `drid`='".$drid."',`center_name`='".$center_name."',`address`='".$address."',`city`='".$city."',`pincode`='".$pin."',`acontact1`='".$acontact1."',`acontact2`='".$acontact2."',`updated_date`='".$date."',`status`='active',`fees`='".$fees."' WHERE location_id='".$id."'";
           $stmt =$admin->ret($sql);
    //   $target_dir="../images/docs/";
	   // $certificate=$target_dir.basename($_FILES["image"]["name"]);
	   // move_uploaded_file($_FILES["image"]["tmp_name"],$certificate);
      // $certificate = $_POST["certificate"];
      
      }
      else{
      	$lid = $_GET['id'];
      	$sql="SELECT * FROM `doctor_location` WHERE location_id='".$lid."'";
       $stmt =$admin->ret($sql);
       $row=$stmt->fetch(PDO::FETCH_ASSOC);
       echo json_encode($row);
      }
 
  ?>
     
      
       