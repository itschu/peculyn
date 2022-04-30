<?php

    require_once('../config/functions.php');
    $url = $newUrl."";
    

    $name = $price = $old_price = $short_desc = $category = $name = $long_desc = $measurement =  "";
    $reviews = 1; $purchases = 0;
    $succ = "<strong>Hurray</strong> The operation was successful";
    $error = "<strong>Opps</strong> Sorry an error ocurred. Try again later";

    if($ThisMyPath == false){
        header('location: ../store/login.php');
    }

    $isAdmin = checkAdmin($con, $session_id);
    if($isAdmin == '1'){

        $all_prod = getProducts($con, 0);
        $all_users = getProducts($con, 0, "users");    

        if(isset($_GET['all-product'])){
            $showAllProducts = $_GET['all-product'];
            if($all_prod !== 0){
                shuffle($all_prod);
            }else{
                $all_prod = [];
            }
        }else if(isset($_GET['all-users'])){
            $showAllUsers = $_GET['all-users'];
            shuffle($all_users);
        }else if(isset($_GET['add-product']) ){
            $addProd = $_GET['add-product'];
            if($all_prod == 0){
                $all_prod = [];
            }
        }else if(isset($_GET['edit-this-item']) ){
            $editProd = $_GET['edit-this-item'];
            $detailsEachItem = getSingleProd($con, $editProd);
            if(empty($detailsEachItem)){
                unset($editProd);
                unset($_GET['edit-this-item']);
                $notFound = 'set';
            }
        }

        if(isset($_POST['addProduct'])){
            $unique_key = uniqid (rand (),true); 
            $unique_key = str_replace('.','',$unique_key);
            $unique_key = "n".$unique_key;
            $date_added = date("d/m/Y");
            $name = test_input($_POST['name'], $con); $price = test_input($_POST['price'], $con); $old_price = test_input($_POST['old-price'], $con); $short_desc = test_input($_POST['short_desc'], $con); $category = test_input($_POST['category'], $con); $in_stock = test_input($_POST['in_stock'], $con); $long_desc = test_input($_POST['long_desc'], $con); $reviews = 1;$purchases = 0; $measurement = test_input($_POST['measurement'], $con);
            $imgUpload = "img_1";
            $img_1 = uploadImg($category, $imgUpload);
            $imgUpload = "img_2";
            $img_2 = uploadImg($category, $imgUpload);
            $imgUpload = "img_3";
            $img_3 = uploadImg($category, $imgUpload);
            $imgUpload = "img_4";
            $img_4 = uploadImg($category, $imgUpload);
            $imgUpload = "img_5";
            $img_5 = uploadImg($category, $imgUpload);
            if($img_1!==1 && $img_2!==1 && $img_3!==1 && $img_4!==1 && $img_5!==1){
                $insertStat = addToProductList($con, $unique_key, $name, (double)$price, (double)$old_price, $short_desc, $category, (int)$in_stock, $img_1, $img_2, $img_3, $img_4, $img_5, $long_desc, (int)$reviews, $purchases, $date_added, $measurement);
                // print_r($name);
                
                //header("Location : ".$newUrl."index.php?add-product=true&product-status=$insertStat");
                echo "<script>window.location.href='index.php?add-product=true&product-status=$insertStat';</script>";
            }
        }
        
        if(isset($_POST['editProduct'])){
            $parseThisId = test_input($_POST['theId']);
            $unique_key = uniqid (rand (),true); 
            $date_added = date("d/m/Y");
            $name = test_input($_POST['name']); $price = test_input($_POST['price']); $old_price = test_input($_POST['old-price']); $short_desc = test_input($_POST['short_desc']); $category = test_input($_POST['category']); $in_stock = test_input($_POST['in_stock']); $long_desc = test_input($_POST['long_desc']); $reviews = 1;$purchases = 0; $measurement = test_input($_POST['measurement']);
            $imgUpload = "img_1";
            $img_1 = uploadImg($category, $imgUpload);
            $imgUpload = "img_2";
            $img_2 = uploadImg($category, $imgUpload);
            $imgUpload = "img_3";
            $img_3 = uploadImg($category, $imgUpload);
            $imgUpload = "img_4";
            $img_4 = uploadImg($category, $imgUpload);
            $imgUpload = "img_5";
            $img_5 = uploadImg($category, $imgUpload);
            if($img_1!==1 && $img_2!==1 && $img_3!==1 && $img_4!==1 && $img_5!==1){
                $insertStat = addToProductList($con, $unique_key, $name, (double)$price, (double)$old_price, $short_desc, $category, (int)$in_stock, $img_1, $img_2, $img_3, $img_4, $img_5, $long_desc, (int)$reviews, $purchases, $date_added, $measurement, false, $parseThisId);
                // print_r($insertStat);
                // header("Location : ".$newUrl."index.php?add-product=true&product-status=$insertStat");
                echo "<script>window.location.href='index.php?add-product=true&product-status=$insertStat';</script>";
            }
        }

        if(isset($_GET['delete-this-item']) && !isset($_GET['product-status'])){
            $keyDel = $_GET['delete-this-item'];
            $statDel = deleteItem($con, "products_all", $keyDel);
            // echo $statDel;
            header("Location: index.php?all-product=set&delete-this-item=true&product-status=$statDel");
        }

        if(isset($_GET['delete-this-user']) && !isset($_GET['product-status'])){
            $keyDel = $_GET['delete-this-user'];
            $statDel = deleteItem($con, "users", $keyDel, "unique_id");
            // echo $statDel;
            header("Location: index.php?all-users=set&edit-this-user=true&product-status=$statDel");
        }

        if(isset($_GET['make-admin']) && !isset($_GET['product-status'])){
            $cuu = $_GET['cuu'];
            $id = $_GET['id'];
            $statDel = adminPriviledges($con, $id, $cuu);
            // echo $statDel;
            header("Location: index.php?all-users=set&edit-this-user=true&product-status=$statDel");
        }
    }

    $showBill = false;

    if(isset($_GET['billing'])){
        $showBill = true;
        $allItems = getBillDetails($con, $session_email);
        if($allItems !== 0){
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

    if(isset($_POST['firstName'])){
        $firstName = test_input($_POST['firstName'], $con);
        $lastName = test_input($_POST['lastName'], $con);
        $number = test_input($_POST['number'], $con);
        $address = test_input($_POST['address'], $con);
        $address2 = test_input($_POST['address2'], $con);
        $country = test_input($_POST['country'], $con);
        $state = test_input($_POST['state'], $con);
        $terms = "checked";

        $stat = prepareArray($con, $firstName, $lastName, $number, $address, $address2, $country, $state, $terms, $session_email);

    }

?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!-- form css -->
        <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" >

        <!-- font awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"crossorigin="anonymous"/>

        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">


        <!-- data table -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="./data-table.css" />
        <link rel="stylesheet" href="styles.css" />

        <title>Dashboard - Zimarex | E-commerce Webstore</title>

        <style>
            
            .form .label {
                text-align: center;
                font-size: 0.77em;
                margin: 5px;
                font-weight: 600;
            }

            .btn input,  .btn button{
                background: none;
                border: none;
                color: #fff;
                font-weight: 600;
                font-size: 0.9em;
            }

            .input{
                font-size: 0.79em;
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

            .dropdown-toggle::after {
                display: none;
                margin-left: 0;
                vertical-align: 0;
                content: "";
                border-top: none;
                border-right: none;
                border-bottom: 0;
                border-left: none;
            }

            .createSegment a {
                font-size: 0.75em;
                text-transform : capitalize;
            }

            .sidebar__img a{
                color: #ba0303;
                font-size: 1.7rem;
                font-weight: 600;
                text-decoration: none;
                padding: 0.5rem;
                border: 4px dashed #fff;
            }


            .alert {
                margin-top: 40px;
                text-align: center;
                width: 100%;
            }

            .dataTables_filter {
                visibility: hidden;
                display: none;
            }

            .dataTables_info{
                margin-top: 16px;
                margin-left: 20px;
                font-size: 0.95em;
            }

            .dataTables_length{
                font-size: 0.95em;
                margin: 25px;
                font-weight: 600;
            }

            .dataTables_length select {
                margin: 0px 10px;
                border-radius: 50px;
                padding: 6px;
                background: #ffffff;
                border: 1px solid #007bff;
                color: #000000;
                font-weight: 600;
            }

            .btn {
                margin-top: 5px
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
            /* padding: 10px; */
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
    </head>
    <body id="body">
        <div class="overlay">
            <div class="overlay__inner">
                <div class="overlay__content">
                    <p style="color: #fff; font-weight: 500; position: absolute; top: 34%; right: 6%; font-size: 0.8em;">
                        uploading
                    </p>
                    <span class="spinner">
                        
                    </span>
                </div>
            </div>
        </div>
        <div class="containers">

            <nav class="navbar">
                <div class="nav_icon" onclick="toggleSidebar()">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>

                <div class="navbar__left">
                    <a href="<?php echo $newUrl ?>store">Home</a>
                    <!-- <a href="#">Video Management</a> -->
                    <a class="active_link" href="#">Dashboard</a>
                </div>
                
                <div class="navbar__right">
                    <a href="<?php echo $newUrl ?>store/cart.php">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo $newUrl ?>store" >
                        <img width="30" src="assets/avatar.svg" alt="" />
                        <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
                    </a>
                </div>
            </nav>

            <main>
                <div class="main__container">
                    <!-- MAIN TITLE STARTS HERE -->

                    <div class="main__title">
                        <img src="assets/hello.svg" alt="" />
                        <div class="main__greeting">
                            <h1>Hello <?php echo $session_email ?></h1>
                            <p>Welcome to your dashboard</p>
                        </div>
                    </div>

                    <!-- MAIN TITLE ENDS HERE -->

                <!-- MAIN CARDS STARTS HERE -->
                <div class="main__cards">
                    <?php if($isAdmin == '1') {  ?>

                        <div class="cardss">
                            <i class="fa fa-shopping-cart fa-2x text-lightblue" aria-hidden="true"  ></i>
                            <div class="card_inner">
                                <p class="text-primary-p">All Products</p>
                                <span class="font-bold text-title"> <?php echo count($all_prod); ?> </span>
                            </div>
                        </div>



                        <div class="cardss">
                            <i class="fa fa-users fa-2x text-red" aria-hidden="true"></i>
                            <div class="card_inner">
                                <p class="text-primary-p">All Users</p>
                                <span class="font-bold text-title"><?php echo count($all_users); ?></span>
                            </div>
                        </div>
                    <?php }else{  ?>

                        <div class="cardss">
                            <i class="fa fa-money fa-2x text-lightblue" aria-hidden="true"  ></i>
                            <div class="card_inner">
                                <p class="text-primary-p">Total Purchases</p>
                                <span class="font-bold text-title">₦0</span>
                            </div>
                        </div>
                        <div class="cardss">
                            <i class="fa fa-sign-out fa-2x text-red" aria-hidden="true"></i>
                            <div class="card_inner">
                                <p class="text-primary-p">Delcined Orders</p>
                                <span class="font-bold text-title">0</span>
                            </div>
                        </div>
                    <?php }  ?>

                    <div class="cardss">
                        <i class="fa fa-question fa-2x text-yellow" aria-hidden="true"  ></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Pending Orders</p>
                            <span class="font-bold text-title">0</span>
                        </div>
                    </div>

                    <div class="cardss">
                        <i  class="fa fa-thumbs-up fa-2x text-green" aria-hidden="true" ></i>
                        <div class="card_inner">
                            <p class="text-primary-p">Completed Orders</p>
                            <span class="font-bold text-title">0</span>
                        </div>
                    </div>
                </div> 
                
                <div class="div" style="width: 100%; display:flex; justify-content: center;">
                    <?php 
                    if(isset($_GET['add-product']) || isset($_GET['delete-this-item'])  || isset($_GET['edit-this-user']) ):
                        if( isset($_GET['product-status']) ): 
                            $s = $_GET['product-status'];
                            if($s == 'false' || $s == '0'):
                                echo "<div class='alert alert-danger' id='succ-fail-stat'>
                                    $error
                                </div>
                                <script> 
                                    <document.getElementById('succ-fail-stat').scrollIntoView();
                                </script>
                                ";
                            endif;
                        endif;
                    endif;

                    if(isset($_GET['add-product']) || isset($_GET['delete-this-item'])  || isset($_GET['edit-this-user']) ):
                        if( isset($_GET['product-status']) ): 
                            $s = $_GET['product-status'];
                            if($s == 'true'  || $s == '1'):
                                echo "<div class='alert alert-success' id='succ-fail-stat'>
                                    $succ
                                </div>
                                <script> 
                                    document.getElementById('succ-fail-stat').scrollIntoView();
                                </script>
                                ";
                            endif;
                        endif;
                    endif;
                    
                    if(isset($notFound)){
                         echo "<div class='alert alert-danger'>
                                This product was not found!!!
                            </div>";
                    }
                    ?>
                    
                </div>

                <!-- MAIN CARDS ENDS HERE -->
                <?php if(isset($_POST['firstName']) && $stat == 1 ){ ?>
                    <div class='alert alert-success alert-dismissible'>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Details Updated successfully;
                    </div>
                <?php } ?>
                
                <!-- CHARTS STARTS HERE -->
                <div class="charts">

                    <?php if($isAdmin != '1'): if(!$showBill){  ?>
                        <div class="charts__left" style=" overflow-x: scroll; padding: 0;">
                            <div class=" p-30">
                                <div class="row">
                                    <div class="col-md-12 main-datatable">
                                        <div class="card_body">
                                            <div class="row d-flex">
                                                <div class="col-sm-4 createSegment"> 
                                                <!-- <a class="btn dim_button create_new"> <span class="glyphicon glyphicon-plus"></span> Create New</a> -->
                                                </div>
                                                <div class="col-sm-8 add_flex">
                                                    <div class="form-group searchInput">
                                                        <label for="email">Search:</label>
                                                        <input type="search" class="form-control" id="filterbox" placeholder=" ">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="overflow-x">
                                                <table style="width:100%; padding-bottom: 25px;" id="filtertable" class="table cust-datatable dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width:50px;">SN</th>
                                                            <th style="min-width:150px;">Order Id</th>
                                                            <th style="min-width:100px;">No Items</th>
                                                            <th style="min-width:100px;">Amount</th>
                                                            <th style="min-width:100px;">Date</th>
                                                            <th style="min-width:150px;">Status</th>
                                                            <th style="min-width:150px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- <tr>
                                                            <td>1</td>
                                                            <td>Dummy</td>
                                                            <td>17-Apr-2020</td> -->

                                                            <!-- oly for admin -->
                                                                <!-- <td><span class="mode mode_process">Processing</span></td> -->
                                                            <!-- oly for admin -->
                                                            
                                                            <!-- <td>₦5000.00</td> -->

                                                            <!-- oly for admin -->
                                                                <!-- <td>Journey</td> -->
                                                            <!-- oly for admin -->
                                                            
                                                            <!-- <td><span class="mode mode_on">COmpleted</span></td> -->
                                                            
                                                            
                                                            <!-- oly for admin -->
                                                            <!-- <td>
                                                                <div class="btn-group">
                                                                    <a class="dropdown-toggle dropdown_icon" data-toggle="dropdown">
                                                                    <i class="fa fa-pencil-square-o"></i> </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="#" target="_blank">
                                                                                Dummy Details
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" target="_blank">
                                                                                Dummy Details
                                                                            </a>
                                                                        </li>  
                                                                        <li>
                                                                            <a href="#" target="_blank">
                                                                                Dummy Details
                                                                            </a>
                                                                        </li>  
                                                                    </ul>
                                                                </div>
                                                                <span class="actionCust">
                                                                    <a href="#"><i class="fa fa-line-chart"></i></a>
                                                                </span>
                                                                <div class="btn-group">
                                                                    <a class="dropdown-toggle dropdown_icon" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-h"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown_more">
                                                                        <li>
                                                                            <a href="#" target="_black">
                                                                                <i class="fa fa-clone"></i>Duplicate
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" target="_black">
                                                                                <i class="fa fa-trash"></i> Delete
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" target="_black">
                                                                                <i class="fa fa-list"></i>Activity</a>
                                                                            </li>
                                                                    </ul>
                                                                </div>
                                                            </td> -->
                                                            <!-- oly for admin -->

                                                        <!-- </tr>       -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }else{  ?>
                        <div class="charts__left" style=" overflow-x: scroll; padding: 0;">
                            <div class="wrapper">
                                <h4 class="mb-3"> <b>Billing Information</b> </h4> <br>
                                
                                <form class="needs-validation" novalidate action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form" method="post">
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
                                            <input type="email" class="form-control" id="email" placeholder="you@example.com" required name="email" value="<?php echo $session_email; ?>" disabled>
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
                                        <label class="form-check-label" for="save-info">I agree to the terms and conditions</label>
                                    </div>

                                    <hr class="my-4" style="opacity: 0.09">

                                    <button class="w-100 btn btn-primary btn-lg" type="submit" style="border: none; font-size: 0.9em;">Save</button>
                                </form>

                            </div>
                        </div>
                    <?php } endif;  ?>
                    
                    <?php if($isAdmin == '1' && isset($showAllProducts)){  ?>
                        <div class="charts__left" style=" overflow-x: scroll; padding: 0;" id="add-this-prod">
                            <div class=" p-30">
                                <div class="row">
                                    <div class="col-md-12 main-datatable">
                                        <div class="card_body">
                                            <div class="row d-flex">
                                                <div class="col-sm-4 createSegment"> 
                                                    <a class="btn dim_button create_new" href="?add-product=true"> <i class="fa fa-plus"></i> Add New Product</a>
                                                </div>
                                                <div class="col-sm-8 add_flex">
                                                    <div class="form-group searchInput">
                                                        <label for="email">Search:</label>
                                                        <input type="search" class="form-control" id="filterbox" placeholder=" ">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="overflow-x">
                                                <table style="width:100%; padding-bottom: 25px;" id="filtertable" class="table cust-datatable dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width:50px;">SN</th>
                                                            <th style="min-width:150px;">Name</th>
                                                            <th style="min-width:150px;">Price</th>
                                                            <th style="min-width:100px;">Image</th>
                                                            <th style="min-width:100px;">Date</th>
                                                            <th style="min-width:150px;">Category</th>
                                                            <th style="min-width:150px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $n=1; foreach($all_prod as $element){  ?>
                                                            <tr>
                                                                <td> <?php echo $n; ?> </td>

                                                                <td> <?php echo $element['name'] ?> </td>
                                                                
                                                                <td> ₦<?php echo $element['price'] ?> </td>

                                                                <td>
                                                                    <a href="<?php echo $element['img_1']; ?>" target="_blank">
                                                                        <img width="40" height="40" class="img-responsive" src="<?php echo $element['img_1'];?>" />
                                                                    </a>
                                                                </td>
                                                                
                                                                <td>
                                                                    <?php echo $element['date_added'] ?>
                                                                </td>
                                                                
                                                                <td> <?php echo $element['category'] ?> </td>

                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a href="<?php echo $newUrl ?>account/index.php?edit-this-item=<?php echo $element['unique_key']; ?>" class=" dropdown_icon">
                                                                        <i class="fa fa-pencil-square-o"></i> </a>
                                                                    </div>
                                                                    <span class="actionCust">
                                                                        <a href="<?php echo $newUrl ?>store/productDetails.php?prod=<?php echo $element['unique_key'] ?>"><i class="fa fa-line-chart"></i></a>
                                                                    </span>
                                                                    <div class="btn-group">
                                                                        <a class="dropdown-toggle dropdown_icon" data-toggle="dropdown">
                                                                            <i class="fa fa-ellipsis-h"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown_more">
                                                                            <li>
                                                                                <a href="#" target="_black" style="cursor: pointer;">
                                                                                    <i class="fa fa-clone"></i>Duplicate
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a style="cursor: pointer;" onclick="confirmThisAction('<?php echo $element['unique_key'] ?>' );">
                                                                                    <i class="fa fa-trash"></i> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>

                                                            </tr>  
                                                        <?php $n++;} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }elseif($isAdmin == '1' && isset($showAllUsers)){  ?>
                        <div class="charts__left" style=" overflow-x: scroll; padding: 0;">
                            <div class=" p-30">
                                <div class="row">
                                    <div class="col-md-12 main-datatable">
                                        <div class="card_body">
                                            <div class="row d-flex">
                                                <div class="col-sm-4 createSegment"> 
                                                <!-- <a class="btn dim_button create_new"> <span class="glyphicon glyphicon-plus"></span> Create New</a> -->
                                                </div>
                                                <div class="col-sm-8 add_flex">
                                                    <div class="form-group searchInput">
                                                        <label for="email">Search:</label>
                                                        <input type="search" class="form-control" id="filterbox" placeholder=" ">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="overflow-x">
                                                <table style="width:100%; padding-bottom: 25px;" id="filtertable" class="table cust-datatable dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width:50px;">SN</th>
                                                            <th style="min-width:150px;">Email</th>
                                                            <th style="min-width:150px;">Name</th>
                                                            <th style="min-width:100px;">Number</th>
                                                            <th style="min-width:100px;">Date</th>
                                                            <th style="min-width:150px;">Admin</th>
                                                            <th style="min-width:150px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $n=1; foreach($all_users as $element){ $adminStat = $element['is_admin']; $adminId = $element['unique_id']; ?>
                                                            <tr>
                                                                <td> <?php echo $n; ?> </td>

                                                                <td> <?php echo $element['email'] ?> </td>

                                                                <td> <?php echo $element['firstName']." ".$element['lastName'] ?> </td>

                                                                <td>
                                                                    <?php echo $element['number'] ?> 
                                                                </td>
                                                                
                                                                <td>
                                                                    <?php echo $element['joined'] ?> 
                                                                </td>

                                                                <td> <?php echo ($element['is_admin'] ? $element['is_admin'] : "No") ?> </td>
                                                               
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a href="mailto: <?php echo $element['email']; ?>" class="dropdown-toggle dropdown_icon" data-toggle="dropdown">
                                                                        <i class="fa fa-envelope"></i> </a>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a class="dropdown-toggle dropdown_icon" data-toggle="dropdown">
                                                                            <i class="fa fa-ellipsis-h"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown_more">
                                                                            <li>
                                                                                <a style="cursor: pointer;" onclick="confirmAdmin('<?php echo $adminStat; ?>', '<?php echo $adminId; ?>')" >
                                                                                    <i class="fa fa-check"></i>
                                                                                    <?php echo ($element['is_admin'] ? "Remove Admin" : "Make Admin") ?>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a style="cursor: pointer;" onclick="confirmThisAction('<?php echo $element['unique_id'] ?>', 'user');">
                                                                                    <i class="fa fa-trash"></i> Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>  
                                                        <?php $n++;} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }else if($isAdmin == '1' && isset($addProd)){  ?>
                            <form class="show-overlay" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?add-product=true" method="POST" enctype="multipart/form-data">
                                <div class="payment">
                                    <div class="payment-logo">
                                        <p>+</p>
                                    </div>
                                    
                                    <h2>Add Product</h2>
                                    <div class="form">

                                        <div class="card space icon-relative">
                                            <input type="text" class="input" required placeholder="Product Name" value="" name="name">
                                            <i class="far fa-list-alt"></i>
                                        </div>



                                        <div class="card space icon-relative">
                                            <input type="number" class="input"  min="1" placeholder="Price" value="" name="price" required >
                                            <i class="far fa-money-bill-alt"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="number" class="input" placeholder="Old Price" value="" min="1" name="old-price" required >
                                            <i class="far fa-money-bill-alt"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="text" class="input"  placeholder="Short Description" value="" name="short_desc" required >
                                            <i class="far fa-edit"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="text" class="input"  placeholder="Category" value="" name="category" required >
                                            <i class="far fa-folder-open"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="number" class="input"  placeholder="Number In stock" value="" min="1" name="in_stock" required >
                                            <i style="bottom: 14px;" class="fas fa-calculator"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="file" name="img_1" id="img_1" required class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="file" name="img_2" id="img_2" required class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="file" name="img_3" id="img_3" required class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="file" name="img_4" id="img_4" required class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                            <input type="file" name="img_5" id="img_5" required class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>
                                        
                                        <div class="card space icon-relative">
                                            <input type="text" class="input"  placeholder="Measurement" value="" name="measurement" required >
                                            <i style="bottom: 18px;" class="fas fa-balance-scale"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <textarea class="input" name="long_desc" cols="30" rows="6" placeholder="Long Description"></textarea>
                                            <i class="far fa-keyboard"></i>
                                        </div>
                                        
                                    </div>
                                            
                                    <div class="btn">
                                        <input type="submit" value="Add Item" name="addProduct">
                                    </div>
                                </div>
                            </form>
                    <?php }else if($isAdmin == '1' && isset($editProd)){  ?>
                            <form class="show-overlay" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?edit-product=true" method="POST" enctype="multipart/form-data">
                                <div class="payment">
                                    
                                    <h2>
                                        Edit 
                                        <?php echo $detailsEachItem['name']; ?> 
                                        <img src="<?php echo $detailsEachItem['img_1']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="60" height="50"> 
                                    </h2>
                                    <div class="form">

                                        <div class="card space icon-relative">
                                            <label class="label">Product Name</label>
                                            <input type="text" class="input" required placeholder="Product Name" value="<?php echo $detailsEachItem['name']; ?>" name="name">
                                            <i class="far fa-list-alt"></i>
                                        </div>



                                        <div class="card space icon-relative">
                                            <label class="label">Price</label>
                                            <input type="number" class="input"  min="1" placeholder="Price" value="<?php echo (int)$detailsEachItem['price']; ?>" name="price" required >
                                            <i class="far fa-money-bill-alt"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <label class="label">Old Price</label>
                                            <input type="number" class="input" placeholder="Old Price" value="<?php echo (int)$detailsEachItem['old_price']; ?>" min="1" name="old-price" required >
                                            <i class="far fa-money-bill-alt"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Short Description</label>
                                            <input type="text" class="input"  placeholder="Short Description" value="<?php echo $detailsEachItem['short_desc']; ?>" name="short_desc" required >
                                            <i class="far fa-edit"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Category</label>
                                            <input type="text" class="input"  placeholder="Category" value="<?php echo $detailsEachItem['category']; ?>" name="category" required >
                                            <i class="far fa-folder-open"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Number In Stock:</label>
                                            <input type="number" class="input"  placeholder="Number In stock" value="<?php echo (int)$detailsEachItem['in_stock']; ?>" min="1" name="in_stock" required >
                                            <i style="bottom: 14px;" class="fas fa-calculator"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                            <label class="label">Main Image
                                                <img class="imggg" src="<?php echo $detailsEachItem['img_1']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="40" height="30"> 
                                            </label>
                                            <input type="file" name="img_1" id="img_1" class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Other Image
                                                <img class="imggg" src="<?php echo $detailsEachItem['img_2']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="40" height="30"> 
                                            </label>
                                            <input type="file" name="img_2" id="img_2" class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Other Image
                                                <img class="imggg" src="<?php echo $detailsEachItem['img_3']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="40" height="30"> 
                                            </label>
                                            <input type="file" name="img_3" id="img_3" class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Other Image
                                                <img class="imggg" src="<?php echo $detailsEachItem['img_4']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="40" height="30"> 
                                            </label>
                                            <input type="file" name="img_4" id="img_4" class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Other Image
                                                <img class="imggg" src="<?php echo $detailsEachItem['img_5']; ?>" alt="<?php echo $detailsEachItem['name']; ?>" width="40" height="30"> 
                                            </label>
                                            <input type="file" name="img_5" id="img_5" class="input" >
                                            <!-- <i class="far fa-credit-card"></i> -->
                                        </div>
                                        
                                        <div class="card space icon-relative">
                                             <label class="label">Measurement</label>
                                            <input type="text" class="input"  placeholder="Measurement" value="<?php echo $detailsEachItem['measurement']; ?>" name="measurement" required >
                                            <i style="bottom: 32px;" class="fas fa-balance-scale"></i>
                                        </div>

                                        <div class="card space icon-relative">
                                             <label class="label">Long Description</label>
                                            <textarea class="input" name="long_desc" cols="30" rows="6" placeholder="Long Description">
                                                <?php echo $detailsEachItem['long_desc']; ?>
                                            </textarea>
                                            <i class="far fa-keyboard"></i>
                                        </div>
                                        
                                    </div>

                                    <div class="btn">
                                        <input type="hidden" value="<?php echo $detailsEachItem['unique_key']; ?>" name="theId">
                                        <input type="submit" value="Edit This Item" name="editProduct">
                                    </div>

                                    <div class="btn" >
                                        <button class="redirect">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                    <?php }else if($isAdmin == '1' ) {  ?>
                            <div class="charts__left" >
                                <div class="charts__left__title">
                                    <div>
                                    <h1>Daily Reports</h1>
                                    <p>Cupertino, California, USA</p>
                                    </div>
                                    <i class="fa fa-usd" aria-hidden="true"></i>
                                </div>
                                <div id="apex1"></div>
                            </div>

                            <div class="charts__right">
                                <div class="charts__right__title">
                                    <div>
                                    <h1>Stats Reports</h1>
                                    <p>Cupertino, California, USA</p>
                                    </div>
                                    <i class="fa fa-usd" aria-hidden="true"></i>
                                </div>

                                <div class="charts__right__cards">
                                    <div class="card1">
                                    <h1>Income</h1>
                                    <p>$75,300</p>
                                    </div>

                                    <div class="card2">
                                    <h1>Sales</h1>
                                    <p>$124,200</p>
                                    </div>

                                    <div class="card3">
                                    <h1>Users</h1>
                                    <p>3900</p>
                                    </div>

                                    <div class="card4">
                                    <h1>Orders</h1>
                                    <p>1881</p>
                                    </div>
                                </div>
                                </div>
                            </div> 
                    <?php } ?>

                </div>
            </main>

            <div id="sidebar">
                <div class="sidebar__title">
                <div class="sidebar__img">
                    <!-- <img src="assets/logo.png" alt="logo" /> -->
                    <h1>    <a href="../store">Zimarex </a> </h1>
                </div>
                <i
                    onclick="closeSidebar()"
                    class="fa fa-times"
                    id="sidebarIcon"
                    aria-hidden="true"
                ></i>
                </div>

                <div class="sidebar__menu">
                    
                    <!-- <h2>MNG</h2> -->
                    <!-- <div class="sidebar__link">
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        <a href="#">History</a>
                    </div> -->
                    <?php if($isAdmin == '1'){  ?>
                        <div class="sidebar__link active_menu_link">
                            <i class="fa fa-home"></i>
                            <a href="./">Dashboard (All Products) </a>
                        </div>
                        
                        <div class="sidebar__link">
                            <i class="fa fa-shopping-cart"></i>
                            <a href="?all-product=set">All Products</a>
                        </div>

                        <div class="sidebar__link">
                            <i class="fa fa-plus"></i>
                            <a href="?add-product=true">Add New Product</a>
                        </div>

                        <div class="sidebar__link">
                            <i class="fa fa-users"></i>
                            <a href="?all-users=set">All Users</a>
                        </div>

                        <div class="sidebar__link">
                            <i class="fa fa-credit-card-alt"></i>
                            <a href="?billing=set">Orders</a>
                        </div>

                        <div class="sidebar__link">
                            <i class="fa fa-cog"></i>
                            <a href="?billing=set">Settings</a>
                        </div>

                    <?php }else{  ?>
                        <div class="sidebar__link active_menu_link">
                            <i class="fa fa-home"></i>
                            <a href="./">Dashboard </a>
                        </div>

                        <div class="sidebar__link">
                            <i class="fa fa-building-o"></i>
                            <a href="?billing=set">Billing Address</a>
                        </div>
                    <?php } ?>

                    <div class="sidebar__logout">
                        <i class="fa fa-power-off"></i>
                        <a href="?logout">Log out</a>
                    </div>
                </div>
            </div>

        </div>
        
        <script> 
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation');
            const overlayForm = document.querySelectorAll('.show-overlay')
            const overlay = document.querySelector('.overlay')
            
            const allForms = [...overlayForm];
            allForms.forEach(form =>  {
                form.addEventListener('submit', function (event) {
                    // event.preventDefault();
                    overlay.classList.add("see");
                });
            });
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
                })
            })();

            const confirmThisAction = (e, type='item') =>{
                let bool = confirm(`Are you dure you want to delete this ${type}?`);
                if(bool){
                    window.location.href = `<?php echo $newUrl ?>account/index.php?delete-this-${type}=${e}`;
                }
            }

            const confirmAdmin = (stat, id) =>{
                let trivia = stat ? "remove this user from being an Admin?" : "make this user an Admin?";
                let bool = confirm(`Are you dure you want to ${trivia}`);
                if(bool){
                    window.location.href = `<?php echo $newUrl ?>account/index.php?make-admin=true&cuu=${stat}&id=${id}`;
                }
            }

            const thisBtn = document.querySelector(".redirect");
            if(thisBtn){
                thisBtn.addEventListener("click", (e)=>{
                    e.preventDefault();
                    window.location.href='<?php echo $newUrl ?>account/?all-product=set';
                });
            }

            const allImgs = document.querySelectorAll(".imggg");
            let imgArr = Array.from(allImgs).map((e)=>{
                return e;
            });
            // console.log();

            const input = document.querySelectorAll("input[type='file']");
            Array.from(input).forEach((e, i)=>{
                e.addEventListener("change", ()=>{
                   updateImg(e, i);
                })
            });

            const updateImg = (e, i) => {
                let newVal = e.value;
                // imgArr[i].attributes[1].nodeValue = newVal;
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="script.js"></script>

    </body>

</html>
