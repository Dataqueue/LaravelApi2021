 <?php
/**
 * Created by PhpStorm.
 * User: your name
 * Date: todays date
 * Time: todays time
 */
define('DIR', '../');
require_once DIR . 'config.php';
require('../app/textlocal.class.php');

$control = new Controller(); 
$admin = new Admin();
//$control->isLogged('admin', 'admin/index'); 

$textlocal = new Textlocal('shobhithnnaik123@outlook.com', 'Gfgcmangalore@2007');
// $textlocal = new Textlocal('shaa201830@gmail.com', 'Aa@12345');
//$textlocal = new Textlocal('suhaibkazi7@yahoo.com', 'Projectsms1');

$contno = array($_GET['q']);
$mobile=$_GET['q'];

$sender = 'TXTLCL';
//$status="new";

$otphone=$admin->ret("SELECT `contno` FROM `otp` WHERE contno='".$mobile."'");
$count=$otphone->rowCount();
if($count)
{ 
	//if person already entered phone no etc
	$satus=$admin->ret("SELECT `status` FROM `otp` WHERE status='verified'");
	$cont=$satus->rowCount();
	if($cont){
		//people who already verified
	  	$doctphone=$admin->ret("SELECT `contact` FROM `doctors` WHERE contact='".$mobile."'");
		$cnt=$doctphone->rowCount();
	  	if($cnt){
	  			//if same person exist in doctors table
		  		$mone=$admin->ret("SELECT * FROM `otp` WHERE contno='".$mobile."'");
		  		while ($rw = $mone->fetch(PDO::FETCH_ASSOC)) 
	  		{   
	  			//$satus=$rw['status'];
	  			$otp = $rw['otp'];
		  		$message ='Your already registered.Please try again with another number!';
		    }
		}else
		{	//if data not exist in doctors table update new otp and send otp
		    $otp = rand(1000,9999);
		  	$message = $otp.' is your onetime password to proceed on Veidya.Do not share your OTP with anyone';
			$sumo =$admin->Rcud("UPDATE `otp` SET `otp`='".$otp."' WHERE contno='".$mobile."'");		
		}
	}else
	{	//SELECT * FROM `otp` WHERE datetime >= NOW() - INTERVAL 10 MINUTE
		//actual query;- datetime is column name
		$mone=$admin->ret("SELECT * FROM `otp` WHERE contno='".$mobile."' and datetime >= NOW() - INTERVAL 10 MINUTE");
		$ow = $mone->fetch(PDO::FETCH_ASSOC);
		 
		$cnt=$mone->rowCount();
	  	if($cnt){   
	  			//$satus=$ow['status'];
	  			$otp = $ow['otp'];
		  		$message = $ow['otp'].' is your onetime password to proceed on Veidya.Do not share your OTP with anyone';
		    //}
  	    }else
  	    {
  	  //   	$satus='';
	  		// $otp = '';
		  	// $message = 'Your time got expired';
  			$hone=$admin->ret("DELETE FROM otp WHERE contno='".$mobile."'");
  			$otp = rand(1000,9999);
			$status="new";
			$message = $otp.' is your onetime password to proceed on Veidya.Do not share your OTP with anyone';
			$sumo =$admin->Rcud("INSERT INTO `otp`( `contno`, `otp`, `status`,`datetime`) VALUES ('".$mobile."','".$otp."','".$status."',now())");
  	    }	      
  	}
}else
{
	//for new user 
$otp = rand(1000,9999);
$status="new";
$message = $otp.' is your onetime password to proceed on Veidya.Do not share your OTP with anyone';
$sumo =$admin->Rcud("INSERT INTO `otp`( `contno`, `otp`, `status`,`datetime`) VALUES ('".$mobile."','".$otp."','".$status."',now())");
}
//sending otp message to mobile
try {
    $result = $textlocal->sendSms($contno, $message, $sender);
    //print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>