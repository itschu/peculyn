<?php

require_once('../config/functions.php');
if($ThisMyPath == true){
	header('location: index.php');
}

$append="";
if(isset($_GET['return'])){
    $val = $_GET['return'];
    $append="?return=$val";
}

$senTo = htmlspecialchars($_SERVER["PHP_SELF"]).$append;

if(isset($_POST['log'])){
	$email = test_input($_POST['email']);
	$password = test_input($_POST['password']);

    if(!empty($email) && !empty($password) ){
        $password = hash('sha512', $password);
		$auth_user = loginUsers($password, $email, $con);
        if($auth_user != 0){
            $id = $auth_user['unique_id'];
            $emailThis = $auth_user['email'];
			$_SESSION['curr_user'] = $id;
			$_SESSION['curr_email'] = $emailThis;
            // echo $id;
            $succ = "You have logged in successfully, you will be redirected shortly";
        }else{
            $error = "<strong>Sorry!!</strong> email or password is incorrect";
            //email exist or passwords dont match
        }
    }else{
        $error = "<strong>Sorry!!</strong> All fields are required to login";
        //all fields cannot be empty
    }
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
    <link rel="stylesheet" href="../assets/css/login.css" />
    <title>Login - <?php echo $site_info['site_title']; ?></title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        .addShadow{
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        .alert{
            position: relative;
            margin-top: 40px;
            margin-bottom : 20px;
            z-index: 1;
        }

        .alert-danger{
            background-color: #d81010;
        }

        .alert-success{
            background-color: #04AA6D;
        }
    </style>
</head>

<body>
     <!-- Navigation -->
    <?php 
        require_once('../libs/nav.php') 
    ?>

    <div class="div" style="width: 100%; display:flex; justify-content: center;">
        <?php 
        if(isset($_POST['log']) && isset($error)) :
            echo "<div class='alert alert-danger'>
                $error
            </div>";
        endif;

        if(isset($_POST['log']) && isset($succ)) :
            echo "<div class='alert alert-success'>
                $succ
            </div>";
        endif;
        ?>
        
    </div>

    <section>
        <div class="imgBx">
            <img src="../assets/images/login-img.jpg" alt="">
        </div>
        <div class="contentBx">
            <div class="formBx">
                <h2>Login</h2>
                <form action="<?php echo $senTo ?>" id="form" method="post">

                    <div class="inputBx form-control">
                        <span>Email</span>
                        <input name="email" type="email" placeholder="email@email.com" id="email">
                        <!-- <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"> </i> -->
                        <small> </small>
                    </div>
                    <div class="inputBx form-control">
                        <span>Password</span>
                        <input name="password" type="password"  id="password" placeholder="************">
                        <!-- <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle">   </i> -->
                        <small> </small>
                    </div>
                    <!-- <div class="remember form-control">
                        <label for="remember">
                            <input type="checkbox" name="">
                            Remember Me
                        </label>
                    </div> -->
                    <input type="hidden" name="log" value="set">

                    <div class="inputBx form-control">
                        <input type="submit" value="Login" name="login">
                    </div>
                    <div class="inputBx">
                        <p>Don't have an account? <a href="./sign-up.php"> <b>Sign up</b> </a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="dummyDiv noShow"></div>
    <!-- Footer -->
    <?php require_once('../libs/footer.php') ?>
    <!-- End Footer -->
    <!-- Custom Scripts -->
    <script src="../assets/js/login.js"></script>
    <script src="../assets/js/index.js"></script>
    <script src="../assets/js/slider.js"></script>
    <script src="../assets/js/products.js"></script>
    
    <?php
        if(isset($_POST['log']) && isset($succ)) :
            if(isset($_GET['return'])){
                $path = $_GET['return'];
                if($path == 'checkout'){
                    $link = $newUrl."store/checkout.php";
                    printRedirect($id, $link);
                }else{
                    printRedirect($id, "../account/");
                }
            }else{
                printRedirect($id, "../account/");
            }
        endif;

        if(isset($_GET['logout-now'])){
            $p = $_GET['logout-now'];
            echo "
                <script src='../assets/js/setStorageSession.js'> </script>
            ";
        }
    ?>
</body>

</html>