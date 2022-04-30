<?php

require_once('../config/functions.php');


if(isset($_POST['data'])){
    $userId = $_POST['id'];
    $someArray = json_decode($_POST['data'], true);
    
    if(!empty($someArray) && $userId != '0'){ 
        $fromCartArray = [];
        foreach ($someArray as $key) {
            $fromCartArray[] = $key['id'];
            addToCart($con, $userId, $key['id'], $key['quantity']);
        }  
    }else{
        $fromCartArray = [];
    }
    
    // print_r($someArray);
	$sql = "SELECT * FROM cart WHERE user_id = '$userId' ";
    $query = $con->query($sql);
	$rows = $query->num_rows;
    
	if($rows > 0){
		$result = array();  
        while($newRes = $query->fetch_assoc()){
            if(!in_array($newRes['prod_id'], $fromCartArray)){
                //removeItem($con, $userId, $newRes['prod_id']);
            }
        }
	}
} 

?>