<?php

require_once ('.config.php');
require_once ('sessions.php');


//check if session user is still in database
if(isset($session_id)){

	$query = $con->query("SELECT * FROM users WHERE unique_id = '$session_id' ");
	$rows_user = $query->num_rows;
	if($rows_user < 1){
		
		session_destroy();
		unset($session_id);
		unset($session_email);
		header('location: ../store/login.php?logout-now=true');
	}
}


function getProducts($con, $limit=16, $table="products_all"){

	if( $limit >= 5 ){
		$sql = "SELECT * FROM $table LIMIT $limit";
	}else{
		$sql = "SELECT * FROM $table";
	}

    $query = $con->query($sql);
	$rows = $query->num_rows;
    
	if($rows > 0){
		$result = array();  
        while($newRes = $query->fetch_array()){
            $result[] = $newRes;
        }
		return $result;
	} else{
		return $rows;
	}
}

function searchProducts($con, $string, $category){
	
	$stmt = $con->prepare("SELECT * FROM products_all WHERE name LIKE ? AND category = ? ");
	$stmt->bind_param("ss", $string, $category);
	$stmt->execute();
	$res = $stmt->get_result();
	
	$result = array();
	while($newRes = $res->fetch_assoc()){
		$result[] = $newRes;
	}
	return $result;

}

function getSingleProd($con, $id){
	
	$stmt = $con->prepare("SELECT * FROM products_all WHERE unique_key = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$res = $stmt->get_result();
	
	return $newRes = $res->fetch_array();

}

function editSingleProd($con, $param, $id, $table="products_all"){
	
	$query = "UPDATE $table SET";
	$comma = " ";
	foreach($param as $key => $val) {
		if( ! empty($val)) {
			$query .= $comma . $key . " = '" . mysqli_real_escape_string($con, trim($val)) . "'";
			$comma = ", ";
		}
	}
	$query = $query." WHERE unique_key = '$id' ";
	//return $query;
	if($con->query($query) === true){
		return true;
	}else{
		return false;
	}

}

function searchCart($con, $stringId){
	
	$sql = "SELECT * FROM cart WHERE user_id = '$stringId' AND status = 'true'" ;

	$query = $con->query($sql);

	$result = array();   
	while($newRes = $query->fetch_assoc()){
		$result[] = $newRes;
	}
	return $result;

}

function prodDetails($con, $prodId=0){
	$sql = "SELECT * FROM products_all WHERE unique_key = '$prodId' ";

    $query = $con->query($sql);
	$rows = $query->num_rows;
    
	if($rows > 0){
		$result = array();  
        while($newRes = $query->fetch_array()){
            $result[] = $newRes;
        }
		return $result;
	} else{
		return $rows;
	}
    
}

function insertData($con, $params=null, $uId=null, $prodId=null, $auant=null, $table="cart"){
	if($params != null){
		$columns = implode(', ', array_keys($params));
		$values = array_map(function($i){
			return "'".$i."'";
		},$params);
		$values = implode(', ', array_values($values));

		if($uId !== null || $prodId !== null){ 
			
			$sql = "SELECT * FROM $table WHERE user_id = '$uId' AND prod_id = '$prodId' ";
			
			if($query = $con->query($sql)){ 

				$count = $query->num_rows;
				
				$count = (int)$count;
				if($count >= 1){
					
					$sql = "UPDATE $table SET quantity='$auant'  WHERE user_id = '$uId' AND prod_id = '$prodId'";
					$con->query($sql);
				}else{
					$sql = "INSERT INTO $table ($columns) VALUES ($values)";
					if($con->query($sql)){
						// return "added";
					}else{
						// return $con->error;
					}
				}
			}
		}else{
			
			//echo $values;
			$sql = "INSERT INTO $table ($columns) VALUES ($values)";
			if($con->query($sql)){
				return true;
			}else{
				//echo $con->error;
				return false;

			}
		}
	}
	
}

function deleteItem($con, $table, $unique, $column="unique_key"){
	// sql to delete a record
	$sql = "DELETE FROM $table WHERE $column='$unique' ";

	if ($con->query($sql) === TRUE) {
		return "true";
	} else {
		return "false";
	}

	// $con->close();
}

function adminPriviledges($con, $id, $cuuStat){
	$newStat = $cuuStat? "" : "yes";
	$sql = "UPDATE users SET is_admin='$newStat'  WHERE unique_id = '$id' ";
	
	if($con->query($sql)){
		return true;
	}else{
		return false;
	}
}

function addToCart($con, $user, $item, $quantity){

	$params = array(
		'user_id'=>"$user",
		'prod_id'=>"$item",
		'quantity'=>"$quantity"
	);
	$res = insertData($con, $params, $user, $item, $quantity);
}

function addToProductList($con, $unique_key, $name, $price, $old_price, $short_desc, $category, $in_stock, $img_1, $img_2, $img_3, $img_4, $img_5, $long_desc, $reviews, $purchases, $date_added, $measurement, $true=true, $id=null){

	$params = array(
		'unique_key'=>"$unique_key",
		'name'=>"$name",
		'price'=>"$price",
		'old_price'=>"$old_price",
		'short_desc'=>"$short_desc",
		'category'=>"$category",
		'in_stock'=>"$in_stock",
		'img_1'=>"$img_1",
		'img_2'=>"$img_2",
		'img_3'=>"$img_3",
		'img_4'=>"$img_4",
		'img_5'=>"$img_5",
		'long_desc'=>"$long_desc",
		'reviews'=>"$reviews",
		'purchases'=>"$purchases",
		'date_added'=>"$date_added",
		'measurement'=>"$measurement"
	);
	if($true){
		$res = insertData($con, $params, null, null, null, "products_all");
		return $res;
	}else{
		unset($params['unique_key']);
		unset($params['date_added']);
		unset($params['reviews']);
		unset($params['purchases']);
		for ($i=1; $i < 6; $i++) { 
			if($params['img_'.$i] == ''){
				unset($params['img_'.$i]);
			}
		}
		$res = editSingleProd($con, $params, $id);
		return $res;
	}
}

function removeItem($con, $user, $item, $table='cart'){
	// echo "ddd";
	$sql = "DELETE FROM $table  WHERE user_id = '$user' AND prod_id = '$item' ";
	if($con->query($sql)){

	}else{
		//echo $con->error;
	}
}

function test_input($data, $conn=null) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	if($conn !== null){
		$data = $conn->real_escape_string($data);
	}
	return $data;
}

