<?php

    require_once('../config/functions.php');
    $allProducts = getProducts($con, 0);
    $productFound = false;
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
    <link rel="stylesheet" href="../assets/css/prod.css" />

    <!-- owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">

    <title><?php echo $site_info['site_title']; ?></title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <style>
        .addShadow{
            box-shadow: 0 5px 15px rgb(0 0 0 / 30%);
        }

        .product {
            padding: 0 10px;
            overflow: hidden;
        }

        .owl-next span, .owl-prev span{
            font-size: 1.55em;
            margin: 0 5px;
            font-weight: 700;
        }


        .no-product{
            height: 60vh;
            margin-top: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .no-product p{
            font-size: 1.2em;
            font-weight: 700;
        }

        .no-prod-button{
            padding: 10px 20px;
            border: 1px solid #BA0303;
            background: transparent;
            border-radius: 20px;
            font-weight: 500;
            outline: none;
        }

        #shipping p, #description p {
            padding-right: 1.9rem;
            text-align: justify;
            line-height: 2.8rem;
        }

        #shipping h3 {
            text-align: center;
            /* padding: 0 1.7rem; */
        }

        .detail__content {
            padding: 0 1.8rem;
        }

        .section__title h1 {
            font-size: 1.57rem;
            font-weight: 600;
        }

        .title__container {
            padding: 2rem 1rem;
        }

        #reviews {
            font-size: 1.65rem;
        }

        /* @media only screen and (max-width: 768px){ */
            .product__pictures, .product-details__btn {
                margin-left: 2rem;
            }
        /* } */
    </style>

</head>

<body>
     <!-- Navigation -->
    <?php require_once('../libs/nav.php') ?>
    <!-- Product Details -->

    <!-- Products Details -->

    <?php require_once('../libs/productInfo.php') ?>
    <!-- Related Products -->
    <div class="alertMessage" style="display: flex; justify-content: center;">
        
    </div>

    <?php require_once('../libs/related-products.php') ?>

    <!-- Footer --> 
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
            // alert('loaded');

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

        // Get all elements with class="closebtn"
        var close = document.getElementsByClassName("closebtn");
        var i;

        // Loop through all close buttons
        for (i = 0; i < close.length; i++) {
        // When someone clicks on a close button
            close[i].onclick = function(){

                // Get the parent of <span class="closebtn"> (<div class="alert">)
                var div = this.parentElement;

                // Set the opacity of div to 0 (transparent)
                div.style.opacity = "0";

                // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
                setTimeout(function(){ div.style.display = "none"; }, 600);
            }
        }

        const getTitle = document.querySelector('#product-title').innerText;
        document.title = `${getTitle} - <?php echo $site_info['site_title']; ?>`;
    </script>
</body>

</html>