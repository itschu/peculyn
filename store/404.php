<?php

require_once('../config/functions.php');

?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="/my-site/zimarex/assets/images/favicon.ico" type="image/x-icon" /> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="/assets/css/styles.css" />
    <title>404 - <?php echo $site_info['site_title']; ?></title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <style>
        .addShadow{
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        button{
            padding : 12px 20px;
            border : 1px solid #ba0303;
            font-size: 0.76em;
            color: #4a4a4a;
            background: transparent;
            cursor : pointer;
            border-radius: 20px;
        }

        .showLoader a{
            margin-top: -100px;
        }
        .img404 {
            height: 30rem;
            /* background: red; */
            width: 30rem;
        }
    </style>
</head>

<body>
     <!-- Navigation -->
    <?php 
        require_once('../libs/nav.php') 
    ?>

    <div class="showLoader" style="height : 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 50px">
        <div class="img404">
            <img src="/assets/images/404.png" style="width: 100%;"/>
        </div>
        <a href="/">
            <button>Go Home</button>
        </a>
    </div>
    <div class="dummyDiv"></div>
    <!-- Footer -->
    <?php require_once('../libs/footer.php') ?>
    <!-- End Footer -->
    <!-- Custom Scripts -->
    <script src="/assets/js/products.js"></script>
    <script src="/assets/js/slider.js"></script>
    <script src="/assets/js/index.js"></script>

</body>

</html>