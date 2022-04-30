<?php	

$path = $_SERVER['PHP_SELF'];
session_start();
$session_email = 'Account';
if(isset($_SESSION['curr_user'])){
	$session_id = $_SESSION['curr_user'];
	$session_email = $_SESSION['curr_email'];
	
	if($path == '/my-site/zimarex/store/login.php' or $path == '/my-site/zimarex/store/sign-up.php'){
		$ThisMyPath = true;
	}
	$ThisMyPath = true;
}elseif($path == '/my-site/zimarex/store/login.php' or $path == '/my-site/zimarex/store/sign-up.php'){
	$ThisMyPath = false;
}else{
	$ThisMyPath = false;
} 

$newUrl = "/peculyn/";

if(isset($_GET['logout'])){
	session_destroy();
	unset($session_id);
	unset($session_email);
	header('location: ../store/login.php?logout-now=true');
}
 
 
?>