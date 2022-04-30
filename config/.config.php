<?php

ob_start();

define ('HOST', 'localhost');
define ('USER', 'root');
define ('PASSWORD', '');
define ('DATABASE', 'peculyn');

$con = new mysqli(HOST, USER, PASSWORD, DATABASE);

if(!$con){
	echo "An error occured ".$con->connect_error();
}else{
	//echo "connected";
}


$sql_site_settings = "SELECT * FROM site_settings ";
$query_site_settings = $con->query($sql_site_settings);
$site_info = $query_site_settings->fetch_assoc();

$secret_key = $site_info['paystack_s_key'];

?>
