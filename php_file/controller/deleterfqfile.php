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
 header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    $id=$_GET['id'];
    echo $id;
    $stmt =$admin->ret("SELECT * FROM `file_uploads` where id=".$id);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $folderPath = "../images/".$row['rfq_id']."/".$row['file_name'];
    unlink($folderPath);
    $del=$admin->cud("DELETE FROM `file_uploads` WHERE id=".$id,"Deleted");
 
       
?>