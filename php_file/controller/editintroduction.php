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
// $control->notLogged('admin', '../dashboard'); 
$admin = new Admin();
$drid=$_SESSION['doctor_id'];
$about=$_POST['about'];
$stmt =$admin->cud("update `doctors` set about='".$about."' WHERE drid='".$drid."'");
echo "Successfully Updated...!";
?>
