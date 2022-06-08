<?php

if (isset($_GET['searchBtn'])) {
    header('Location: /vyhledavani/' . $_GET['search'] . '');
}

include 'header.php';
include 'nav.php';

$categoriesArray = $productViewObj->showCategories();
$subCategoriesArray = $productViewObj->showSubCategories();
$paramsArray = $productViewObj->showParams();
$paramsValuesArray = $productViewObj->showParamsValues();

if (isset($_GET['category']) && !isset($_GET['subcategory'])) {
    $category = "/" . $_GET['category'];
    $subcategory = "";
    if (isset($_GET['sort'])) {
        $productsArray = $productViewObj->showProducts($_GET['category'], NULL, $_GET['sort']);
    } else {
        $productsArray = $productViewObj->showProducts($_GET['category'], NULL);
    }
    $bestSellingProductsArray = $productViewObj->showBestSellingProducts($_GET['category'], NULL, NULL);  
} elseif (isset($_GET['subcategory'])) {
    $category = "/" . $_GET['category'];
    $subcategory = "/" . $_GET['subcategory'];
    if (isset($_GET['sort'])) {
        $productsArray = $productViewObj->showProducts($_GET['category'], $_GET['subcategory'], $_GET['sort']);
    } else {
        $productsArray = $productViewObj->showProducts($_GET['category'], $_GET['subcategory']);
    }
    $bestSellingProductsArray = $productViewObj->showBestSellingProducts($_GET['category'], $_GET['subcategory'], NULL);
} else {
    $category = "";
    $subcategory = "";
    if (isset($_GET['sort'])) {
        $productsArray = $productViewObj->showProducts(NULL, NULL, $_GET['sort']);
    } else {
        $productsArray = $productViewObj->showProducts(NULL, NULL);
    }
    $bestSellingProductsArray = $productViewObj->showBestSellingProducts(NULL, NULL, NULL);
}

$recordsPerPage = 3;
$allCount = count($productsArray);

?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".productDetail").slice(0, 3).show();
        $("#loadMore").on('click', function (e) {
            e.preventDefault();
            $(".productDetail:hidden").slice(0, 3).slideDown();
            if ($(".productDetail:hidden").length == 0) {
                $("#load").fadeOut('slow');
            }
        });
    });
