<?php
session_start();
?>
  <div class="cartModal-content">
    <div class="cartModal-body" style="padding-top: 20px;">
      <div id="cart" class="table-responsive">
        <?php
          if(!empty($_SESSION['shopping_cart'])) {
            ?>
            <table class="table">
              <thead class="mdb-color lighten-5">
                <tr>
                  <th style="width: 30%;"></th>
                  <th style="width: 20%;" class="font-weight-bold">
                    <strong>Produkt</strong>
                  </th>
                  <th style="width: 10%;" class="font-weight-bold">
                    <strong>Počet</strong>
                  </th>
                  <th style="width: 10%;" class="font-weight-bold">
                    <strong>Cena</strong>
                  </th>
                  <th style="width: 10%;" class="font-weight-bold">
                    <strong>Celkem</strong>
                  </th>
                  <th style="width: 15%;"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0;

                foreach ($_SESSION['shopping_cart'] as $key => $product) { ?>
                    <tr>
                      <th scope="row">
                        <a href="produkt/<?php echo $product['id']; ?>/<?php echo $product['url']; ?>"><img src="images/<?php echo $product['image']; ?>" alt="" class="img-fluid z-depth-0" style="width: 100px;"></a>
                      </th>
                      <td>
                        <h5 class="mt-3">
                          <strong><a href="produkt/<?php echo $product['id']; ?>/<?php echo $product['url']; ?>"><?php echo $product['name']; ?></a></strong>
                        </h5>
                        <p class="text-muted"><?php echo $product['category']; ?></p>
                      </td>
                      <td>
                        <?php echo $product['quantity'] ?>
                      </td>
                      <td><?php echo $product['price']; ?> Kč</td>
                      <td class="font-weight-bold">
                        <strong><?php echo number_format($product['quantity']*$product['price'],2); ?> Kč</strong>
                      </td>
                      <td>
                        <input type="hidden" name="removeId" value="<?php echo $product['id']; ?>">
                        <button id="remove" type="button" class="btn btn-sm btn-danger white-text" data-toggle="tooltip" data-placement="top" title="Remove item">
                          X
                        </button>
                      </td>
                    </tr>
                  
                  <?php
                  $total = $total + ($product['quantity'] * $product['price']);
                } ?>

                <tr>
                  <td></td>
                  <td colspan="2" class="text-right">
                    <h4 class="mt-2">
                      <strong>Celkem <?php echo $total; ?> Kč</strong>
                    </h4>
                  </td>
                  <td colspan="3" class="text-right">
                    <a href='kosik' style="color: white;">
                      <button type="button" class="btn btn-primary btn-rounded">
                      Košík
                      <i class="fas fa-angle-right right"></i>
                      </button>
                    </a>
                    <a href='order' style="color: white;">
                      <button type="button" class="btn btn-primary btn-rounded">
                      Dokončit objednávku
                      <i class="fas fa-angle-right right"></i>
                      </button>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table> <?php

          } else { ?>  
              
            <div style="margin: 30px;padding: 50px;background-color: #ecf5fe;">
              <div style="float: left;">
                <label>Košík je prázdný</label>
              </div>
              <div style="float: right;">
                <a href="produkty"><label style="text-align: right;cursor: pointer;">Zobrazit zboží</label></a>
              </div>
            </div> <?php

          } ?>

      </div>  
    </div>
  </div>