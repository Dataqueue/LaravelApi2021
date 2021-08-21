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
 	// $dname= $_POST["dname"];
      $demail = $_POST["demail"];
      // $gender = $_POST["gender"];
      // $mrcouncil = $_POST["mrcouncil"];
      // $mrno = $_POST["mrno"];
     $contact=$_POST['contact'];
     // $mryear=$_POST['mryear'];
     // $dob=$_POST['dob'];
      // $certificate = $_POST["certificate"];
      $drid=$_SESSION['doctor_id'];
     
      
       // $sql ="UPDATE `affiliation` SET `mrno`='".$mrno."',`mrcouncil`='".$mrcouncil."',`mryear`='".$mryear."' where drid='".$drid."'";
       $sql="UPDATE `doctors` SET `demail`='".$demail."',`contact`='".$contact."' WHERE drid='".$drid."'";
       $stmt =$admin->ret($sql);
        echo '[{"drid":"104","dname":"Reshma H","status":'.json_encode($drid).'}]';
       // $stmt1 =$admin->ret($sql1);
       
//$input = json_decode(file_get_contents('php://input'),true);

?>