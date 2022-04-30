<?php

require_once('../config/functions.php');


if(isset($_POST['pId'])){
    $userId = $_POST['uId'];
    $tranId = $_POST['tId'];
    $pId = $_POST['pId'];
    $pQty = $_POST['pQty'];
    
	$sql = "SELECT * FROM orders WHERE user_id = '$userId' AND order_id = '$tranId' AND item_id = '$pId' AND status = 'pending' ";
    $query = $con->query($sql);
	$rows = $query->num_rows;
    
    // echo $rows;
	if($rows == '0'){
        $sql = "INSERT INTO orders (user_id, order_id, item_id, status, qty) VALUES ('$userId', '$tranId', '$pId', 'pending', '$pQty' )";
		if($con->query($sql)){
            echo 1;
        }else{
            echo 0;
        }
	}else{
        echo 0;
    }
} 

?>