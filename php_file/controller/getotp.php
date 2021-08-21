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
$otp = $_GET['otp'];
$stmtn =$admin->ret("SELECT otp FROM `otp` where contno='".$mno."' and otp='".$otp."' and status='new'");
$count=$stmtn->rowCount();
if($count>0)
{
	//$st =$admin->Rcud("UPDATE otp set status='verified' where contno='".$mno."' and otp='".$otp."'");
	echo 'true';
	return true;
}else{
	echo 'false';
	return false;

}
?>

