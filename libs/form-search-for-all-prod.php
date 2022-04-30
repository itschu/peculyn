 <div class="col-1-of-4">
            <div>
                <div class="block-title">
                    <h3>Categories</h3>
                </div>
                <ul class="block-content">
                    <?php  array_map(function($cur_cat){
                        printf('
                            <li>
                                <!-- <input type="checkbox" name="" id=""> -->
                                <a href="?search=&cat=%s">
                                    <label for="%s" style="cursor: pointer; !important">
                                        <span class="cat-label">%s</span>
                                        <!-- <small>(10)</small>  -->
                                    </label>
                                </a>
                            </li>
                        ', $cur_cat,  $cur_cat, $cur_cat);
                    }, $uniqueCat); ?>
                </ul>
            </div>

            <div>
                <div class="block-title">
                    <h3>Products</h3>
                </div>

                <ul class="block-content">
                    <?php  
                        array_filter($uniqueName, "prinCategoryItem");
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-3-of-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                <!-- <div class="item">
                    <label for="sort-by">Sort By</label>
                    <select name="search" id="sort-by">
                        <option value="" selected="selected" disabled>Name</option>
                        <?php foreach($uniqueName as $nam) : ?>
                            <option value="<?php echo $nam; ?>"> <?php echo $nam; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <input type="hidden" value="" name="search">
                <div class="item">
                    <label for="order-by">Sort By</label>
                    <select name="cat" id="sort-order" required>
                        <option value="" selected="selected" disabled>Category</option>
                        <?php foreach($uniqueCat as $catt) : ?>
                            <option value="<?php echo $catt; ?>"> <?php echo $catt; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="Search" class="submitt">
                
            </form>