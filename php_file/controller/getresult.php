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
$states=$_GET['q'];
$vals = explode('--', $states); 
//$control->isLogged('admin', 'admin/index'); 
//$res =$admin->Rcud("SELECT ccouncil from ccouncil where sstid='".$vals[0]."'");
$stmt =$admin->ret("SELECT ccouncil from ccouncil where sstid='".$vals[0]."'");
echo "<option>Select Council</option>";
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'.$row['ccouncil'].'">'.$row['ccouncil'].'</option>';
              }
?>

