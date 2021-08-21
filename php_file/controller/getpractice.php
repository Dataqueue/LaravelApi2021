<?php
define('DIR', '../');
require_once DIR . 'config.php';
$control = new Controller(); 
$admin = new Admin();
$drid = $_SESSION['doctor_id'];
 $stmt1 = $admin->ret("SELECT * FROM `doctor_location` where drid=".$drid);
      $count=$stmt1->rowCount();
       $i=1;
       echo '[';
    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
    {
      echo json_encode($row1);
      if($i<$count)
      {
        echo  ',';
      }
      $i++;

    } 
    echo ']';
    

      

    ?>