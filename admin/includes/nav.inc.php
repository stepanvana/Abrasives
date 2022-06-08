<div class="sidebar-fixed position-fixed">
    <a class="logo-wrapper waves-effect">
        <img src="https://mdbootstrap.com/img/logo/mdb-email.png" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
        <a href="prehled.php" class="list-group-item <?php if($page == 'prehled.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-home mr-3" style="width: 15px;text-align: center;"></i>Přehled
        </a>
        <a href="objednavky.php" class="list-group-item <?php if($page == 'objednavky.php' || $page == 'detail-objednavky.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-money-bill-alt mr-3" style="width: 15px;text-align: center;"></i>Objednávky
        </a>
        <a href="order-create.php" class="list-group-item <?php if($page == 'order-create.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Nová objednávka
        </a>
        <a href="produkty.php" class="list-group-item <?php if($page == 'produkty.php' || $page == 'detail-produktu.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-box-open mr-3" style="width: 15px;text-align: center;"></i>Produkty
        </a>
        <a href="novy-produkt.php" class="list-group-item <?php if($page == 'novy-produkt.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Nový produkt
        </a>
        <a href="produkty-ceny.php" class="list-group-item <?php if($page == 'produkty-ceny.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Ceny produktů
        </a>
        <a href="produkty-sklad.php" class="list-group-item <?php if($page == 'produkty-sklad.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Sklad produktů
        </a>
        <a href="kategorie.php" class="list-group-item <?php if($page == 'kategorie.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Kategorie
        </a>
        <a href="zakaznici.php" class="list-group-item <?php if($page == 'zakaznici.php' || $page == 'detail-zakaznika.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-user mr-3" style="width: 15px;text-align: center;"></i>Zákazníci
        </a>
        <a href="statistiky.php" class="list-group-item <?php if($page == 'statistiky.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-chart-bar mr-3" style="width: 15px;text-align: center;"></i>Statistiky tržeb
        </a>
        <a href="statistiky-objednavky.php" class="list-group-item <?php if($page == 'statistiky-objednavky.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Statistiky objednávek
        </a>
        <a href="statistiky-produkty.php" class="list-group-item <?php if($page == 'statistiky-produkty.php'){ echo 'active';}?> list-group-item-action waves-effect" style="padding-left: 50px;">
            Statistiky produktů
        </a>
        <a href="contact-messages.php" class="list-group-item <?php if($page == 'contact-messages.php' || $page =='message-reply.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="far fa-envelope mr-3" style="width: 15px;text-align: center;"></i>Zprávy<span class="badge badge-danger ml-2" style="float: right;margin-top: 3px;"><?php echo $count; ?></span>
        </a>
        <a href="nastaveni.php" class="list-group-item <?php if($page == 'nastaveni.php'){ echo 'active';}?> list-group-item-action waves-effect">
            <i class="fas fa-wrench mr-3" style="width: 15px;text-align: center;"></i>Nastavení
        </a>
        <div class="list-group-item list-group-item-action waves-effect" style="border-bottom: 1px solid rgba(0,0,0,.125);padding-bottom: 0;">
            <div class="row" style="padding: 0;margin-top: -10px;">
                <button type="submit" style="background-color: transparent;border: none;outline: none;width: 50px;margin-right: -4px;" name="searchOrder">
                    <i class="fas fa-search" style="color: #495057;"></i>
                </button>
                <div class="md-form" style="margin: 0;padding: 0;">
                    <input name="searchField" type="search" style="border: none;background-color: transparent;outline: none;font-weight: 300;" id="form1" class="form-control" placeholder="Hledat" aria-label="Hledat">
                </div>
            </div>
        </div>
    </div>
</div>