<?php
if (isset($_POST['searchBtn'])) {
    header('Location: /vyhledavani/' . $_POST['search'] . '');
}

if (isset($_POST['send'])) {
    session_start();
    require 'vendor/autoload.php';
    $customersContrObj = new customers\CustomersContr();
    $customersContrObj->sendReview($_GET['id'], $_SESSION['customerId'], $_SESSION['customerUid'], $_POST);
}

if (isset($_POST['delete'])) {
    require 'vendor/autoload.php';
    $customersContrObj = new customers\CustomersContr();
    $customersContrObj->deleteReview($_POST['delete']);
}

include 'header.php';
if (!isset($_GET['id'])) {
    header("Location: ../produkty");
} else {
    include 'nav.php';
    $row = $productViewObj->showProductsDetail($_GET['id'], NULL);
    $paramsValuesArray = $productViewObj->showParamsValues($_GET['id']);

    if ($row == false) {
        echo "Produkt nenalezen, <a href='produkty'>zpět na seznam produktů</a>";
        exit();
    } else {
        $reviewsArray = $productViewObj->showReviews($_GET['id']);

?>

<div class="container">
    <nav class="navbar navbar-expand-md navbar-dark primary-color no-content" id="categories" style="margin-top: 180px;">
        <div class="mr-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb clearfix d-none d-md-inline-flex pt-0">
                    <li class="breadcrumb-item">
                        <a class="white-text font-weight-bold" href="produkty/<?php echo $row['category_name']; ?>">
                            <?php echo $row['category_name']; ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a class="white-text" href="produkty/<?php echo $row['category_name']; ?>/<?php echo $row['sub_categories_name']; ?>">
                            <?php echo $row['sub_categories_name']; ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?php echo $row['product_name']; ?>
                    </li>
                </ol>
            </nav>
        </div>
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
    </nav>
</div>

<div id="output"></div>

<main class="text-center">
    <div class="container mt-5">
        <section class="text-center dark-grey-text">
            <h3 class="font-weight-bold mb-5">Detail produktu</h3>
            <div class="row">
                <div class="col-lg-6">
                    <div id="carousel-thumb1" class="carousel slide carousel-fade carousel-thumbnails mb-2 pb-4" data-ride="carousel" style="z-index: 0;">
                        <div class="carousel-inner text-center text-md-left z-depth-1" role="listbox" style="width: 80%;margin: 0 auto;height: 400px;">
                            <?php
                            $imagesString = $row['product_image'];
                            $imagesArray = explode(';', $imagesString);
                            ?>
                            <div class="carousel-item active">
                                <img src="images/<?php echo $imagesArray[0]; ?>" alt="First slide" class="img-fluid" style="max-height: 400px;">
                            </div>
                            <?php
                            for ($i=1; $i < count($imagesArray); $i++) { 
                                ?>
                                <div class="carousel-item">
                                    <img src="images/<?php echo $imagesArray[$i]; ?>" alt="First slide" class="img-fluid" style="max-height: 400px;">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-thumb1" role="button" data-slide="prev">
                            <i class="fas fa-chevron-left" style="color: black;" aria-hidden="true"></i>
                            <span class="sr-only">Předešlý</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-thumb1" role="button" data-slide="next">
                            <i class="fas fa-chevron-right" style="color: black;" aria-hidden="true"></i>
                            <span class="sr-only">Další</span>
                        </a>
                    </div>
                    <div class="row mb-4" style="width: 80%;margin: 0 auto;">
                        <?php
                        foreach ($imagesArray as $img) {
                            ?>
                            <div class="d-inline-flex col-4 col-md-4">
                                <a data-size="1600x1067">
                                    <img src="images/<?php echo $img; ?>" alt="thumbnail" class="img-fluid" style="width: 200px">
                                </a>
                            </div>    
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <h5><?php echo $row['product_name']; ?></h5>
                    <p class="mb-2 text-muted text-uppercase small"><?php echo $row['sub_categories_name']; ?></p>
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
                    if ($row['product_discount'] > 0) {
                    ?>
                    <p>
                        <span class="mr-1">
                            <strong><?php echo number_format($row['price'], 1); ?> Kč</strong>
                        </span>
                        <span class="grey-text">
                            <small>
                                <s><?php echo $row['product_price']; ?> Kč</s>
                            </small>
                        </span>
                    </p>
                    <span class="badge badge-danger product mb-4">-<?php echo $row['product_discount']; ?>%</span>  
                    <?php
                    } else {
                        ?>
                        <p><span class="mr-1"><strong><?php echo number_format($row['product_price'], 1); ?> Kč</strong></span></p>
                        <?php
                    }
                    ?>
                    <p class="pt-1"><?php echo $row['product_shortDesc']; ?></p>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <?php
                                foreach ($paramsValuesArray as $param) {
                                    ?>
                                    <tr>
                                        <th class="pl-0 w-25" scope="row"><strong><?php echo $param['param_name']; ?></strong></th>
                                        <td><?php echo $param['value_value']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mb-2">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="pl-0 pb-0 w-25">Quantity</td>
                                </tr>
                                <tr>
                                    <td class="pl-0">
                                        <div class="def-number-input number-input safari_only mb-0">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                        class="minus"></button>
                                        <input class="quantity" min="0" name="quantity" value="1" type="number">
                                        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                        class="plus"></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button id="add" name="add_to_cart" type="submit" class="btn btn-primary btn-md mr-1 mb-2"><i class="fas fa-shopping-cart pr-2"></i>Přidat do košíku</button>
                    <div class="row">
                        <div id="success_msg" class="col-12 alert alert-success text-center mt-5" role="alert" style="display: none;">
                            Produkt byl přidán do košíku, děkujeme.
                        </div>
                        <div id="error_msg" class="col-12 alert alert-danger text-center mt-5" role="alert" style="display: none;">
                            Něco se pokazilo, prosím kontaktujte nás ohledně tohoto problému.
                        </div>
                    </div>
                                    
                    <input type="hidden" name="id" value="<?php echo $row['product_id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $row['product_name']; ?>">
                    <?php
                    if ($row['product_discount'] > 0) {
                        ?>
                        <input type="hidden" name="price" value="<?php echo number_format($row['price'], 1); ?>">
                        <?php
                    } else {
                        ?>
                        <input type="hidden" name="price" value="<?php echo $row['product_price']; ?>">
                        <?php
                    }
                    ?>
                    <input type="hidden" name="url" value="<?php echo $row['product_url']; ?>">
                    <input type="hidden" name="costs" value="<?php echo $row['product_purchase_price']; ?>">
                    <input type="hidden" name="discount" value="<?php echo $row['product_discount']; ?>">
                    <input type="hidden" name="image" value="<?php echo $imagesArray[0]; ?>">
                    <input type="hidden" name="category" value="<?php echo $row['sub_categories_name']; ?>">
                </div>
            </div>
            <div class="row p-5">
                <div class="col text-left">
                    <h3 class="font-weight-bold text-center mb-5">Popis produktu</h3>
                    <p class="pl-5">
                        <?php echo $row['product_desc']; ?>
                    </p>    
                </div>
            </div>
            <hr class="hr">
            <div class="row p-5">
                <div class="container my-5">
                    <section class="dark-grey-text">
                        <form action="" method="POST">
                        <h3 class="font-weight-bold text-center mb-5">Recenze</h3>
                        <?php
                        if (isset($_SESSION['customerId']) && $_SESSION['customerType'] == 'customer') {
                            ?>
                            <div class="text-right">
                                <a href="" class="btn btn-primary btn-sm btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">Přidat recenzi</a>
                            </div>

                            <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title w-100 font-weight-bold">Přidat recenzi</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php
                                        if (!isset($_SESSION['customerConfirm']) || $_SESSION['customerConfirm'] !== 1) {
                                            ?>
                                            <div class="modal-body mx-3">
                                                Nejprve ověřte Váš e-mail.
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <i class="fas fa-pencil prefix grey-text"></i>
                                                    <textarea name="review" type="text" id="form8" class="md-textarea form-control" rows="4" required></textarea>
                                                    <label data-error="wrong" data-success="right" for="form8">Vaše hodnocení produktu ...</label>
                                                </div>

                                                <style type="text/css">
                                                    .rating-stars ul {
                                                        list-style-type:none;
                                                        padding:0;
                                                        -moz-user-select:none;
                                                        -webkit-user-select:none;
                                                    }
                                                    .rating-stars ul > li.star {
                                                        display:inline-block;
                                                    }
                                                    .rating-stars ul > li.star > i.fa {
                                                        font-size:2.5em;
                                                        color:#ccc;
                                                    }
                                                    .rating-stars ul > li.star.hover > i.fa {
                                                        color:#FFCC36;
                                                    }
                                                    .rating-stars ul > li.star.selected > i.fa {
                                                        color:#FF912C;
                                                    }
                                                </style>

                                                <div class='rating-stars text-center'>
                                                    <ul id='stars'>
                                                        <li class='star' title='Nikdy více' data-value='1'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Nic moc' data-value='2'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Dobré' data-value='3'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Výborné' data-value='4'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Dokonalé' data-value='5'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        $('#stars li').on('mouseover', function(){
                                                            var onStar = parseInt($(this).data('value'), 10);
                                                            $(this).parent().children('li.star').each(function(e){
                                                                if (e < onStar) {
                                                                    $(this).addClass('hover');
                                                                }
                                                                else {
                                                                    $(this).removeClass('hover');
                                                                }
                                                            });
                                                        }).on('mouseout', function(){
                                                            $(this).parent().children('li.star').each(function(e){
                                                                $(this).removeClass('hover');
                                                            });
                                                        });
                                                        $('#stars li').on('click', function(){
                                                            var onStar = parseInt($(this).data('value'), 10);
                                                            var stars = $(this).parent().children('li.star');
                                                            for (i = 0; i < stars.length; i++) {
                                                                $(stars[i]).removeClass('selected');
                                                            }
                                                            for (i = 0; i < onStar; i++) {
                                                                $(stars[i]).addClass('selected');
                                                            }
                                                            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                                                            responseMessage(ratingValue);
                                                        });
                                                    });

                                                    function responseMessage(ratingValue) {
                                                        $( ".prefix-rating" ).remove();
                                                        $('.success-box div.text-message').html("<input type='hidden' name='rating' value='" + ratingValue + "'>");
                                                    }
                                                </script>

                                                <div class="prefix-rating">
                                                    <input type="hidden" name="prefix-rating" required>
                                                </div>
                                                <div class='success-box'>
                                                    <div class='text-message'></div>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="submit" name="send" class="btn btn-primary">Odeslat</button>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo "<p class='pb-4'>Pro přidání recenze musíte být přihlášeni.</p>";
                        }

                        if ($reviewsArray == false) {
                            ?>
                            <div class="media mb-3 text-left">
                                <div class="media-body">
                                    <a>
                                        <h5 class="user-name font-weight-bold">Žádné recenze nebyli doposud přidané.</h5>
                                    </a>
                                </div>
                            </div>
                            <?php
                        } else {
                            foreach ($reviewsArray as $review) {
                                ?>
                                <div class="media mb-3 text-left">
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col text-left">
                                                <a>
                                                    <h5 class="user-name font-weight-bold"><?php echo $review['registred_name']; ?></h5>
                                                </a>        
                                            </div>
                                            <?php 
                                            if (isset($_SESSION['userId']) && $_SESSION['userType'] == 'admin') {
                                                ?>
                                                <div class="col text-right">
                                                    <button type="submit" name="delete" class="btn btn-danger btn-sm btn-rounded mb-4" value="<?php echo $review['review_id']; ?>">Odstranit</button>
                                                </div>    
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        
                                        <?php
                                        for ($i=1; $i < 6; $i++) {
                                            if ($i <= $review['review_rating']) {
                                                ?><i class="fas fa-star fa-sm text-primary"></i><?php
                                            } else {
                                                ?><i class="far fa-star fa-sm text-primary"></i><?php
                                            }    
                                        }
                                        ?>
                                        <div class="card-data mb-3">
                                            <ul class="list-unstyled mb-1">
                                                <li class="comment-date font-small grey-text">
                                                    <i class="far fa-clock"></i> <?php echo date("d.m.Y h:m:s", strtotime($review['review_date'])); ?></li>
                                            </ul>
                                        </div>
                                        <p class="dark-grey-text article"><?php echo $review['review_text']; ?></p>
                                    </div>
                                </div>
                                <hr class="hr">
                                <?php
                            }
                        }
                        ?>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <section class="container dark-grey-text text-center">
        <div>
            <div class="separator wow fadeInUp">
                <h1 style="text-align: center;font-weight: 300!important;padding-bottom: 30px;color:rgb(55, 58, 60);font-size:32px;">
                    Related products
                </h1>  
            </div>
            <div class="row wow fadeInUp">
                <?php
                if (!empty($row['product_related'])) {
                    $relatedArray = $productViewObj->showProductsDetail(NULL, $row['product_related']);

                    if ($relatedArray == false) {
                        echo "Žádné podobné produkty.";
                    } else {
                        foreach ($relatedArray as $rowRelated) {
                            $reviewsArray = $productViewObj->showReviews($rowRelated['product_id']);
                            $image = explode(";", $rowRelated['product_image']);
                            $image = $image[0];
                            ?>
                            <div class="d-inline-flex col-lg-3 col-md-6 mb-4 productDetail text-left" style="display: none;">
                                <div class="card card-ecommerce">
                                    <div class="view overlay" style="height: 200px;">
                                        <img src="images/<?php echo $image; ?>" class="img-fluid" alt="">
                                        <a href="produkt/<?php echo $rowRelated['product_id']; ?>/<?php echo $rowRelated['product_url']; ?>">
                                          <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                    <div class="card-body align-bottom">
                                        <?php
                                        if ($rowRelated['product_discount'] > 0) {
                                            ?>
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title mb-1">
                                                        <strong>
                                                            <a href="" class="dark-grey-text"><?php echo $rowRelated['product_name']; ?></a>
                                                        </strong>
                                                    </h5>        
                                                </div>
                                                <div class="col">
                                                    <span class="badge badge-danger mb-2">-<?php echo $rowRelated['product_discount']; ?>%</span>
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
                                                            <a href="" class="dark-grey-text mr-2"><?php echo number_format($rowRelated['price'], 1); ?> Kč</a>
                                                        </strong>
                                                    </span>
                                                    <span class="text-left">
                                                        <small>
                                                            <s><?php echo $rowRelated['product_price']; ?> Kč</s>
                                                        </small>
                                                    </span>
                                                    <span class="text-right">
                                                        <a href="produkt/<?php echo $rowRelated['product_id']; ?>/<?php echo $rowRelated['product_url']; ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
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
                                                    <a href="" class="dark-grey-text"><?php echo $rowRelated['product_name']; ?></a>
                                                </strong>
                                            </h5>
                                            <div class="card-footer pb-0" style="background-color: white;">
                                                <div class="row mb-0">
                                                    <span class="text-left">
                                                        <strong>
                                                            <a href="" class="dark-grey-text"><?php echo $rowRelated['product_price']; ?> Kč</a>
                                                        </strong>
                                                    </span>
                                                    <span class="text-right">
                                                        <a href="produkt/<?php echo $rowRelated['product_id']; ?>/<?php echo $rowRelated['product_url']; ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
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
                } else {
                    echo "Žádné podobné produkty.";
                }
                ?>  
            </div>
        </div>
    </section>

    <div class="container" id="contact_message">
        <?php  include 'includes/contact_form.inc.php'; ?>  
    </div>

</div>      

<?php
        include 'footer.php';
    }
}
?>