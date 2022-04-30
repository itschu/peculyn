<?php

require_once('../config/functions.php');


if(isset($_POST['data'])){
    $userId = $_POST['id'];
    $someKey = $_POST['data'];
    if(!empty($someKey) && $userId !== '0'){ 
        //echo $userId;
        removeItem($con, $userId, $someKey);
    }

}


?>