<?php

require_once('../config/functions.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php'; // Only file you REALLY need
require '../PHPMailer-master/src/Exception.php'; // If you want to debug

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
        
if(isset($_GET['trxref']) && isset($_GET['reference'])){
    $ref = $_GET['reference'];
}else{
    header('Location : https://zimarex.com');
}


$sql = "SELECT * FROM transactions WHERE tran_id = '$ref' ";
$query = $con->query($sql);
$rows = $query->num_rows;
if($rows > 0){
    $result = $query->fetch_assoc();
}else{
    header('Location : https://zimarex.com');
}

$true= false;
	
if($result['payment_status'] !== 'paid'){
    $true=true;
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/$ref",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $obj = json_decode($response);
    
    if ($err) {
        // echo "cURL Error #:" . $err;
        $tran_status = 'failed';
    } else {
        $date_now= date("d/m/Y h:i:sa");
        $tran_status = $obj->data->status;
        if($tran_status == 'success'){
    
            $sql="update transactions set payment_status = 'paid', payment_date = '$date_now' WHERE tran_id = '$ref' ";
    
            if($con->query($sql) ){
                $currentStat = 'complete';
                
                $mail_success_payment1 = new PHPMailer(true); 
                $mail_success_payment2 = new PHPMailer(true);
                $dII = $result["order_id"];
                $sql = "SELECT * FROM orders WHERE order_id = '$dII' ";
                $query = $con->query($sql);
                $rows = $query->num_rows;
                $DELcart = $rows;
                if($rows > 0){
            		$resultss = array();  
                    while($newRes = $query->fetch_assoc()){
                        //$getItNw = $newRes['item_id'];
                        //$con->query("update orders set status = 'paid WHERE user_id = '$session_id' AND order_id ='$dII' AND item_id = '$getItNw' ");
                        $resultss[] = $newRes;
                    }
                }else{
                    $resultss = [];
                }
                
                $msgg = "";
                foreach($resultss as $itm){
                    $unid = $itm['item_id'];
                    $itmQty = $itm['qty'];
                    $query = $con->query("SELECT * FROM products_all WHERE unique_key = '$unid' ");
                    while($news = $query->fetch_assoc()){
                        $itmName =  $news['name'];
                        $itmPrice =  $news['price'];
                        $itmPrice *= (int)$itmQty;
                        $msgg .= "<tr>
                            <td> $itmName </td>
                            <td> $itmQty </td>
                            <td> ₦$itmPrice </td>
                          </tr> ";
                    }
                }
                //echo $msgg;
                require_once('../send-mail/customer.php');
                //require_once('../send-mail/admin.php');
    
            }else{
                //echo $conn->error;
            }
        }
    }
    //echo "mail not sent already";
}else{
    //echo "mail sent already";
}
    
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon" /> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title> Transactions - Zimarex | Ecommerce Webstore</title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        .addShadow{
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }
        
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .alert-dismissable .close, .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        .close {
            float: right;
            font-size: 21px;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            filter: alpha(opacity=20);
            opacity: .2;
        }
        
        .alert{
            position: relative;
            top: 0px;
            z-index: 1;
        }
    </style>
</head>

<body>
     <!-- Navigation -->
    <?php 
        require_once('../libs/nav.php') 
    ?>

    <div class="showLoader" style="min-height :70vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class='alert alert-success'>
            <strong>Success!</strong> Your payment has been received and a mail sent to you. <br> <a href="/account" class="alert-link"> <b>For more info check your dashboard. </b> </a>.
        </div>
    </div>
    
    
    <!-- Footer -->
    <?php 
        
        if($true){
            for($i=0; $i<(int)$DELcart; $i++){
                deleteItem($con, "cart", $session_id, $column="user_id");
            };
            echo "
            <script>
                localStorage.setItem('allItems', []);
                localStorage.setItem('cartNum', 0);
            </script>";
        }
        require_once('../libs/footer.php') 
    ?>
    <!-- End Footer -->
    <!-- Custom Scripts -->
    <script src="../assets/js/products.js"></script>
    <script src="../assets/js/slider.js"></script>
    <script src="../assets/js/index.js"></script>
</body>

</html>