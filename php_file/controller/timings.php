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






$method = $_SERVER['REQUEST_METHOD'];
// $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
 	    $day= $_POST['day'];
      $fhour = $_POST['fhour'];
      $location_id = $_POST['res'];
      $thour = $_POST['thour'];
      $fminutes = $_POST['fminutes'];
      $tminutes=$_POST['tminutes'];
      $fstatus = $_POST['fstatus'];
      $tstatus = $_POST['tstatus'];
      $date=date('Y-m-d');
      $ftime=''.$fhour.':'.$fminutes.' '.$fstatus.'';
      $ttime=''.$thour.':'.$tminutes.' '.$tstatus.'';
    //   $target_dir="../images/docs/";
	   // $certificate=$target_dir.basename($_FILES["image"]["name"]);
	   // move_uploaded_file($_FILES["image"]["tmp_name"],$certificate);
      // $certificate = $_POST["certificate"];
      $id=1;
       $date=date('Y-m-d');
      
       $sql ="INSERT INTO `doctor_timings`(`location_id`, `day`, `ftime`, `ttime`, `update_date`, `status`) VALUES ('$location_id','$day', '$ftime', '$ttime', '$date','active')";
       $stmt =$admin->ret($sql);

      
//$input = json_decode(file_get_contents('php://input'),true);

?>