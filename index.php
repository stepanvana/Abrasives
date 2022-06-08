<?php
include 'header.php';

$bestSellingArray = $productViewObj->showBestSellingProducts(NULL, NULL, "product_sold");
$discountArray = $productViewObj->showBestSellingProducts(NULL, NULL, "product_discount");
$newestArray = $productViewObj->showBestSellingProducts(NULL, NULL, "product_id");
$categoriesArray = $productViewObj->showCategories();
$subCategoriesArray = $productViewObj->showSubCategories();

include 'nav.php';
?>

<div class="card card-intro blue-gradient wow fadeIn">
    <section>
        <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel" style="z-index: 0;">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-2" data-slide-to="1"></li>
                <li data-target="#carousel-example-2" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="view">
                        <a href="#!">
                            <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/ecommerce4.jpg" alt="First slide">
                            <div class="mask rgba-white-slight text-center d-flex align-items-center justify-content-center">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="h1-responsive red-text font-weight-bold mb-0">Sale off 30% on every saturday!</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="view">
                        <a>
                            <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/ecommerce2.jpg" alt="Second slide">
                            <div class="mask rgba-white-slight text-center d-flex align-items-center justify-content-center">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="h1-responsive indigo-text font-weight-bold mb-0">Promotion on each smartphone!</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="view">
                        <a>
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Others/ecommerce3.jpg" alt="Third slide">
                        <div class="mask rgba-white-slight text-center d-flex align-items-center justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <p class="h1-responsive orange-text font-weight-bold mb-0">Sale off 20% on every headphones!</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>    
</div>


<span class="anchor" id="categories2" style="display: block;height: 80px;margin-top: -80px;visibility: hidden;"></span>
<nav class="navbar navbar-expand-lg navbar-dark primary-color wow fadeIn" style="z-index: 1;" id="categories">
    <div class="container">
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
    </div>
</nav>

<div id="output"></div>

