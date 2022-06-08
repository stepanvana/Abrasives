<?php
require 'vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submitOffer'])) {
    if (empty(trim($_POST['jmeno'])) || empty(trim($_POST['prijmeni'])) || empty(trim($_POST['email'])) || empty(trim($_POST['telefon']))) {
        $message = "Nevyplnili jste všechny osobní údaje!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        unset($_POST['email']);
        $message = "Vyplnili jste neplatný e-mail!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } elseif (empty(trim($_POST['ulice'])) || empty(trim($_POST['CisloPopisny'])) || empty(trim($_POST['mesto'])) || empty(trim($_POST['psc']))) {
        $message = "Nevyplnili jste všechny dodací údaje!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        $createOrderObj = new orders\OrdersContr();
        if ($createOrderObj->createOrder($_POST['delivery']) == true) {
            if ($createOrderObj->createOrdersProducts() == true) {
                if ($createOrderObj->createPayment($_POST['payment']) == true) {
                    if ($createOrderObj->createCustomer($_POST['nazevFirmy'], $_POST['jmeno'], $_POST['prijmeni'], $_POST['email'], $_POST['telefon'], $_POST['povolitEmailing'], $_POST['note']) == true) {
                        if ($createOrderObj->createBillingAddress("Česká republika", $_POST['ulice'], $_POST['CisloPopisny'], $_POST['mesto'], $_POST['psc']) == true && $createOrderObj->createShippingAddress("Česká republika", $_POST['uliceFakturace'], $_POST['CisloPopisnyFakturace'], $_POST['mestoFakturace'], $_POST['pscFakturace']) == true) {
                            unset($_SESSION['shopping_cart']);
                            header("Location: http://127.0.0.1/edsa-Abrasives/www/success_page");
                        } else {
                            $message = "Něco se nám pokazilo, omlouváme se za problémy, kontaktujte nás ohledně Vaší objednávky a my se o všechno postaráme.";
                            echo "<script type='text/javascript'>alert('$message');</script>";
                        }
                    } else {
                        $message = "Něco se nám pokazilo, omlouváme se za problémy, kontaktujte nás ohledně Vaší objednávky a my se o všechno postaráme.";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    }
                } else {
                    $message = "Něco se nám pokazilo, omlouváme se za problémy, kontaktujte nás ohledně Vaší objednávky a my se o všechno postaráme.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            } else {
                $message = "Něco se nám pokazilo, omlouváme se za problémy, kontaktujte nás ohledně Vaší objednávky a my se o všechno postaráme.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        } else {
            $message = "Něco se nám pokazilo, omlouváme se za problémy, kontaktujte nás ohledně Vaší objednávky a my se o všechno postaráme.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}

if (isset($_SESSION['customerId']) && $_SESSION['customerType'] == 'customer') {
    $customersViewObj = new customers\CustomersView();
    $customer = $customersViewObj->showCustomer($_SESSION['customerUid']);
    $address = $customersViewObj->showAddress($_SESSION['customerId']);
}

include 'header.php';
?>

<script type="text/javascript">
    $(document).ready(function() {
        if ($("input[name$='delivery']").is(':checked')) {
            $(".paymentMethod").show();
        }

        if ($("input[name$='payment']").is(':checked')) {
            $(".personalDetails").show();
        }

        if ($("input[id$='differentAddress']").is(':checked')) {
            $("#fakturacniUdaje").show();
        }

        $("input[name$='delivery']").click(function() {
            var test = $(this).val();
            $(".paymentMethod").show(1000);
            $("input[name$='payment']").click(function() {
                var test = $(this).val();
                $(".personalDetails").show(1000);
            });
        });

        $("input[id$='differentAddress']").click(function() {
            var test = $(this).val();
            $("#fakturacniUdaje").toggle(1000);
        })
    });
</script>

<?php

if(!empty($_SESSION['shopping_cart'])) {
	?>

    <form class="card-body" action="" method="POST">
        <main class="mt-3 pt-4">
            <div class="container">
                <h2 class="my-5 h2 text-center wow fadeIn">Dokončení objednávky</h2>
                <div class="row wow fadeIn">
                    <div class="col-md-8 mb-4">
                        <div class="card p-5">
                            <h1 class="text-center">Zvolte dopravu</h1>
                            <div class="deliveryMethod mt-3 mb-3">
                                <ul class="list-group">
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="delivery1" name="delivery" value="1" <?php if(isset($_POST['delivery']) && $_POST['delivery'] == 1){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="delivery1">PPL</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="delivery2" name="delivery" value="2" <?php if(isset($_POST['delivery']) && $_POST['delivery'] == 2){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="delivery2">DPD</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="delivery3" name="delivery" value="3" <?php if(isset($_POST['delivery']) && $_POST['delivery'] == 3){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="delivery3">Česká pošta</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="paymentMethod mt-3 mb-3" style="display: none;">
                                <h1 class="text-center">Zvolte platbu</h1>
                                <ul class="list-group">
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="payment1" name="payment" value="1" <?php if(isset($_POST['payment']) && $_POST['payment'] == 1){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="payment1">Kreditní karta</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="payment2" name="payment" value="2" <?php if(isset($_POST['payment']) && $_POST['payment'] == 2){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="payment2">Bankovní převod</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item pl-5">
                                        <div class="custom-control custom-radio p-2">
                                            <input type="radio" class="custom-control-input" id="payment3" name="payment" value="3" <?php if(isset($_POST['payment']) && $_POST['payment'] == 3){ echo "checked"; } ?>>
                                            <label class="custom-control-label" for="payment3">GoPay</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="personalDetails mt-3 mb-2 p-3" style="display: none;">
                                <h1 class="text-center">Fakturační údaje</h1>
                                <div class="row">
                                    <div class="md-form col-md-6 mb-4">
                                        <input type="text" name="jmeno" id="jmeno" class="form-control" value="<?php if(isset($_POST['jmeno'])){ echo $_POST['jmeno']; } elseif(isset($_SESSION['customerId'])){ echo $customer['registred_name']; } ?>" required>
                                        <label for="jmeno" class="" style="padding-left: 15px;">Jméno</label>
                                    </div>
                                    <div class="md-form col-md-6 mb-2">
                                        <input type="text" name="prijmeni" id="prijmeni" class="form-control" value="<?php if(isset($_POST['prijmeni'])){ echo $_POST['prijmeni']; } elseif(isset($_SESSION['customerId'])){ echo $customer['registred_sirname']; } ?>" required>
                                        <label for="prijmeni" class="" style="padding-left: 15px;">Příjmení</label>
                                    </div>
                                </div>
                                <div class="md-form mb-5">
                                    <input type="text" name="nazevFirmy" id="nazevFirmy" class="form-control" value="<?php if(isset($_POST['nazevFirmy'])){ echo $_POST['nazevFirmy']; } elseif(isset($_SESSION['customerId'])){ echo $customer['registred_company']; } ?>">
                                    <label for="nazevFirmy" class="">Firma</label>
                                </div>
                                <div class="row">
                                    <div class="md-form col-md-6 mb-4">
                                        <input type="text" name="telefon" id="telefon" class="form-control" value="<?php if(isset($_POST['telefon'])){ echo $_POST['telefon']; } elseif(isset($_SESSION['customerId'])){ echo $customer['registred_phone']; } ?>" required>
                                        <label for="telefon" class="" style="padding-left: 15px;">Telefon</label>
                                    </div>
                                    <div class="md-form col-md-6 mb-2">
                                        <input type="text" name="email" id="email" class="form-control" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } elseif(isset($_SESSION['customerId'])){ echo $customer['registred_email']; } ?>" required>
                                        <label for="email" class="" style="padding-left: 15px;">E-mail</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="md-form col-md-6 mb-4">
                                        <input type="text" name="ulice" id="ulice" class="form-control" value="<?php if(isset($_POST['ulice'])){ echo $_POST['ulice']; } elseif(isset($_SESSION['customerId'])){ echo $address['billing_street']; } ?>" required>
                                        <label for="ulice" class="" style="padding-left: 15px;">Ulice</label>
                                    </div>
                                    <div class="md-form col-md-6 mb-2">
                                        <input type="text" name="CisloPopisny" id="CisloPopisny" class="form-control" value="<?php if(isset($_POST['CisloPopisny'])){ echo $_POST['CisloPopisny']; } elseif(isset($_SESSION['customerId'])){ echo $address['billing_desc_num']; } ?>" required>
                                        <label for="CisloPopisny" class="" style="padding-left: 15px;">Číslo popisné</label>
                                    </div>
                                </div>
                                <div class="md-form mb-5">
                                    <input type="text" name="mesto" id="mesto" class="form-control" value="<?php if(isset($_POST['mesto'])){ echo $_POST['mesto']; } elseif(isset($_SESSION['customerId'])){ echo $address['billing_city']; } ?>" required>
                                    <label for="mesto" class="">Město</label>
                                </div>
                                <div class="md-form mb-5">
                                    <input type="text" name="psc" id="psc" class="form-control" value="<?php if(isset($_POST['psc'])){ echo $_POST['psc']; } elseif(isset($_SESSION['customerId'])){ echo $address['billing_zip']; } ?>" required>
                                    <label for="psc" class="">PSČ</label>
                                </div>
                                <div class="custom-control custom-checkbox ">
                                    <input type="hidden" name="differentAddress" value="0"><input id="differentAddress" class="custom-control-input" type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" <?php if(isset($_POST['differentAddress']) && $_POST['differentAddress'] == 1){ echo "checked"; } ?>>
                                    <label class="custom-control-label" for="differentAddress">Chci doručit na jinou než fakturační adresu.</label>
                                </div>
                                <div class="" id="fakturacniUdaje" style="display: none;">
                                    <div class="row">
                                        <div class="md-form col-md-6 mb-4">
                                            <input type="text" name="uliceFakturace" id="uliceFakturace" class="form-control" value="<?php if(isset($_POST['uliceFakturace'])){ echo $_POST['uliceFakturace']; } elseif(isset($_SESSION['customerId'])){ echo $address['shipping_street']; } ?>">
                                            <label for="uliceFakturace" class="" style="padding-left: 15px;">Ulice</label>
                                        </div>
                                        <div class="md-form col-md-6 mb-2">
                                            <input type="text" name="CisloPopisnyFakturace" id="CisloPopisnyFakturace" class="form-control" value="<?php if(isset($_POST['CisloPopisnyFakturace'])){ echo $_POST['CisloPopisnyFakturace']; } elseif(isset($_SESSION['customerId'])){ echo $address['shipping_desc_num']; } ?>">
                                            <label for="CisloPopisnyFakturace" class="" style="padding-left: 15px;">Číslo popisné</label>
                                        </div>
                                    </div>
                                    <div class="md-form mb-5">
                                        <input type="text" name="mestoFakturace" id="mestoFakturace" class="form-control" value="<?php if(isset($_POST['mestoFakturace'])){ echo $_POST['mestoFakturace']; } elseif(isset($_SESSION['customerId'])){ echo $address['shipping_city']; } ?>">
                                        <label for="mestoFakturace" class="">Město</label>
                                    </div>
                                    <div class="md-form mb-5">
                                        <input type="text" name="pscFakturace" id="pscFakturace" class="form-control" value="<?php if(isset($_POST['pscFakturace'])){ echo $_POST['pscFakturace']; } elseif(isset($_SESSION['customerId'])){ echo $address['shipping_zip']; } ?>">
                                        <label for="pscFakturace" class="">PSČ</label>
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox mt-4 mb-4">
                                    <input type="hidden" name="povolitEmailing" value="0"><input id="povolitEmailing" class="custom-control-input" type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" <?php if(isset($_POST['povolitEmailing']) && $_POST['povolitEmailing'] == 1){ echo "checked"; } ?>>
                                    <label class="custom-control-label" for="povolitEmailing">Chci posílat novinky a akce.</label>
                                </div>
                                <div>
                                    <textarea name="note" class="form-control" id="note" rows="4" placeholder="Poznámka k objednávce ..."><?php if(isset($_POST['note'])){ echo $_POST['note']; } ?></textarea>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <button name="submitOffer" class="btn btn-primary btn-lg btn-block " type="submit">Závazně objednat</button>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4 ">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Košík</span>
                            <span class="badge badge-danger badge-pill"><?php echo count($_SESSION['shopping_cart']); ?></span>
                        </h4>
                        <ul class="list-group mb-3 z-depth-1">
                            <?php
                            if(!empty($_SESSION['shopping_cart'])) {
                                $total = 0;
                                foreach ($_SESSION['shopping_cart'] as $key => $product) {
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><?php echo $product['name']; ?></h6>
                                            <small class="text-muted"><?php echo $product['quantity']; ?> ks</small>
                                        </div>
                                        <span class="text-muted"><?php echo $product['price']; ?> Kč</span>
                                        <span class="text-muted"><?php echo number_format($product['price']*$product['quantity'], 2); ?> Kč</span>
                                    </li>
                                    <?php
                                    $total = $total + ($product['quantity'] * $product['price']);
                                } ?>
                                <input type='hidden' name='totalPrice' value=<?php echo number_format($total, 2); ?>>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Celkem</span>
                                    <strong><?php echo number_format($total, 2); ?> Kč</strong>
                                </li> <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </form>

<?php
    include 'footer.php'; 
} else {
    echo "Košík je prázdný<br>";
    echo "<a href='index.php'>Zpět na produkty</a>";
} ?>