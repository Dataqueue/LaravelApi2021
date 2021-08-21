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

$pwd =$_GET['q'];  
$stmt =$admin->ret("SELECT `mrno` FROM `affiliation` WHERE mrno='".$pwd."'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();
if($count>0){
	echo 'true';
}else{
	echo 'false';
}  
?>

