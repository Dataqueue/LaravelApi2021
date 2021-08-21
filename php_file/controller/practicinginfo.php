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






$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
 	    $center_name= $_POST["center_name"];
      $address = $_POST["address"];
      
      $city = $_POST["city"];
      $acontact2 = $_POST["acontact2"];
      $pin=$_POST['pin'];
      $acontact1 = $_POST["acontact1"];
      $fees = $_POST["fees"];
      $date=date('Y-m-d');
      $drid=$_SESSION['doctor_id'];
      
       $sql ="INSERT INTO `doctor_location`(`drid`, `center_name`, `address`, `city`, `pincode`, `acontact1`, `acontact2`, `updated_date`, `status`,`fees`) VALUES ('$drid','$center_name', '$address', '$city', '$pin','$acontact1','$acontact2','$date','active','$fees')";
       $stmt =$admin->ret($sql);

      
//$input = json_decode(file_get_contents('php://input'),true);

?>