<main class="text-center">
    <div class="container mt-5 wow fadeIn">
        <section class="dark-grey-text text-center" style="margin-top: 5%;">
            <div class="col-12">
                <h5 class="text-center font-weight-bold dark-grey-text mb-4">
                    <strong>Nejprodávanější produkty</strong>
                </h5>
            </div>
            <div class="row text-left">
                <?php
                    if ($bestSellingArray == false) {
                        echo "Žádné produkty.";
                    } else {
                        foreach ($bestSellingArray as $row) {
                            $image = explode(";", $row['product_image']);
                            $image = $image[0];
                            ?>
                            <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                                <div class="card hoverable mb-4">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 px-0">
                                                <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>">
                                                    <img src="images/<?php echo $image; ?>" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>" style="text-decoration: none;color: black;">
                                                    <strong><?php echo $row['product_name']; ?></strong>
                                                </a>
                                                <br>
                                                <?php
                                                if ($row['product_discount'] > 0) {
                                                    ?>
                                                    <span class="badge badge-danger mb-2">-<?php echo $row['product_discount']; ?>%</span><br>
                                                    <span class="grey-text">
                                                        <small>
                                                            <s><?php echo $row['product_price']; ?> Kč</s>
                                                        </small>
                                                    </span>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo number_format($row['price'], 1); ?> Kč</strong>
                                                    </h6>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo $row['product_price']; ?> Kč</strong>
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
        </section>
    </div>


    <div class="container mt-0 wow fadeIn">
        <section class="dark-grey-text text-center">
            <div class="col-12">
                <h5 class="text-center font-weight-bold dark-grey-text mb-4">
                    <strong>Akční produkty</strong>
                </h5>
            </div>
            <div class="row text-left">
                <?php
                    if ($discountArray == false) {
                        echo "Žádné produkty.";
                    } else {
                        foreach ($discountArray as $row) {
                            if ($row['product_discount'] > 0) {
                                $image = explode(";", $row['product_image']);
                                $image = $image[0];
                                ?>
                                <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                                    <div class="card hoverable mb-4">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-6 px-0">
                                                    <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>">
                                                        <img src="images/<?php echo $image; ?>" class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>" style="text-decoration: none;color: black;">
                                                        <strong><?php echo $row['product_name']; ?></strong>
                                                    </a>
                                                    <br>
                                                    </h6>
                                                        <span class="badge badge-danger mb-2">-<?php echo $row['product_discount']; ?>%</span><br>
                                                        <span class="grey-text">
                                                            <small>
                                                                <s><?php echo $row['product_price']; ?> Kč</s>
                                                            </small>
                                                        </span>
                                                        <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                            <strong><?php echo number_format($row['price'], 1); ?> Kč</strong>
                                                        </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        }  
                    }
                ?>
            </div>
        </section>
    </div>

    <div class="container wow fadeIn">
        <section class="dark-grey-text text-center">
            <div class="col-12">
                <h5 class="text-center font-weight-bold dark-grey-text mb-4">
                    <strong>Nejnovější produkty</strong>
                </h5>
            </div>
            <div class="row text-left">
                <?php
                    if ($newestArray == false) {
                        echo "Žádné produkty.";
                    } else {
                        foreach ($newestArray as $row) {
                            $image = explode(";", $row['product_image']);
                            $image = $image[0];
                            ?>
                            <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
                                <div class="card hoverable mb-4">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6 px-0">
                                                <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>">
                                                    <img src="images/<?php echo $image; ?>" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="produkt/<?php echo $row['product_id'] ?>/<?php echo $row['product_url'] ?>" style="text-decoration: none;color: black;">
                                                    <strong><?php echo $row['product_name']; ?></strong>
                                                </a>
                                                <br>
                                                </h6>
                                                <?php
                                                if ($row['product_discount'] > 0) {
                                                    ?>
                                                    <span class="badge badge-danger mb-2">-<?php echo $row['product_discount']; ?>%</span><br>
                                                    <span class="grey-text">
                                                        <small>
                                                            <s><?php echo $row['product_price']; ?> Kč</s>
                                                        </small>
                                                    </span>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo number_format($row['price'], 1); ?> Kč</strong>
                                                    </h6>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <h6 class="h6-responsive font-weight-bold dark-grey-text">
                                                        <strong><?php echo $row['product_price']; ?> Kč</strong>
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
        </section>
    </div>

    <div class="container mt-5">
        <section class="dark-grey-text">
            <div class="col-12 wow fadeIn">
                <h4 class="text-center font-weight-bold dark-grey-text mb-2">
                    <strong>K Abrasives</strong>
                </h4>
                <hr class="primary-color mb-5">
            </div>
            <p class="text-center mx-auto w-responsive mb-5 wow fadeIn">Zabýváme se dovozem a distribucí široké škály brusných materiálů firmy STARCKE, která vyrábí materiály ERSTA a MATADOR. Jedná se o brusivo na papírových a plátěných podkladech. Firmu STARCKE zastupujeme na českém a slovenském trhu již od roku 2001.<br>
            Předností naší firmy je vlastní konfekce všech běžně používaných tvarů brusných materiálů.Díky moderním poloautomatickým strojům vám můžeme zhotovit na zakázku, nebo dodat ze širokých skladových zásob.<br></p>
            <div class="row align-items-center text-left wow fadeIn">
                <div class="col-lg-5">
                    <div class="view overlay rounded z-depth-2 mb-lg-0 mb-4">
                        <img class="img-fluid" src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="Sample image">
                        <a>
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <a href="#!" class="primary-text">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-handshake pr-2"></i>Spolupráce</h6>
                    </a>
                    <h4 class="font-weight-bold mb-3"><strong>GRANIT</strong></h4>
                    <p>Zastupujeme výrobce brusných, řezných a keramických kotoučů GRANIT. Tento maďarský výrobce s více než padesátiletou tradicí splňuje nejpřísnější kvalitativní a bezpečnostní požadavky. Je držitelem certifikátů OSA, ISO a IQNet.</p>
                    <a class="btn btn-primary btn-md btn-rounded mx-0">Více informací</a>
                </div>
            </div>
            <hr class="my-5">
            <div class="row align-items-center text-right wow fadeIn">
                <div class="col-lg-7">
                    <a href="#!" class="primary-text">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-handshake pr-2"></i>Spolupráce</h6>
                    </a>
                    <h4 class="font-weight-bold mb-3"><strong>VSM</strong></h4>
                    <p>Dovážíme brusné vulkanfíbry a plátna od firmy VSM. Kromě standardních brusných materiálů se firma VSM orientuje na speciální produkty v oblasti kovoobrábění. Je známá skvělou kvalitou a škálou materiálů s keramickým a kompaktním zrnem.</p>
                    <a class="btn btn-primary btn-md btn-rounded mx-0">Více informací</a>
                </div>
                <div class="col-lg-5">
                    <div class="view overlay rounded z-depth-2 mb-lg-0 mb-4">
                        <img class="img-fluid" src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="Sample image">
                        <a>
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-5">
            <div class="row align-items-center text-left wow fadeIn mb-5">
                <div class="col-lg-5">
                    <div class="view overlay rounded z-depth-2 mb-lg-0 mb-4">
                        <img class="img-fluid" src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" alt="Sample image">
                        <a>
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <a href="#!" class="primary-text">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-handshake pr-2"></i>Spolupráce</h6>
                    </a>
                    <h4 class="font-weight-bold mb-3"><strong>AWUKO</strong></h4>
                    <p>V naší nabídce najdete také produkty AWUKO. Produkty, především pro dřevařský průmysl, si oblíbilo mnoho našich odběratelů pro jejich standardní vysokou kvalitu. AWUKO se také orientuje na velké segmentové pásy k broušení dřevotřísky i spárovky a jako doposud jediní vyrábějí některé typy pláten ve dvoumetrové šíři.</p>
                    <a class="btn btn-primary btn-md btn-rounded mx-0">Více informací</a>
                </div>
            </div>
        </section>
    </div>

    <section class="numbers z-depth-1 wow fadeIn" style="width: 100%;margin-top: 5%;">
        <div class="text-white rgba-black-strong p-5">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-lg-3 mb-4 mt-4 text-center">
                        <h4 class="h1 font-weight-normal mb-3">
                            <i class="fas fa-file-alt" style="color: #007bff;"></i>
                            <span class="value1 d-inline-block count-up">100</span>
                        </h4>
                        <p class="font-weight-normal text-light">Projektů</p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mt-4 text-center">
                        <h4 class="h1 font-weight-normal mb-3">
                            <i class="fas fa-layer-group" style="color: #007bff;"></i>
                            <span class="value2 d-inline-block count1">250</span>
                        </h4>
                        <p class="font-weight-normal text-light">Druhů produktů</p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mt-4 text-center">
                        <h4 class="h1 font-weight-normal mb-3">
                            <i class="fas fa-pencil-ruler" style="color: #007bff;"></i>
                            <span class="value3 d-inline-block count2">330</span>
                        </h4>
                        <p class="font-weight-normal text-light">Vyrobených kusů</p>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mt-4 text-center">
                        <h4 class="h1 font-weight-normal mb-3">
                            <i class="fab fa-react" style="color: #007bff;"></i>
                            <span class="value4 d-inline-block count3">430</span>
                        </h4>
                        <p class="font-weight-normal text-light">Dokončených zásilek</p>
                    </div>
                </div>  
            </div>
        </div>
    </section>

    <div id="subscribe">
        <?php
            include 'includes/email_sub.inc.php';
        ?>    
    </div>
   
    <div id="contact_message" class="container mt-5">
        <?php
            include 'includes/contact_form.inc.php'; 
        ?>
    </div>

    <section class="grey lighten-2 py-5">
        <div class="flex-center">
            <div class="row">
                <div class="col-md-3 flex-center">
                    <img src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" class="img-fluid wow fadeIn" data-wow-delay=".2s" width="150px">
                </div>
                <div class="col-md-3 flex-center">
                    <img src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" class="img-fluid wow fadeIn" data-wow-delay=".4s" width="150px">
                </div>
                <div class="col-md-3 flex-center">
                    <img src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" class="img-fluid wow fadeIn" data-wow-delay=".4s" width="150px">
                </div>
                <div class="col-md-3 flex-center">
                    <img src="https://www.sane.org/components/com_easyblog/themes/wireframe/images/placeholder-image.png" class="img-fluid wow fadeIn" data-wow-delay=".2s" width="150px">
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        // Counting
        $(window).scroll(testScroll);
        var viewed = false;

        function isScrolledIntoView(elem) {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
        }

        function testScroll() {
            if (isScrolledIntoView($(".numbers")) && !viewed) {
                viewed = true;
                $('.value1').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 1000,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
                $('.value2').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 2500,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
                $('.value3').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 3300,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
                $('.value4').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 4300,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            }
        }
    </script>

<?php
    include 'footer.php'; 
?>