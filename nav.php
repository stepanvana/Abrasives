<script type="text/javascript">
  $( document ).ready(function() {
    $(".sliding-link").click(function(e) {
      e.preventDefault();
      var aid = $(this).attr("href");
      $('html,body').animate({scrollTop: $(aid).offset().top - 60}, 1500);
    });

    var btn = $('#button');
    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });
    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });

    $("#search").keyup(function(){
      var query = $(this).val();
      if (query !== "") {
          $.ajax({
            url: 'ajax-db-search.php',
            method: 'POST',
            data: {query:query},
            success: function(data){
              $('#output').html(data);
              $('#output').css('display', 'block');
              $('html').click(function(e) {    
                if(e.target.id == "output") {
                  $('#output').css('display', 'none');  
                }
              }); 
            }
          });
      } else {
          $('#output').css('display', 'none');
      }
    });

    $("#search").on("search", function(){
      var query = $(this).val();
      if (query !== "") {
          $.ajax({
            url: 'ajax-db-search.php',
            method: 'POST',
            data: {query:query},
            success: function(data){
              $('#output').html(data);
              $('#output').css('display', 'block');
              $('html').click(function(e) {    
                if(e.target.id == "output") {
                  $('#output').css('display', 'none');  
                }
              }); 
            }
          });
      } else {
          $('#output').css('display', 'none');
      }
    });

    $("#myBtnCart").click(function(e) { 
      e.preventDefault(); 
      $("#cartModalId").fadeIn(); 
      $("#cartModalId").html('<img src="images/ajax-loader.gif">'); 
      $("#cartModalId" ).load("show-cart.php"); 
    });

    $('html').click(function(e) {    
      if(e.target.id == "cartModalId") {
        $("#cartModalId").fadeOut(); 
      }
    });

    $('#add').on('click', function(){
      var action = 'add';
      var id = $('input[name=id]').val();
      var name = $('input[name=name]').val();
      var price = $('input[name=price]').val();
      var costs = $('input[name=costs]').val();
      var discount = $('input[name=discount]').val();
      var quantity = $('input[name=quantity]').val();
      var url = $('input[name=url]').val();
      var image = $('input[name=image]').val();
      var category = $('input[name=category]').val();
      $.ajax({
          url: 'cart-handler.php',
          method: 'POST',
          data: {action:action, id:id, name:name, price:price, costs:costs, discount:discount, quantity:quantity, url:url, image:image, category:category},
          success: function(data) {
            $('#productsInCart').html(data);
            $('input[name=quantity]').val(1);
            $('#success_msg').fadeIn().delay(10000).fadeOut();
          },
          error: function() {
            $('#error_msg').fadeIn().delay(10000).fadeOut();
          }
      });
    });

    $('#cartModalId').on('click', '#remove', function(){
      var action = 'remove';
      var id = $('input[name=removeId]').val();
      $.ajax({
          url: 'cart-handler.php',
          method: 'POST',
          data: {action:action, id:id},
          success: function(data) {
              $('#productsInCart').html(data);
              $("#cartModalId").html('<img src="images/ajax-loader.gif">'); 
              $("#cartModalId" ).load("show-cart.php"); 
          }
      });
    });

  });
</script>

<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container">
            <a class="navbar-brand waves-effect" href="http://127.0.0.1/edsa-Abrasives/www/">
                <img src="https://mdbootstrap.com/wp-content/uploads/2018/06/logo-mdb-jquery-small.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if($page == 'produkty.php'){ echo ' active"';}?>">
                        <a class="nav-link waves-effect" href="produkty">Zboží<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item <?php if($page == 'poradna.php'){ echo ' active"';}?>">
                        <a class="nav-link waves-effect" href="poradna.php">Poradna</a>
                    </li>
                    <li class="nav-item <?php if($page == 'spoluprace.php'){ echo ' active"';}?>">
                        <a class="nav-link waves-effect" href="spoluprace.php">Spolupráce</a>
                    </li>
                    <li class="nav-item <?php if($page == 'zakazka.php'){ echo ' active"';}?>">
                        <a class="nav-link waves-effect" href="zakazka.php">Zboží na zakázku</a>
                    </li>
                    <li class="nav-item <?php if($page == 'kontakt.php'){ echo ' active"';}?>">
                        <a class="nav-link waves-effect" href="kontakt">Kontakt</a>
                    </li>
                </ul>
                <ul class="navbar-nav nav-flex-icons">
                  <li class="nav-item align-middle">
                    <div class="form-inline">
                      <div class="md-form my-0 mr-4">
                        <input style="margin-top: 5px;" name="search" id="search" autocomplete="off" class="form-control form-control-sm mr-sm-2" type="search" placeholder="Hledat v obchodě ..." aria-label="Search">
                      </div>
                    </div>
                  </li>
                  <li class="nav-item <?php if($page == '/zakaznik/'){ echo ' active"';}?>">
                      <a class="nav-link waves-effect" href="zakaznik">
                        <i style="color: black;margin-right: 5px;font-size: 20px;padding-top: 10px;" class="fas fa-user align-middle"></i>
                      </a>
                  </li>
                  <li class="shoppingCartButton">
                    <a id="myBtnCart" class="nav-link waves-effect">
                      <i style="color: black;margin-right: -5px;font-size: 20px;padding-top: 10px;" class="fas fa-shopping-cart align-middle"></i>
                      <span id="productsInCart" class="badge badge-danger ml-2" style="float: right;margin-top: 3px;">
                        <?php
                        if (isset($_SESSION['shopping_cart'])) {
                          echo count($_SESSION['shopping_cart']);
                        } else {
                          echo 0;
                        }
                        ?>
                      </span>
                    </a>
                  </li>
                  <?php
                  if (isset($_SESSION['userId'])) {
                    ?>
                    <li class="shoppingCartButton">
                      <a href="logout.php" id="myBtnCart" class="nav-link waves-effect">
                        <i style="color: black;" class="fas fa-sign-out-alt"></i>
                      </a>
                    </li>
                    <?php
                  }
                  ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<a id="button" class="btn btn-primary btn-sm"><i class="fas fa-chevron-up" style="font-size: 20px;"></i></a>

<div id="cartModalId" class="cartModal" style="z-index: 100;">

</div>