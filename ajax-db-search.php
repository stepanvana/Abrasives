<?php
    require 'vendor/autoload.php';
    $productViewObj = new products\ProductsView();

    if (isset($_POST['query'])) {
        $products = $productViewObj->searchProducts($_POST['query']);
        $categories = $productViewObj->searchCategories($_POST['query']);
        ?>
        <div class="card p-5" style="position: relative;z-index: 1;">
            <div class="container mt-3">
                <div class="row">
                    <div class="col">
                        <h6 class="text-uppercase font-weight-bold"><strong>Produkty</strong></h6>
                        <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <?php
                        if ($products !== false && !empty($products)) {
                            foreach ($products as $val) {
                                ?>
                                <p>
                                    <a class="waves-effect dark-grey-text" href="produkt/<?php echo $val['product_id']; ?>/<?php echo $val['product_url']; ?>">
                                        <?php echo $val['product_name']; ?>
                                    </a>
                                </p>
                                <?php
                            }
                            ?>
                            <div class="text-center mb-4 mb-sm-4 mb-md-0">
                                <a class="btn btn-primary" href="vyhledavani/<?php echo $_POST['query']; ?>">
                                    Zobrazit produkty (<?php echo count($products); ?>) 
                                </a>
                            </div>
                            <?php
                        } else {
                            echo "<p class='waves-effect dark-grey-text'>Produkty nenalezeny...</p>";
                        }
                        ?>
                    </div>
                    <div class="col">
                        <h6 class="text-uppercase font-weight-bold"><strong>Kategorie</strong></h6>
                        <hr class="blue mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                        <?php
                        if ($categories !== false && !empty($categories)) {
                            foreach ($categories as $cat) {
                                ?>
                                <p>
                                    <a class="waves-effect dark-grey-text" href="produkty/<?php echo $cat['category_url']; ?>">
                                        <?php echo $cat['category_name']; ?>
                                    </a>
                                </p>
                                <?php
                            }
                        } else {
                            echo "<p class='waves-effect dark-grey-text'>Kategorie nenalezena...</p>";
                        }
                        ?>
                    </div>    
                </div>
            </div>
        </div>
        <?php
    }
?>