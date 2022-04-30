<section class="section products" id="products">
    <div class="title">
        <h2>Top Selling Products</h2>
        <!-- <span>Select from the premium product brands and save plenty money</span> -->
    </div>
    <div class="product-layout owl-carousel owl-theme">
        <?php foreach($allProducts as $item) { ?>
            <div class="product" >
                <a href="./productDetails.php?prod=<?php echo $item['unique_key'] ?>">
                    <div class="img-container">
                        <div class="tag _dsct">-8%</div>
                        <img src="<?php echo $item['img_1']; ?>" alt="" />
                        <div class="addCart addNow">
                            <i class="fas fa-shopping-cart addNow"></i>
                        </div>

                        <ul class="side-icons">
                            <span><i class="far fa-heart"></i></span>
                            <span><i class="fas fa-sliders-h"></i></span>
                        </ul>
                    </div>
                    <div class="bottom">
                        <a href=""><?php echo $item['name'] ?></a>
                        <div class="price">
                            <span>₦<?php echo $item['price'] ?></span>
                            <input type="hidden" value="<?php echo $item['old_price'] ?>" name="old price">
                            <input type="hidden" value="<?php echo $item['price'] ?>" name="new price">
                            <?php if($item['old_price'] > 0){ echo "<span class='cancel'> ₦".$item['old_price']."</span>"; } ?> 
                            
                        </div>
                    </div>
                    <input type='hidden' value="<?php echo $item['unique_key'] ?>" />
                </a>
            </div>
        <?php } ?>
    </div>
</section>