</script>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark primary-color" style="margin-top: 150px;" id="categories">
        <a class="navbar-brand font-weight-bold" href="#">Kategorie</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="basicExampleNav">
            <ul class="navbar-nav mr-auto">
                <?php
                foreach ($categoriesArray as $rowCat) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $rowCat['category_name']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="produkty/<?php echo $rowCat['category_url']; ?>">Vše</a>  
                            <?php
                            foreach ($subCategoriesArray as $subRow) {
                                if ($subRow['sub_categories_category'] !== $rowCat['category_id']) {
                                    continue;
                                } else {
                                    ?>
                                    <a class="dropdown-item" href="produkty/<?php echo $rowCat['category_url']; ?>/<?php echo $subRow['sub_categories_url']; ?>"><?php echo $subRow['sub_categories_name']; ?></a>   
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <?php
                    if ($page == 'index.php') {
                        ?>
                        <a href="#subscribe" class="sliding-link nav-link border border-light rounded waves-effect mr-2">
                            <i class="far fa-newspaper"></i>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="http://localhost/mujProjekt#subscribe" class="nav-link border border-light rounded waves-effect mr-2">
                            <i class="far fa-newspaper"></i>
                        </a>
                        <?php
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <a href="#contact_message" class="sliding-link nav-link border border-light rounded waves-effect mr-2">
                        <i class="fas fa-envelope"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div id="output"></div>

<main class="text-center">
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12 wow fadeInUp" style="margin-top: 50px;padding: 0;">
            <form id="form" class="form-inline my-1" name="filter" method="GET" action="">
                <div class="container">
                    <section class="sticky">
                        <p class="text-left font-weight-bold">Filtr</p>
                        <div class="row d-flex text-left">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="mb-5">
                                    <h5 class="font-weight-bold mb-3">Seřadit podle</h5>
                                    <div class="divider-small mb-3"></div>
                                    <ul class="list-unstyled link-black">
                                        <?php
                                        if (isset($_GET['category'])) {
                                            ?>
                                            <li class="mb-2">
                                                <a href="produkty<?php echo $category . $subcategory; ?>-nejnovejsi" class="<?php if($_GET['sort'] == 'nejnovejsi'){ echo ' active"';}?>">Nejnovější</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="produkty<?php echo $category . $subcategory; ?>-nejprodavanejsi" class="<?php if($_GET['sort'] == 'nejprodavanejsi'){ echo ' active"';}?>">Nejprodávanější</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="produkty<?php echo $category . $subcategory; ?>-nejlevnejsi" class="<?php if($_GET['sort'] == 'nejlevnejsi'){ echo ' active"';}?>">Od nejlevnějšího</a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="produkty<?php echo $category . $subcategory; ?>-nejdrazsi" class="<?php if($_GET['sort'] == 'nejdrazsi'){ echo ' active"';}?>">Od nejdražšího</a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class="mb-2">
                                                <button type="submit" name="sort" value="nejnovejsi" style="background-color: transparent;border: none;outline: none;" class="<?php if($_GET['sort'] == 'nejnovejsi'){ echo ' active"';}?>">Nejnovější</button>
                                            </li>
                                            <li class="mb-2">
                                                <button type="submit" name="sort" value="nejprodavanejsi" style="background-color: transparent;border: none;outline: none;" class="<?php if($_GET['sort'] == 'nejprodavanejsi'){ echo ' active"';}?>">Nejprodávanější</button>
                                            </li>
                                            <li class="mb-2">
                                                <button type="submit" name="sort" value="nejlevnejsi" style="background-color: transparent;border: none;outline: none;" class="<?php if($_GET['sort'] == 'nejlevnejsi'){ echo ' active"';}?>">Od nejlevnějšího</button>
                                            </li>
                                            <li class="mb-2">
                                                <button type="submit" name="sort" value="nejdrazsi" style="background-color: transparent;border: none;outline: none;" class="<?php if($_GET['sort'] == 'nejdrazsi'){ echo ' active"';}?>">Od nejdražšího</button>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <!-- <div class="mb-5">
                                    <h5 class="font-weight-bold mb-3">Parametry</h5>
                                    <div class="divider-small mb-3"></div>
                                    <?php
                                    if (isset($_GET['subcategory'])) {
                                        foreach ($paramsArray as $param) {
                                            if ($param['sub_categories_url'] == $_GET['subcategory']) {
                                                ?>
                                                <p class="text-left font-weight-bold"><?php echo $param['param_name']; ?></p>
                                                <?php
                                                foreach ($paramsValuesArray as $paramVal) {
                                                    if ($paramVal['value_param_id'] == $param['param_id']) {
                                                        ?>
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input name="<?php echo $param['param_name']; ?>" type="checkbox" class="custom-control-input checkbox" id="param_<?php echo $paramVal['value_id']; ?>" value="<?php echo $paramVal['value_value']; ?>">
                                                            <label class="custom-control-label" for="param_<?php echo $paramVal['value_id']; ?>">
                                                                <?php echo $paramVal['value_value']; ?>
                                                                <span class="grey-text">
                                                                    <small>
                                                                        (<?php echo $paramVal['total']; ?>)
                                                                    </small>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <?php    
                                                    }
                                                }
                                            }
                                        }    
                                    }
                                    ?>
                                </div>
                                <div class="mb-5 text-center">
                                    <button id="submit" type="button" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filtrovat</button>
                                </div> -->
                            </div>
                        </div>
                    </section>
                </div>    
            </form>
        </div>

        <!-- <script type="text/javascript">
            $(function(){
                $('.#submit').on('click',function(){
                    $('#form').submit();
                });
            });
        </script> -->

        <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 50px;">
            <div class="row p-4 wow fadeInUp ml-2 mr-2">
                <div class="col-12">
                    <h4 class="text-left font-weight-bold dark-grey-text mb-2">
                        <strong>Nejprodávanější produkty v kategorii</strong>
                    </h4>
                    <hr class="primary-color mb-5">
                </div>
                <?php
                if (empty($bestSellingProductsArray)) {
                    ?>
                    <div class="col-lg-4 col-md-12">
                        Žádné produkty nenalezeny.
                    </div>
                    <?php
                } else {
                    if (count($bestSellingProductsArray) < 3) {
                        $number = count($bestSellingProductsArray);
                    } else {
                        $number = 3;
                    }
                    for ($i=0; $i < $number; $i++) {
                        $image = explode(";", $bestSellingProductsArray[$i]['product_image']);
                        $image = $image[0];
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                                <div class="card hoverable mb-4">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 px-0">
                                                <a href="produkt/<?php echo $bestSellingProductsArray[$i]['product_id'] ?>/<?php echo $bestSellingProductsArray[$i]['product_url'] ?>">
                                                    <img src="images/<?php echo $image; ?>" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-6 text-left">
                                                <a href="produkt/<?php echo $bestSellingProductsArray[$i]['product_id'] ?>/<?php echo $bestSellingProductsArray[$i]['product_url'] ?>" style="text-decoration: none;color: black;">
                                                    <strong><?php echo $bestSellingProductsArray[$i]['product_name']; ?></strong>
                                                </a>
                                                <br>
                                                <?php
                                                if ($bestSellingProductsArray[$i]['product_discount'] > 0) {
                                                    ?>
                                                    <span class="badge badge-danger mb-2">-<?php echo $bestSellingProductsArray[$i]['product_discount']; ?>%</span><br>
                                                    <span class="grey-text">
                                                        <small>
                                                            <s><?php echo $bestSellingProductsArray[$i]['product_price']; ?> Kč</s>
                                                        </small>
                                                    </span>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo number_format($bestSellingProductsArray[$i]['price'], 1); ?> Kč</strong>
                                                    </h6>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo $bestSellingProductsArray[$i]['product_price']; ?> Kč</strong>
                                                    </h6>

                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }    
                }
                ?>
            </div>

            <div class="row pt-4 pb-0 pl-4 pr-4 wow fadeInUp ml-2 mr-2">
                <div class="col-12">
                    <h4 class="text-left font-weight-bold dark-grey-text mb-2">
                        <strong>Všechny produkty</strong>
                    </h4>
                    <hr class="primary-color mb-5">
                </div>
            </div>
            <div class="row pt-0 pb-4 pl-4 pr-4 wow fadeInUp ml-2 mr-2 searchResult">
                <?php
                if (empty($productsArray)) {
                    ?>
                        <div class="col-lg-4 col-md-12">
                            Žádné produkty nenalezeny.
                        </div>
                    <?php
                } else {
                    foreach ($productsArray as $row) {
                        $reviewsArray = $productViewObj->showReviews($row['product_id']);
                        if (count($reviewsArray)>0) {
                            $rating = round((array_sum(array_column($reviewsArray,'review_rating')))/(count($reviewsArray)));
                        } else {
                            $rating = 0;
                        }
                        $image = explode(";", $row['product_image']);
                        $image = $image[0];
                        ?>
                        <div class="d-inline-flex col-lg-4 col-md-6 mb-4 productDetail text-left" style="display: none!important;">
                            <div class="card card-ecommerce">
                                <div class="view overlay" style="height: 200px;">
                                    <img src="images/<?php echo $image; ?>" class="img-fluid" alt="">
                                    <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>">
                                      <div class="mask rgba-white-slight"></div>
                                    </a>
                                </div>
                                <div class="card-body align-bottom">
                                    <?php
                                    if ($row['product_discount'] > 0) {
                                        ?>
                                        <div class="row">
                                            <div class="col text-left">
                                                <h5 class="card-title mb-1">
                                                    <strong>
                                                        <a href="" class="dark-grey-text"><?php echo $row['product_name']; ?></a>
                                                    </strong>
                                                </h5>        
                                            </div>
                                            <div class="col text-right">
                                                <span class="badge badge-danger mb-2">-<?php echo $row['product_discount']; ?>%</span><br>
                                            </div>
                                        </div>
                                        <div>
                                            <?php
                                            if (count($reviewsArray)) {
                                                $rating = round((array_sum(array_column($reviewsArray,'review_rating')))/(count($reviewsArray)));
                                                for ($i=1; $i < 6; $i++) {
                                                    if ($i <= $rating) {
                                                        ?><i class="fas fa-star fa-sm text-primary"></i><?php
                                                    } else {
                                                        ?><i class="far fa-star fa-sm text-primary"></i><?php
                                                    }    
                                                }
                                                ?>
                                                <small class="text-primary">(<?php echo count($reviewsArray); ?>)</small>
                                                <?php 
                                            } else {
                                                ?>
                                                <small class="text-primary">Zatím neohodnoceno</small>
                                                <?php 
                                            }
                                            ?>   
                                        </div>
                                        <div class="card-footer pb-0" style="background-color: white;">
                                            <div class="row mb-0">
                                                <span class="text-left">
                                                    <strong>
                                                        <a href="" class="dark-grey-text mr-2"><?php echo number_format($row['price'], 1); ?> Kč</a>
                                                    </strong>
                                                </span>
                                                <span class="text-left">
                                                    <small>
                                                        <s><?php echo $row['product_price']; ?> Kč</s>
                                                    </small>
                                                </span>
                                                <span class="text-right">
                                                    <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
                                                        <i class="fas fa-shopping-cart ml-3"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div> 
                                        <?php
                                    } else {
                                        ?>
                                            <h5 class="card-title mb-1">
                                                <strong>
                                                    <a href="" class="dark-grey-text"><?php echo $row['product_name']; ?></a>
                                                </strong>
                                            </h5>
                                            <?php
                                            if (count($reviewsArray)) {
                                                $rating = round((array_sum(array_column($reviewsArray,'review_rating')))/(count($reviewsArray)));
                                                for ($i=1; $i < 6; $i++) {
                                                    if ($i <= $rating) {
                                                        ?><i class="fas fa-star fa-sm text-primary"></i><?php
                                                    } else {
                                                        ?><i class="far fa-star fa-sm text-primary"></i><?php
                                                    }    
                                                }
                                                ?>
                                                <small class="text-primary">(<?php echo count($reviewsArray); ?>)</small>
                                                <?php 
                                            } else {
                                                ?>
                                                <small class="text-primary">Zatím neohodnoceno</small>
                                                <?php 
                                            }
                                            ?>
                                        <div class="card-footer pb-0" style="background-color: white;">
                                            <div class="row mb-0">
                                                <span class="text-left">
                                                    <strong>
                                                        <a href="" class="dark-grey-text"><?php echo $row['product_price']; ?> Kč</a>
                                                    </strong>
                                                </span>
                                                <span class="text-right">
                                                    <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
                                                        <i class="fas fa-shopping-cart ml-3"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>    
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="row">
                <p style="margin: 0 auto;">
                    <a id="loadMore" class="btn btn-primary btn-rounded mb-5" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Zobrazit další
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div id="contact_message">
        <?php include 'includes/contact_form.inc.php'; ?>    
    </div>
    <?php include 'footer.php'; ?>
</div>