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
$degree=$_GET['q'];
$vals = explode('--', $degree); 
$uiniversity=$_GET['uid'];
$uid = explode('--', $uiniversity); 
//$control->isLogged('admin', 'admin/index'); 
//$res =$admin->Rcud("SELECT ccouncil from ccouncil where sstid='".$vals[0]."'");
$stmt =$admin->ret("SELECT cgname FROM `college` WHERE dgid='".$vals[0]."' and uid='".$uid[0]."'");
echo "<option value=''>Select College</option>";
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$row['cgname'].'">'.$row['cgname'].'</option>';
        }
?>

