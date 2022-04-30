<?php

    require_once('../config/functions.php');
    $allProducts = getProducts($con);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon" /> -->
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title>Cart - <?php echo $site_info['site_title']; ?></title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <!-- owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">

    <style>
        .addShadow{ 
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        .product {
            padding: 0 10px;
            overflow: hidden;
        }
        
        .showLoader{
            height : 70vh; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center;
        }

        .owl-next span, .owl-prev span{
            font-size: 1.55em;
            margin: 0 5px;
            font-weight: 700;
        }
        .lds-spinner{ 
          color: official;
          display: inline-block;
          position: relative;
          width: 80px;
          height: 80px;
        }
        .lds-spinner div {
          transform-origin: 40px 40px;
          animation: lds-spinner 1.2s linear infinite;
        }
        .lds-spinner div:after {
          content: " ";
          display: block;
          position: absolute;
          top: 3px;
          left: 37px;
          width: 6px;
          height: 18px;
          border-radius: 20%;
          background: #ba0303;
        }
        .lds-spinner div:nth-child(1) {
          transform: rotate(0deg);
          animation-delay: -1.1s;
        }
        .lds-spinner div:nth-child(2) {
          transform: rotate(30deg);
          animation-delay: -1s;
        }
        .lds-spinner div:nth-child(3) {
          transform: rotate(60deg);
          animation-delay: -0.9s;
        }
        .lds-spinner div:nth-child(4) {
          transform: rotate(90deg);
          animation-delay: -0.8s;
        }
        .lds-spinner div:nth-child(5) {
          transform: rotate(120deg);
          animation-delay: -0.7s;
        }
        .lds-spinner div:nth-child(6) {
          transform: rotate(150deg);
          animation-delay: -0.6s;
        }
        .lds-spinner div:nth-child(7) {
          transform: rotate(180deg);
          animation-delay: -0.5s;
        }
        .lds-spinner div:nth-child(8) {
          transform: rotate(210deg);
          animation-delay: -0.4s;
        }
        .lds-spinner div:nth-child(9) {
          transform: rotate(240deg);
          animation-delay: -0.3s;
        }
        .lds-spinner div:nth-child(10) {
          transform: rotate(270deg);
          animation-delay: -0.2s;
        }
        .lds-spinner div:nth-child(11) {
          transform: rotate(300deg);
          animation-delay: -0.1s;
        }
        .lds-spinner div:nth-child(12) {
          transform: rotate(330deg);
          animation-delay: 0s;
        }
        @keyframes lds-spinner {
          0% {
            opacity: 1;
          }
          100% {
            opacity: 0;
          }
        }
        
    </style>
     
  </head>

  <body>

        <!-- Navigation -->
        <?php require_once('../libs/nav.php') ?>

        <!-- Cart Items -->
        <div class="container cart showLoader">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

            <p>Loading</p>
        </div>

        <div class="alertMessage" style="display: flex; justify-content: center;">
        
        </div>

        <div class="dummyDiv noShow"></div>
        <!-- Footer -->

         <!-- other products -->
        <?php require_once('../libs/related-products.php') ?>

        <?php require_once('../libs/footer.php') ?>
        <!-- End Footer -->

        <!-- Custom Scripts -->
        <script src="../assets/js/products.js"></script>
        <script src="../assets/js/slider.js"></script>
        <script src="../assets/js/index.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script> 
            $('document').ready(function(){

                $('.section .owl-carousel').owlCarousel({
                    dots : true,
                    nav : true,
                    items : 1,
                    loop : true,
                    nav : true,
                    responsive : { 
                        0: {
                            items : 1.3
                        },
                        600: {
                            items : 3.2
                        },
                        1000: {
                            items : 5.2
                        }
                    }
                });
            });

            showCartItemOnUI(); 
        </script>
  </body>
</html>

