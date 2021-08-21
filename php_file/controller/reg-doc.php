
<?php define('DIR', '../');
require_once DIR . 'config.php';
require('../app/textlocal.class.php');
$admin = new Admin();
//$textlocal = new Textlocal('rmeliate@gmail.com', 'Poornima1998');
$textlocal = new Textlocal('shobhithnnaik123@outlook.com', 'Gfgcmangalore@2007');
//$textlocal = new Textlocal('shaa201830@gmail.com', 'Aa@12345');
$dname = $_POST['dname'];
$contact = $_POST['contact'];
$mrno = $_POST['mrno'];
$mrcouncil = $_POST['mrcouncil'];
$mno=$admin->ret("SELECT * FROM `affiliation` inner join doctors on `affiliation`.drid=`doctors`.drid and mrcouncil='".$mrcouncil."' and  mrno='".$mrno."'");
$count=$mno->rowCount();
if($count>0)
{
	$sender = 'TXTLCL';
	$row = $mno->fetch(PDO::FETCH_ASSOC);
	$contno = array($row['contact']);
	$drid=$row['drid'];
	$message='Someone is trying to use your Medical registration number. So you can contact the admin of Veidya.com for complaints.';
		try {
	    $result = $textlocal->sendSms($contno, $message, $sender);
	    //print_r($result);
	    } catch (Exception $e) {
	    //die('Error: ' . $e->getMessage());
	    }	
	//$ipaddr=$admin->get_client_ip();
	    $ipaddr = '192.168.88.23';
	$mno=$admin->ret("INSERT INTO `dispute`(`drid`, `datetimer`, `phone`, `name`, `ip`) VALUES ('".$drid."',now(),'".$contact."','".$dname."','".$ipaddr."')");
	echo '<script>alert("Your using existing MRno.If you want clarification contact at Veidya.com");window.location="../index.php";</script>';
	// $admin->redirect('../index');

}else{

 //$drid = $_POST['id'];
	$demail = $_POST['demail'];
	$password = $_POST['password'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
$res =$admin->Rcud("INSERT INTO `doctors`( `dname`, `demail`, `contact`, `password`, `dob`, `gender`) VALUES ('".$dname."','".$demail."','".$contact."','".$password."','".$dob."','".$gender."')");
	$drid = $res;
	$ststate = $_POST['ststate'];
	$valb = explode('--', $ststate);
	$university = $_POST['university'];
	$valc = explode('--', $university);
	$dename = $_POST['dename'];
	$vald = explode('--', $dename);
	$collage = $_POST['collage'];
	$yearcomp = $_POST['yearcomp'];
	
	//file upload
	$target_dir = "../images/docs/";
	$certificate = basename($_FILES["certificate"]["name"]);
	$target_file = $target_dir . basename($_FILES["certificate"]["name"]);

	move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file);

$rem=$admin->cud("INSERT INTO `degrees`(`dename`, `ststate`, `collage`, `university`, `yearcomp`, `certificate`,`drid`) VALUES ('".$vald[1]."','".$valb[1]."','".$collage."','".$valc[1]."','".$yearcomp."','".$certificate."','".$drid."')","");
	$state = $_POST['state'];
	$vala = explode('--', $state);
	$collage = $_POST['collage'];
	

	$target_dir1 = "../images/docs/";
	$mrcertificate = basename($_FILES["mrcertificate"]["name"]);
	$target_file1 = $target_dir1 . basename($_FILES["mrcertificate"]["name"]);

	move_uploaded_file($_FILES["mrcertificate"]["tmp_name"], $target_file1);

$man=$admin->cud("INSERT INTO `affiliation`(`state`, `mrno`, `mrcouncil`, `mrcertificate`,`drid`) VALUES ('".$vala[1]."','".$mrno."','".$mrcouncil."','".$mrcertificate."','".$drid."')","");
			
		if ($man==true) {
			//echo "came";
			//$_SESSION['success_message'] = 
			echo '<script>alert("Successfully registered, Wait for verification. Once verified we will notify.");window.location="../index.php";</script>';
				//$admin->redirect('../index');
		} else {
			//$_SESSION['error_message'] = "Something went wrong";
			echo '<script>alert("Something went wrong");window.location="../index.php";</script>';
			//$admin->redirect('../index');
			# code...
		}
} 
?>  