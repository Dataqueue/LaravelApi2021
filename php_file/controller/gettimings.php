<?php

define('DIR', '../');
require_once DIR . 'config.php';

$control = new Controller(); 
$admin = new Admin();
$drid = $_SESSION['doctor_id'];

$stmt =$admin->ret("SELECT dl.location_id,dl.center_name,dl.address,dl.city,dl.pincode,dl.acontact1,dl.acontact2,dt.ftime,dt.ttime,dt.day,dt.update_date,dt.status,dt.id FROM `doctor_location` as dl left join `doctor_timings` as dt on dl.location_id=dt.location_id WHERE dl.drid='".$drid."'");


while ($resultset = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($result[$resultset['location_id']])) {
        $result[$resultset['location_id']] = array("id" => $resultset['id'], "locationid" => $resultset['location_id'], "lName" => $resultset['center_name'],"address" => $resultset['address'],"city" => $resultset['city'],"pincode" => $resultset['pincode'],"contact1" => $resultset['acontact1'],"contact2" => $resultset['acontact2'], "timings" => array(array_slice($resultset,7)));
    } else {
        $result[$resultset['location_id']]["timings"][] = array_slice($resultset,7);
    }
}

if (!isset($result)) {   // don't need to check rowCount() at all
    $result = '';
} else {
    $result = array_values($result);
}

echo json_encode($result, JSON_PRETTY_PRINT);

?>