function checkAuthencity($email, $con){
	$sql = "SELECT * FROM users WHERE email = '$email' ";
	$query = $con->query($sql);
	$rows1 = $query->num_rows;

	if($rows1 >= 1 ){
		return false;
	}else{
		return true;
	}
}

function loginUsers($password, $user_email, $con){
	$sql = "SELECT * FROM users WHERE password = '$password' AND email = '$user_email' ";
	$query = $con->query($sql);
	if($query){
		$rows = $query->num_rows;
		if($rows > 0){
			$finRes = [];
			while($result = $query->fetch_assoc()){
				$finRes = $result;
			} 
			return $finRes;
		}else{
			return $rows;
		}
	} else{
		return 0;
	}
}

function prepareArray($con, $firstName, $lastName, $number, $address, $address2, $country, $state, $terms, $email){

	$params = array(
		'firstName'=>"$firstName",
		'lastName'=>"$lastName",
		'number'=>"$number",
		'address'=>"$address",
		'address2'=>"$address2",
		'country'=>"$country",
		'state'=>"$state",
		'terms'=>"$terms"
	);

	$find = array(
		'email'=>"$email"
	);
	$res = updateBillingDetails($con, $params, $find);
	return $res;
}

function updateBillingDetails($con, $params, $find, $table='users'){
	if($params != null){
		// get the where column
		$check = array_map(function($i){
			return $i."=?";
		},array_keys($find));
		$check = implode(',', array_values($check));

		// get the columns
		$columns = array_map(function($i){
			return $i."=?";
		},array_keys($params));

		$columns = implode(',', array_values($columns));

		// get the values
		$values = array_map(function($i){
			return $i;
		},array_values($params));
		
		$stringVal = "sssssssss";

		$sql = "UPDATE $table SET $columns WHERE $check ";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("$stringVal", $values[0], $values[1], $values[2], $values[3], $values[4], $values[5], $values[6], $values[7], $find['email']);
		// 
		if($stmt->execute()){
			return 1;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

function getBillDetails($con, $string){
	
	$sql = "SELECT * FROM users  WHERE email = '$string' ";

    $query = $con->query($sql);
	$rows = $query->num_rows;
    
	if($rows > 0){
		$result = array();  
        while($newRes = $query->fetch_array()){
            $result[] = $newRes;
        }
		return $result;
	} else{
		return $rows;
	}
    
}

function prinCategoryItem($cur_item){
	printf('
		<li>
			<!-- <input type="checkbox" name="" class="input-products" value="%s" data-include="%s"> -->
			<label for="" class="span-prod-name">
			<span >%s</span>
			<!-- <small>(10)</small> -->
			</label>
		</li>
	', $cur_item, $cur_item, $cur_item);
	return $cur_item;
}

function checkAdmin($con, $id){
	
	$sql = "SELECT * FROM users WHERE is_admin = 'yes' AND unique_id = '$id' ";

    $query = $con->query($sql);
	$rows = $query->num_rows;
    
	return $rows;
}

function uploadImg ($category, $imgUpload){
	$uploads_dir = '../assets/images/'.$category;
	if (!file_exists($uploads_dir)) {
		mkdir($uploads_dir, 0777, true);
	}
	if ($_FILES["$imgUpload"]["error"]  == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES["$imgUpload"]["tmp_name"];
		$name = basename($_FILES["$imgUpload"]["name"]);
		if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
			return "$uploads_dir/$name";
		}else{
			return 1;
		}
	}
}

function printRedirect($idd, $url){
	echo "
	<script>
                const redirect = () => {
                    setTimeout(() => {
                        window.location.href = '$url';
                    }, 1200);
                }

                (function (){
                    localStorage.setItem('userId', '$idd');
                })();
                redirect();
            </script>";
}
?> 