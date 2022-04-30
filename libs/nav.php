<!-- Navigation -->
    <nav class="nav addShadow">
        <div class="wrapper container">
            <div class="logo" style="align-self: flex-start;"><a href="<?php echo $newUrl ?>"><?php echo $site_info['site_name']; ?></a></div>
            <ul class="nav-list">
                <div class="top">
                    <label for="" class="btn close-btn"><i class="fas fa-times"></i></label>
                </div>
                <li><a href="<?php echo $newUrl ?>index.php">Home</a></li>
                <li><a href="<?php echo $newUrl ?>store/products.php">Products</a></li>
                <li>
                    <a href="#" class="desktop-item">Shop <span><i class="fas fa-chevron-down"></i></span></a>
                    <input type="checkbox" id="showMega" />
                    <label for="showMega" class="mobile-item">Shop <span><i class="fas fa-chevron-down"></i></span></label>
                    <div class="mega-box">
                    <div class="content">
                        <div class="row">
                        <img src="<?php echo $newUrl ?>assets/images/woman.jpg" alt="" id="list-display-pic"/>
                        </div>
                        <div class="row">
                        <header>Frozen Foods</header>
                        <ul class="mega-links">
                            <li id="fBeef"><a href="<?php echo $newUrl ?>store/products.php?search=Frozen Beef&cat=protein">Frozen Beef</a></li>
                            <li id="fChicken"><a href="<?php echo $newUrl ?>store/products.php?search=Frozen Chicken&cat=protein">Frozen Chicken</a></li>
                            <li id="fFish"><a href="<?php echo $newUrl ?>store/products.php?search=Frozen Fish&cat=protein">Frozen Fish</a></li>
                            <li id="mFFoods"><a href="<?php echo $newUrl ?>store/products.php?search=&cat=protein">More Frozen Foods</a></li>
                        </ul>
                        </div>
                        <div class="row">
                        <header>Vegetables</header>
                        <ul class="mega-links">
                            <li id="vegTomato"><a href="<?php echo $newUrl ?>store/products.php?search=Tomatoes&cat=vegetables">Tomatoes</a></li>
                            <li id="vegPepper"><a href="<?php echo $newUrl ?>store/products.php?search=Pepper&cat=vegetables">Peppers</a></li>
                            <li id="vegLeaves"><a href="<?php echo $newUrl ?>store/products.php?search=Leaf&cat=vegetables">Cooking Leaves</a></li>
                            <li id="vegOther"><a href="<?php echo $newUrl ?>store/products.php?search=&cat=vegetables">Others</a></li>
                        </ul>
                        </div>
                        <div class="row">
                        <header>Food Grains</header>
                        <ul class="mega-links">
                            <li id="grainRice"><a href="<?php echo $newUrl ?>store/products.php?search=Rice&cat=protein">Rice</a></li>
                            <li id="grainGarri"><a href="<?php echo $newUrl ?>store/products.php?search=Garri&cat=protein">Garri</a></li>
                            <li id="grainBbean"><a href="<?php echo $newUrl ?>store/products.php?search=Beans&cat=protein">Beans</a></li>
                        </ul>
                        </div>
                    </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="desktop-item">Vendors <span><i class="fas fa-chevron-down"></i></span></a>
                    <input type="checkbox" id="showdrop1" />
                    <label for="showdrop1" class="mobile-item">Vendors <span><i class="fas fa-chevron-down"></i></span></label>
                    <ul class="drop-menu1">
                    <li><a href="">Vendor Store listings</a></li>
                    <li><a href="">Store Details</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="desktop-item"> <?php echo $session_email ?> <span><i class="fas fa-chevron-down"></i></span></a>
                    <input type="checkbox" id="showdrop2" />
                    <label for="showdrop2" class="mobile-item"> <?php echo $session_email ?> <span><i class="fas fa-chevron-down"></i></span></label>
                    <ul class="drop-menu2">
                    <?php if(!isset($session_id)){  ?>
                        <li><a href="<?php echo $newUrl ?>store/login.php">Login</a></li>
                        <li><a href="<?php echo $newUrl ?>store/sign-up.php">Sign Up</a></li>
                    <?php }else{  ?>
                        <li><a href="<?php echo $newUrl ?>account">Dashboard</a></li>
                        <li><a href="?logout=true">Logout</a></li>
                    <?php }; ?>
                    </ul>
                </li>
                
                <!-- icons -->
                <li class="icons">
                    
                    <a href="<?php echo $newUrl ?>store/cart.php">
                        <span>
                            <img src="<?php echo $newUrl ?>assets/images/bag.png" alt="cart-icon" />
                            <small class="count d-flex cart-items">0</small>
                        </span>
                    </a>
                    <!-- <span><img src="<?php echo $newUrl ?>store/assets/images/search.svg" alt="" /></span> -->
                </li>
            </ul>
            <label for="" class="btn open-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>