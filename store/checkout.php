<?php

require_once('../config/functions.php');
if($ThisMyPath == false){
    if(isset($_POST['pay-now'])){
        header('location: ../store/index.php?return=checkout');
    }
    header('location: ../store/login.php?return=checkout');
}

$firstName = "";
$lastName = "";
$number = "";
$address = "";
$address2 = "";
$country = "";
$state = "";
$terms = "";
$thisEmail = $session_email;

if($thisEmail == 'Account'){
    $thisEmail = "";
    $newDetails = true;
}
if(isset($_GET['new-details'])){
    $newDetails = true;
    $thisEmail = "";
}

if(isset($session_email)){
    $allItems = getBillDetails($con, $session_email);
    if($allItems !== 0 && !isset($newDetails)){
        foreach($allItems as $item){
            $firstName = $item['firstName'];
            $lastName = $item['lastName'];
            $number = $item['number'];
            $address = $item['address'];
            $address2 = $item['address2'];
            $country = $item['country'];
            $state = $item['state'];
            $terms = $item['terms'];
        }
    }
}

if(isset($_POST['pay-now'])){

    $ref_id = md5(uniqid(time(), true));
    $name = test_input($_POST['firstName'], $con)." ".test_input($_POST['lastName'], $con);
    $date = date("d/m/Y");
    $price = test_input($_POST['order_amount'], $con);
    $params = array(
		'tran_id'=>"$ref_id",
		'email'=> test_input($_POST['email'], $con),
		'amount'=> str_replace("₦","",$price),
		'order_id'=> test_input($_POST['order_id'], $con),
		'name'=> "$name",
		'number'=> test_input($_POST['number'], $con),
		'address1'=> test_input($_POST['address'], $con),
		'address2'=> test_input($_POST['address2'], $con),
		'date_init'=>"$date",
		'user_id'=>"$session_id",
		'payment_status'=>"pending",
		'date_finished'=>""
	);
    $h = insertData($con, $params, null, null, null, 'transactions');
    if($h){
        $price_now = str_replace("₦","",$price);
        $price_now = (int)$price_now * 100;
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => test_input($_POST['email']),
            'amount' => $price_now,
            'reference' => $ref_id,
            'callback_url' => 'http://zimarex.com/payment/status.php'
        ];
        
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $secret_key",
        "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
        $obj = json_decode($result);
        $tran_url = $obj->data->authorization_url;
        header("Location: $tran_url");
        
    }else{
        //error occurred
    }

}
//echo $result;



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Checkout - <?php echo $site_info['site_title']; ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <!-- <link rel="stylesheet" href="../assets/css/styles.css" /> -->
    <link rel="stylesheet" href="../assets/css/checkout.css" />

        <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .addShadow{ 
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        .itm{
            font-size: 1.6rem;
            font-weight: 500;
        }

        .qty{
            font-size: .75em;
        }

        .pri{
            font-size: 0.8em;
        }

        .container {
            max-width: 104rem;
            margin: 0 auto;
        }

        img, svg {
            vertical-align: baseline;
        }

        .col-12, .col-sm-6{
            margin-bottom : 20px;
        }

        .btn-primary{
            padding: 10px;
            font-weight: 600;
            font-size: 1em;
        }

        .bg-primary, .btn-primary  {
            background-color: var(--primary) !important;
            color: var(--grey1;)
        }

        .text-primary{
            color : var(--primary) !important;
        }

        .form-control::placeholder {
            /* font-size: 2em; */
        }

        .form-control, .form-select{
            font-size: .85em;
        }

        .pad{
            padding: 13px 10px;
        }

        .form-check-label{
            font-size: .88em;
        }

        .overlay {
            visibility: hidden;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            position: fixed;
            background: #222e;
        }

        .overlay__inner {
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .overlay__content {
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner {
            width: 75px;
            height: 75px;
            display: inline-block;
            border-width: 2px;
            border-color: rgba(255, 255, 255, 0.05);
            border-top-color: #fff;
            animation: spin 1s infinite linear;
            border-radius: 100%;
            border-style: solid;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .see{
            visibility: visible;
        }
    </style>
    
    <!-- Custom styles for this template -->

  </head>
  <body class="bg-light">

        <div class="overlay">
            <div class="overlay__inner">
                <div class="overlay__content">
                    <span class="spinner"></span>
                    <p style="color: #fff; font-weight: bold; margin-left: -10px;">Please Wait</p>
                </div>
            </div>
        </div>
    
        <?php require_once('../libs/nav.php') ?>

<div class="container" style="margin-bottom: 80px ">
  <main>
    <div class="text-center" style="margin: 80px auto; margin-bottom: 50px ">
        
      <h2>Checkout</h2>
      <br>
      <hr>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
        <a href="./cart.php" style="border: 1px solid var(--secondary); padding: 6px 15px; border-radius: 30px;">
          <span class="text-primary">Return to cart</span>
        </a>
        <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          
          <li class=" pad list-group-item d-flex justify-content-between insert-cart" >
            <span> <b>Total (NGN)</b></span>
            <strong class="last_price">0</strong>
          </li>
        </ul>

        <!-- <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </form> -->
        </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form id="pay-now" class="needs-validation" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form" method="post">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label"> <b>First name</b> </label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value="<?php echo $firstName; ?>" required name="firstName">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label"><b>Last name</b></label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value="<?php echo $lastName; ?>" required name="lastName">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    
                        <!-- <div class="col-12">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" id="username" placeholder="Username" required>
                        <div class="invalid-feedback">
                            Your username is required.
                            </div>
                        </div>
                        </div> -->

                        <div class="col-7">
                            <label for="email" class="form-label"> <b>Email</b> <span class="text-muted"></span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@mail.com" required name="email" value="<?php echo $thisEmail; ?>" <?php if($thisEmail != '') echo "readonly" ?> >
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-5">
                            <label for="phone number" class="form-label"> <b>Number</b> <span class="text-muted"></span></label>
                            <input type="number" class="form-control" id="phone-num" placeholder="0XXXXXXXXXX" required name="number" value="<?php echo $number; ?>">
                            <div class="invalid-feedback">
                                Please enter a valid number for shipping updates.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label"> <b>Address</b></label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St" required name="address" value="<?php echo $address; ?>">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label"> <b>Address 2</b> <span class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite" name="address2" value="<?php echo $address2; ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label"> <b>Country</b></label>
                            <select class="form-select" id="country" required name="country">
                                <option value="" disabled selected>Choose...</option>
                                <option value="Nigeria">Nigeria</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="state" class="form-label"> <b>State</b></label>
                            <select class="form-select" id="state" required name="state">
                                <option value="" disabled selected>Choose...</option>
                                <option value="Rivers">Rivers</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="same-address" checked disabled name="same-address">
                        <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required name="terms" <?php echo $terms; ?>>
                        <label class="form-check-label" for="save-info"> <a href="<?php echo $newUrl ?>terms.php"> I agree to the terms and conditions </a></label>
                    </div>

                    <?php if(isset($newDetails)){ ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="save-info">
                            <label class="form-check-label" for="save-info">Save this information for next time</label>
                        </div>
                    <?php }else{ ?>
                        <br>
                        <a href="?new-details=set"> <b>Click here if you want to use another shipping details</b> </a>
                    <?php } ?>

                    <hr class="my-4" style="opacity: 0.09">
                    <input type="hidden" name='pay-now' value="set">
                    <input type="hidden" class='order_id' name="order_id" value="" >
                    <input type="hidden" class='order_amount' name="order_amount" value="">


                    <button class="w-100 btn btn-primary btn-lg" type="submit" style="border: none; font-size: 0.9em;">Pay Now</button>
                </form>
            </div>
        </div>
    </main>

</div>
    <?php require_once('../libs/footer.php') ?>


    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="../assets/js/products.js"></script>
    <script src="../assets/js/slider.js"></script>
    <script src="../assets/js/index.js"></script>
    <script src="../assets/js/checkout.js"></script>

    <script> 
        const uniqueID = () => {
            return new Date().getTime().toString().concat(performance.now());
        }
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            let forms = document.querySelectorAll('.needs-validation')
            const overlay = document.querySelector('.overlay');
            const order_id = document.querySelector('.order_id');
            const order_amount = document.querySelector('.order_amount');
            const allElem = [...document.querySelectorAll('.pad-list-item')];
            
            const newElem = allElem.map(e=>{
                return e.children[2].value;
            });
            const newElemQty = allElem.map(e=>{
                let xx = e.children[0].children[1].innerText;
                return xx.replace("Quantity : ", "");
            });
            let uniId = uniqueID();
            uniId = "id"+uniId.replace('.', '');
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation()
                    }else{
                        event.preventDefault();
                        overlay.classList.add("see");

                        let condtiton = addToOrders(uniId, newElem, newElemQty) !important;

                        if(condtiton == newElem.length){
                            // console.log(condtiton);
                            order_id.value=uniId;
                            order_amount.value=last_price.innerText;
                            form.submit();
                        }
                    }

                    form.classList.add('was-validated')
                }, false);
            })
        })()
    </script>
  </body>
</html>
