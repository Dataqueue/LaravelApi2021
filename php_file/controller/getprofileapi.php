<?php


function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
}
cors();

define('DIR', '../');
require_once DIR . 'config.php';

$control = new Controller(); 
$admin = new Admin();
if(isset($_SESSION['doctor_id']))
{
	$drid = $_SESSION['doctor_id'];

	$stmt =$admin->ret("SELECT * FROM `doctors` inner join affiliation on doctors.drid=affiliation.drid inner join degrees on degrees.drid=doctors.drid WHERE doctors.drid='".$drid."'");
	
     $cnt = $stmt->rowCount();
    $i = 1;
    echo '[';
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        echo json_encode($row);
        if($i<$cnt)
        {
            echo ',';
        }
        $i++;
    }
    echo ']';
    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
	// echo '['.json_encode($row).']';
}
else
{
	$f = "failed".$_SESSION['doctor_id'];
	echo '[{"drid":"104","dname":"Reshma H","status":'.json_encode($f).'}]';
}
?>