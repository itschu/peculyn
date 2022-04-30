<?php
    
    require_once('../config/functions.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../PHPMailer-master/src/PHPMailer.php'; // Only file you REALLY need
    require '../PHPMailer-master/src/Exception.php'; // If you want to debug
            
    if(isset($_GET['trxref']) && isset($_GET['reference'])){
        $ref = $_GET['reference'];
    }else{
        header('Location : http://google.com');
    }
    

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
          "Authorization: Bearer sk_test_a7b277eaef1027fefe63674fca48268bbb8a6e1d",
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
        $date_now= date("Y-m-d h:i:sa");
        $tran_status = $obj->data->status;
        if($tran_status == 'success'){
            echo "success";
        }
    }
    
    
?>