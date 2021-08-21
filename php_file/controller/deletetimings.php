<?php
/**
 * Created by PhpStorm.
 * User: Shameer
 * Date: 12/10/2020
 * Time: todays time
 */

define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();

$method = $_SERVER['REQUEST_METHOD'];

 $id=$_POST['id'];

$stmt = $admin->cud("DELETE FROM `doctor_timings` where id=".$id,"Deleted");

         

?>