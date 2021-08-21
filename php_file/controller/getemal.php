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
$mno=$_GET['q'];
$stmtn =$admin->ret("SELECT * FROM `doctors` where demail='".$mno."'"); 
$row = $stmtn->fetch(PDO::FETCH_ASSOC);
$count=$stmtn->rowCount();
if($count>0){
	echo 'true';
}else{
	echo 'false';
}  
?>
