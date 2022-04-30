<?php

require_once('../config/functions.php');
if($ThisMyPath == true){
	header('location: checkout.php');
}


if(isset($_POST['reg'])){
	$email = test_input($_POST['email'], $con);
	$password = test_input($_POST['password']);
	$password2 = test_input($_POST['password2']);

    if(!empty($email) && !empty($password) && !empty($password2)){
        $check = checkAuthencity($email, $con);
        if($check == true && ($password == $password2)){
            $password = hash('sha512', $password);
            $md5 = md5($email);
	        $user_id = substr($md5,0,9);
            $params = array(
                'unique_id'=>"$user_id",
                'email'=>"$email",
                'password'=>"$password"
            );
            insertData($con, $params, null, null, null, 'users');
            $succ = "<strong>Success!!</strong> This account has been created. <a href='./login.php'>  <b>Login here</b> </a>";
        }else{
            $error = "<strong>Sorry!!</strong> This email already exists, please <a href='./login.php'> <b>login here</b></a>";
            //email exist or passwords dont match
        }
    }else{
        $error = "<strong>Sorry!!</strong> All fields are required to register";
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
    <title>Sign Up - <?php echo $site_info['site_title']; ?></title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        .addShadow{
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        section{
            height: 600px;
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
        if(isset($_POST['reg']) && isset($error)) :
            echo "<div class='alert alert-danger'>
                $error
            </div>";
        endif;

        if(isset($_POST['reg']) && isset($succ)) :
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
                <h2>Sign Up</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form" method="post" name="signUp-register">

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

                     <div class="inputBx form-control">
                        <span>Re Type Password</span>
                        <input name="password2" type="password"  id="password2" placeholder="************">
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
                    <input type="hidden" name="reg" value="set">
                    <div class="inputBx form-control">
                        <input type="submit" value="Register" name="register">
                    </div>
                    <div class="inputBx">
                        <p>Already have an account? <a href="./login.php"> <b>Login</b> </a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php require_once('../libs/footer.php') ?>
    <!-- End Footer -->
    <!-- Custom Scripts -->
    <script src="../assets/js/login.js"></script>
    <script src="../assets/js/products.js"></script>
    <script src="../assets/js/slider.js"></script>
    <script src="../assets/js/index.js"></script>
</body>

</html>