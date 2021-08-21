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
// define('DIR', '');
// require_once DIR . 'config.php';

// $control = new Controller(); 
// $admin = new Admin();
//$control->isLogged('admin', 'admin/index'); 
 $id=$_GET['id'];

$stmt = $admin->cud("DELETE FROM `doctors` where drid=".$id,"Deleted");
$del=$admin->cud("DELETE FROM `degrees` where drid=".$id,"Deleted");
$del=$admin->cud("DELETE FROM `affiliation` where drid=".$id,"Deleted");
echo "<script>alert('Successfully deleted'); window.location='../Vadmin/dashboard.php';</script>";
         

?>