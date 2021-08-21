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
$id=$_GET['id'];
//$control->isLogged('admin', 'admin/index'); 
//$res =$admin->Rcud("SELECT ccouncil from ccouncil where sstid='".$vals[0]."'");
$stmt =$admin->ret("SELECT * FROM `account_categories` WHERE id='".$id."'");
echo '[';
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo json_encode($row);

  echo ']';
?>

