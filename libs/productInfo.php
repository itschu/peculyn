<?php
    
    if(isset($_GET['prod'])){
        $item_id = $_GET['prod'];
    }else{
        $item_id = "";
    }
    
    foreach($allProducts as $item) :
        // echo $item['unique_key']."<br>";
        if($item_id == $item['unique_key']):
            $productFound = true;
            // echo $item['unique_key'];
?>
            <input type="hidden" value="<?php echo $item['unique_key'] ?>" class="prod-id"/>
            <section class="section product-details__section">
                <div class="product-detail__container">
                <div class="product-detail__left">
                    <div class="details__container--left">
                        <!-- <img src="../assets/images/brand2.png" alt=""> -->
                    <div class="product__pictures">
                        <?php if( $item['img_1'] !== '' ): ?>
                            <div class="pictures__container">
                                <img class="picture" src="<?php echo $item['img_1']; ?>" id="pic1" />
                            </div>
                        <?php endif; ?>

                        <?php if( $item['img_2'] !== '' ): ?>
                            <div class="pictures__container">
                                <img class="picture" src="<?php echo $item['img_2']; ?>" id="pic2" />
                            </div>
                        <?php endif; ?>
                            
                        <?php if( $item['img_3'] !== '' ): ?>
                            <div class="pictures__container">
                                <img class="picture" src="<?php echo $item['img_3']; ?>" id="pic3" />
                            </div>
                        <?php endif; ?>
                        
                        <?php if( $item['img_4'] !== '' ): ?>
                            <div class="pictures__container">
                                <img class="picture" src="<?php echo $item['img_4']; ?>" id="pic4" />
                            </div>
                        <?php endif; ?>
                        
                        <?php if( $item['img_5'] !== '' ): ?>
                            <div class="pictures__container">
                                <img class="picture" src="<?php echo $item['img_5']; ?>" id="pic5" />
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product__picture" id="product__picture">
                        <!-- <div class="rect" id="rect"></div> -->
                        <div class="picture__container">
                        <img src="<?php echo $item['img_1']; ?>" id="pic" />
                        </div>
                    </div>
                    <div class="zoom" id="zoom"></div>
                    </div>

                    <div class="product-details__btn">
                    <a class="add" href="#" >
                        <span> 
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-cart-plus"></use>
                        </svg>
                        </span>
                        ADD TO CART</a>
                    <a class="buy" href="#">
                        <span>
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-credit-card"></use>
                        </svg>
                        </span>
                        BUY NOW
                    </a>
                    </div>
                </div>

                <div class="product-detail__right">
                    <div class="product-detail__content">
                    <h3 id="product-title"><?php echo $item['name']; ?></h3>
                    <div class="prices">
                        <span class="new__price">₦<?php echo $item['price']; ?></span>
                        <input type="hidden" name="price" class="item_price" value="<?php echo $item['price']; ?>" />
                    </div>
                    <div class="product__review">
                        <div class="rating">
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                            <use xlink:href="../assets/images/sprite.svg#icon-star-empty"></use>
                        </svg>
                        </div>
                        <a href="#" class="rating__quatity">(<?php echo $item['reviews']; ?> reviews)</a>
                    </div>
                    <p>
                        <?php echo $item['short_desc']; ?>
                    </p>
                    <div class="product__info-container">
                        <ul class="product__info">
                            <!--
                            <li class="select">
                                <div class="select__option">
                                    <label for="colors">Color</label>
                                    <select name="colors" id="colors" class="select-box">
                                        <option value="blue">blue</option>
                                        <option value="red">red</option>
                                    </select>
                                </div>
                                <div class="select__option">
                                    <label for="size">Inches</label>
                                    <select name="size" id="size" class="select-box">
                                        <option value="6.65">6.65</option>
                                        <option value="7.50">7.50</option>
                                    </select>
                                </div>
                            </li>
                            -->
                        
                            <li>
                                <span>Measurement:</span> &nbsp; 
                                <a style="text-transform: capitalize;"> <?php echo $item['measurement']; ?> </a>
                            </li>
                            <li>

                                <div class="input-counter">
                                <span>Quantity:</span> &nbsp; &nbsp; 
                                <div>
                                    <span class="minus-btn">
                                    <svg>
                                        <use xlink:href="../assets/images/sprite.svg#icon-minus"></use>
                                    </svg>
                                    </span>
                                    <input type="text" readonly="true" min="1" value="1" max="<?php echo $item['in_stock']; ?>" class="counter-btn">
                                    <span class="plus-btn">
                                    <svg>
                                        <use xlink:href="../assets/images/sprite.svg#icon-plus"></use>
                                    </svg>
                                    </span>
                                </div>
                                </div>
                            </li>

                            <li>
                                <span>Subtotal:</span> &nbsp; 
                                <a class="new__price">₦ <span id="sub-total"><?php echo $item['price']; ?></span> </a>
                            </li>
                            <li>
                                <span>Category:</span> &nbsp; 
                                <a  style="text-transform: capitalize;"><?php echo $item['category']; ?></a>
                            </li>
                            <!-- <li>
                                <span>Product Type:</span> &nbsp; 
                                <a >Phone</a>
                            </li> -->
                            <li>
                                <span>Availability:</span> &nbsp;
                                
                                <a  class="in-stock"> <?php if($item['in_stock'] > 0) {echo "In Stock";}else{ echo "Out Of Stock";}?> </a>
                            </li>
                        </ul>
                        <div class="product-info__btn">
                        <a >
                            <span>
                            <svg>
                                <use xlink:href="../assets/images/sprite.svg#icon-crop"></use>
                            </svg>
                            </span>&nbsp;
                            SIZE GUIDE
                        </a>
                        <a href="#">
                            <span>
                            <svg>
                                <use xlink:href="../assets/images/sprite.svg#icon-truck"></use>
                            </svg>
                            </span>&nbsp;
                            SHIPPING
                        </a>
                        <a href="#">
                            <span>
                            <svg>
                                <use xlink:href="../assets/images/sprite.svg#icon-envelope-o"></use>
                            </svg>&nbsp;
                            </span>
                            ASK ABOUT THIS PRODUCT
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="product-detail__bottom">
                <div class="title__container tabs">

                    <div class="section__titles category__titles ">
                    <div class="section__title detail-btn active" data-id="description">
                        <!-- <span class="dot"></span> -->
                        <h1 class="primary__title">Description</h1>
                    </div>
                    </div>

                    <div class="section__titles">
                    <div class="section__title detail-btn" data-id="reviews">
                        <!-- <span class="dot"></span> -->
                        <h1 class="primary__title">Reviews</h1>
                    </div>
                    </div>

                    <div class="section__titles">
                    <div class="section__title detail-btn" data-id="shipping">
                        <!-- <span class="dot"></span> -->
                        <h1 class="primary__title">Shipping Details</h1>
                    </div>
                    </div>
                </div>

                <div class="detail__content">
                    <div class="content active" id="description">
                        <?php  echo $item['long_desc']; ?>
                    </div>
                    <div class="content" id="reviews">
                    <h1>Customer Reviews</h1>
                    <div class="rating">
                        <svg>
                        <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                        <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                        <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                        <use xlink:href="../assets/images/sprite.svg#icon-star-full"></use>
                        </svg>
                        <svg>
                        <use xlink:href="../assets/images/sprite.svg#icon-star-empty"></use>
                        </svg>
                    </div>
                    </div>
                    <div class="content" id="shipping">
                    <h3>Returns Policy</h3>
                    <p>You may return most new, unopened items within 30 days of delivery for a full refund. We'll also pay
                        the return shipping costs if the return is a result of our error (you received an incorrect or defective
                        item, etc.).</p>
                    <p>You should expect to receive your refund within four weeks of giving your package to the return
                        shipper, however, in many cases you will receive a refund more quickly. This time period includes the
                        transit time for us to receive your return from the shipper (5 to 10 business days), the time it takes
                        us to process your return once we receive it (3 to 5 business days), and the time it takes your bank to
                        process our refund request (5 to 10 business days).
                    </p>
                    <p>If you need to return an item, simply login to your account, view the order using the 'Complete
                        Orders' link under the My Account menu and click the Return Item(s) button. We'll notify you via
                        e-mail of your refund once we've received and processed the returned item.
                    </p>
                    <h3>Shipping</h3>
                    <p>We can ship to virtually any address in the world. Note that there are restrictions on some products,
                        and some products cannot be shipped to international destinations.</p>
                    <p>When you place an order, we will estimate shipping and delivery dates for you based on the
                        availability of your items and the shipping options you choose. Depending on the shipping provider you
                        choose, shipping date estimates may appear on the shipping quotes page.
                    </p>
                    <p>Please also note that the shipping rates for many items we sell are weight-based. The weight of any
                        such item can be found on its detail page. To reflect the policies of the shipping companies we use, all
                        weights will be rounded up to the next full pound.
                    </p>
                    </div>
                </div>
                </div>
            </section>

<?php
        endif;
    endforeach;

    if(!$productFound){
        echo "
            <div class='no-product'> 
                <p style='text-align: center;'> 
                    Sorry <br> Product Not Found!!
                </p> 
                <br><br>
                <button class='no-prod-button'>
                    <a href='./products.php'> All Products </a> 
                </button>
            </div>";
    }
?>