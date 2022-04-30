<!-- Footer -->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/60b8d696de99a4282a1b33d2/1f790cfks';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    <footer id="footer" class="section footer">
        <div class="container">
        <div class="footer-container">
            <div class="footer-center">
                <h3>EXTRAS</h3>
                <a href="#">Vendors</a>
                <a href="#">Gift Certificates</a>
                <a href="#">Affiliate</a>
                <!-- <a href="#">Specials</a> -->
                <a href="<?php echo $newUrl ?>sitemap.xml">Site Map</a>
            </div>
            <div class="footer-center">
                <h3>INFORMATION</h3>
                <a href="#">About Us</a>
                <a href="<?php echo $newUrl ?>privacy.php">Privacy Policy</a>
                <a href="<?php echo $newUrl ?>terms.php">Terms & Conditions</a>
                <a href="mailto: help@zimarex.com">Contact us via Mail</a>
                <a href="tel:+2348133381982">Contact us Telephone</a>
            </div>
            <div class="footer-center">
            <h3>MY ACCOUNT</h3>
            <?php if(!isset($session_id)){  ?>
                <a href="<?php echo $newUrl ?>store/login.php">Login</a>
                <a href="<?php echo $newUrl ?>store/sign-up.php">Sign Up</a>
                <?php }else{  ?>
                <a href="<?php echo $newUrl ?>/account">My Account</a>
                <a href="<?php echo $newUrl ?>/account">Order History</a>
                <a href="#">Wish List</a>
                <a href="#">Newsletter</a>
                <!-- <a href="#">Returns</a> -->
            <?php }  ?>
            </div>
            <div class="footer-center">
            <h3>CONTACT US</h3>
            <div>
                <span>
                    <i class="fas fa-map-marker-alt"></i>
                </span>
                <?php echo $site_info['site_address']; ?>
            </div>
            <div>
                <a href="mailto:<?php echo $site_info['site_email']; ?>"> 
                    <span>
                    <i class="far fa-envelope"></i>
                    </span>
                    <?php echo $site_info['site_email']; ?>
                </a>
            </div>
            <div>
                <a href="tel:<?php echo $site_info['site_number']; ?>">
                    <span>
                    <i class="fas fa-phone"></i>
                    </span>
                    <?php echo $site_info['site_number']; ?>
                </a>
            </div>
            <div class="payment-methods">
                <img src="<?php echo $newUrl ?>assets/images/payment.png" alt="">
            </div>
            </div>
        </div>
        </div>
        </div>
    </footer>
    <!-- End Footer -->

    <?php 
        if( isset($session_id) ){
            $data = searchCart($con, $session_id);
            $gblobalArray = [];
            foreach($data as $item){
                $thisId = $item['prod_id'];
                $thisAmount = $item['quantity'];
                $thisProdDetails = prodDetails($con, $thisId);
                // print_r($thisProdDetails);
                if(!empty($thisProdDetails)){
                    foreach($thisProdDetails as $newData){

                        $itemName = $newData['name'];
                        $itemPrice = $newData['price'];
                        $itemUrl = $newData['img_1'];
                        
                        $newArr = array(
                            'name' => $itemName,
                            'price' => $itemPrice,
                            'quantity' => (int)$thisAmount,
                            'url' => $itemUrl,
                            'id' => $thisId
                        );
                        $gblobalArray[] = $newArr;
                    }
                }

            }
            // print_r($gblobalArray);
            $jsonData = (json_encode($gblobalArray));
    ?>
            <script>
                let updatingArr = [];
                if(localStorage.getItem('allItems')){
                    updatingArr = JSON.parse(localStorage.getItem('allItems'));
                }
                
                let origArr = <?php echo $jsonData; ?>;
                         
                // console.log(origArr);            
                // console.log(updatingArr);   
                for(let i = 0, l = origArr.length; i < l; i++) {
                    for(let j = 0, ll = updatingArr.length; j < ll; j++) {
                        if(origArr[i].id === updatingArr[j].id) {
                            // console.log()
                            if(origArr[j] !== undefined){
                                updatingArr.splice(i, 1, origArr[j]);
                                // origArr.splice(i, 1, origArr[j]);
                            }
                            break;
                        }
                    }
                }
                let obj = {};

                // Array.prototype.push.apply(updatingArr,origArr);
                // console.log(origArr);
                updatingArr = [...updatingArr, ...origArr];
                 
                for ( let i=0; i < updatingArr.length; i++ ){
                    // console.log(obj)
                    obj[updatingArr[i]['id']] = updatingArr[i];
                }

                updatingArr = new Array();
                for ( let key in obj )
                      updatingArr.push(obj[key]);

                localStorage.setItem('allItems', JSON.stringify(updatingArr));
                localStorage.setItem('cartNum', updatingArr.length);
            </script>
    <?php }else{ ?>
            <script>
                // console.log("not logged in");
                localStorage.setItem("userId", "0");
                // console.log(localStorage.getItem('userId'));
            </script>
    <?php } ?>


