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

$drid=$_SESSION['doctor_id'];
$opassword=$_POST["opassword"];
$npassword=$_POST["npassword"];
$cpassword=$_POST["cpassword"];
      
$sql ="SELECT * FROM `doctors` WHERE password='".$opassword."' and drid='".$drid."'";
$stmt =$admin->ret($sql);
$count=$stmt->rowCount();

if($count>0)
{
  if($npassword==$cpassword)
  {
    $sql1="UPDATE `doctors` SET `password`='".$npassword."' WHERE drid='".$drid."'";
    $stmt1 =$admin->cud($sql1,"");
    $f = "Password reset successfull...!";
    echo $f; //'[{"status":'.json_encode($f).'}]';
  }
  else
  {
    $f = "New password missmatch";
    echo $f; //'[{"status":'.json_encode($f).'}]';
  }
}
else
{
    $f = "Entered old password is wrong";
    echo $f;
}

?>