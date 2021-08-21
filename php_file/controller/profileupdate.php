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

$target_dir="../images/profilepic/";
$image=$target_dir.basename($_FILES["image"]["name"]);
if(move_uploaded_file($_FILES["image"]["tmp_name"],$image))
{
  $drid=$_SESSION['doctor_id'];
  $sql ="UPDATE `doctors` SET `profilepic`='".$image."' WHERE drid='".$drid."'";
  $stmt =$admin->cud($sql,"");
  echo '[{"drid":"104","image":"'.$image.'","status":"Success"}]';
}
else
{
  echo '[{"drid":"104","dname":"Reshma H","data":"Failed"}]';
}
      
?>