<?php
include 'header.php';
include 'nav.php';
?>

<main class="text-center" style="margin-top: 150px;">

  <div class="content">

  <div class="container my-5 py-3 z-depth-1 rounded">
    <section class="dark-grey-text">
      <div class="table-responsive"> <?php
        if(!empty($_SESSION['shopping_cart'])) { ?>
        <table class="table product-table mb-0">
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
              <form method="POST" action="">
                <tr>
                  <th scope="row text-left">
                    <a href="produkt/<?php echo $product['id']; ?>/<?php echo $product['url']; ?>"><img src="images/<?php echo $product['image']; ?>" alt="" class="img-fluid z-depth-0" style="width: 100px;"></a>
                  </th>
                  <td>
                    <h5 class="mt-3">
                      <strong><a href="produkt/<?php echo $product['id']; ?>/<?php echo $product['url']; ?>"><?php echo $product['name']; ?></a></strong>
                    </h5>
                    <p class="text-muted"><?php echo $product['category']; ?></p>
                  </td>
                  <td>
                    <input type="number" name="quantity" value="<?php echo $product['quantity'] ?>" min=1 aria-label="Search" class="form-control" style="width: 100px">
                  </td>
                  <td><?php echo $product['price']; ?></td>
                  <td class="font-weight-bold">
                    <strong><?php echo number_format($product['quantity']*$product['price'],2); ?></strong>
                  </td>
                  <td>
                    <button type="submit" name="change_ammount" class="btn btn-sm btn-success" value="<?php echo $product['id'] ?>">+</button>
                    <input type="hidden" name="removeId" value="<?php echo $product['id']; ?>">
                    <button name="remove" type="submit" class="btn btn-sm btn-danger white-text" data-toggle="tooltip" data-placement="top" title="Remove item">
                      X
                    </button>
                  </td>
                </tr>  
              </form>
              
              <?php
              $total = $total + ($product['quantity'] * $product['price']);
            } ?>

              <tr>
                <td></td>
                <td colspan="2" class="text-right">
                  <h4 class="mt-2">
                    <strong>Celkem <?php echo number_format($total, 2); ?> Kč</strong>
                  </h4>
                </td>
                <td colspan="3" class="text-right">
                  <button type="button" class="btn btn-primary btn-rounded">
                    <a href='order' style="color: white;">Dokončit objednávku
                    <i class="fas fa-angle-right right"></i></a>
                  </button>
                </td>
              </tr>

          </tbody>
        </table>
        <?php
        } else {
          ?>
          <div style="margin: 30px;padding: 50px;background-color: #ecf5fe;">
            <div style="float: left;">
              <label>Košík je prázdný</label>
            </div>
            <div style="float: right;">
              <a href="produkty"><label style="text-align: right;">Zobrazit zboží</label></a>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
    </section>
  </div>
</div>

