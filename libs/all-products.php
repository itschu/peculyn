<?php 
    $prodCat = array_map(function($curr){
        return $curr['category'];
    }, $allProducts);
    
    $uniqueCat = array_unique($prodCat);
    sort($uniqueCat);

    if(isset($_GET['cat'])){
        $arr = $searchProducts;
    }else{
        $arr = $allProducts;
    }

    $nn = array_map(function($curr){
        return $curr['name'];
    }, $arr);
    $uniqueName = array_unique($nn);
    sort($uniqueName);
?>

<section class="section products products-margin">
    <div class="products-layout container">

        <?php require_once('form-search-for-all-prod.php'); ?>

            <div class="product-layout">
                <?php $n=0; foreach($allProducts as $item) {  ?>

                    <div id="id-<?php echo $n; ?>" class="product" data-prodName="<?php echo $item['name'] ?>" data-prodCat="<?php echo $item['category'] ?>">
                        <a href="./productDetails.php?prod=<?php echo $item['unique_key'] ?>">
                            <div class="img-container">
                                <div class="tag _dsct">-8%</div>
                                    <img src="<?php echo $item['img_1'] ?>" alt="" />
                                <div class="addCart addNow">
                                    <i class="fas fa-shopping-cart addNow"></i>
                                </div>
                
                                <ul class="side-icons">
                                    <span><i class="far fa-heart"></i></span>
                                    <span><i class="fas fa-sliders-h"></i></span>
                                </ul>
                            </div>

                            <div class="bottom">
                                <a><?php echo $item['name'] ?></a>
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
                <?php $n++; }; ?>
            </div>
            
            <!-- PAGINATION -->
            <div class="bott" style="display: flex; align-items: center; justify-content: center; flex-direction: column; margin-bottom: 20px;">
                <ul class="pagination">
                    <span class="icon">››</span>
                    <span class="last">Prev</span>
                    <span>2</span>
                    <span class="last">Next <!-- » --></span>
                    <span class="icon">»›</span>
                </ul>
                <span style="justify-self: flex-end"> <b><?php echo count($allProducts) ?> Results</b> </span>
            </div>
        </div>
    </div>
</section>