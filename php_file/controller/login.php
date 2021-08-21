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
$uname=$_POST['demailo'];
$pwd =$_POST['passwordu'];  
$stmt =$admin->ret("SELECT * FROM `doctors` WHERE demail='".$uname."' and password='".$pwd."'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count=$stmt->rowCount();
if($count>0){
	$_SESSION['doctor_id'] = $row['drid'];
	echo '<script>alert("Successfully loged in");window.location="http://www.veidya.com/Doctor/"</script>';
   
}else{
	echo '<script>alert("Failed to login");window.location="../index.php"</script>';
}  
?>

