<div class="row wow fadeIn">
	<div class="col-lg-3 col-md-12 mb-4">
        <div class="card mt-3">
          	<div class="">
            	<i class="far fa-money-bill-alt fa-lg primary-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
            	<div class="float-right text-right p-3">
              		<p class="text-uppercase text-muted mb-1"><small>Celková tržba</small></p>
              		<h4 class="font-weight-bold mb-0"><?php echo number_format(array_sum(array_column($dataArray, 'income')), 1); ?> Kč</h4>
            	</div>
          	</div>
	        <div class="card-body pt-0">
	            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
	            	<?php 
					if ($compareWeeks['compareIncomes'] > 0) {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareIncomes']."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} elseif ($compareWeeks['compareIncomes'] < 0) {
						echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareIncomes']*(-1)."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} else {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					}
					?>
	            </div>
	            <p class="card-text">
	            	<?php 
					if ($compareWeeks['compareIncomes'] > 0) {
						echo "O " . number_format($compareWeeks['compareIncomes']) . "% více tržeb než minulý týden.";
					} elseif ($compareWeeks['compareIncomes'] < 0) {
						echo "O " . number_format($compareWeeks['compareIncomes']*(-1)) . "% méně tržeb než minulý týden.";
					} else {
						echo "Stejný počet tržeb jako minulý týden.";
					}
					?>
		        </p>
	        </div>
	    </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card mt-3">
          	<div class="">
            	<i class="fas fa-search-dollar fa-lg warning-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
            	<div class="float-right text-right p-3">
              		<p class="text-uppercase text-muted mb-1"><small>Celkové zisky</small></p>
              		<h4 class="font-weight-bold mb-0"><?php echo number_format(array_sum(array_column($dataArray, 'earnings')), 1); ?> Kč</h4>
            	</div>
          	</div>
          	<div class="card-body pt-0">
	            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
	            	<?php 
					if ($compareWeeks['compareEarnings'] > 0) {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareEarnings']."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} elseif ($compareWeeks['compareEarnings'] < 0) {
						echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareEarnings']*(-1)."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} else {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					}
					?>
	            </div>
	            <p class="card-text">
	            	<?php
					if ($compareWeeks['compareEarnings'] > 0) {
						echo "O " . number_format($compareWeeks['compareEarnings']) . "% více zisků než minulý týden.";
					} elseif ($compareWeeks['compareEarnings'] < 0) {
						echo "O " . number_format($compareWeeks['compareEarnings']*(-1)) . "% méně zisků než minulý týden.";
					} else {
						echo "Stejný počet zisků jako minulý týden.";
					}
					?>
		        </p>
	        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card mt-3">
          	<div class="">
            	<i class="fas fa-chart-line fa-lg light-blue z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
            	<div class="float-right text-right p-3">
              		<p class="text-uppercase text-muted mb-1"><small>Celkový počet objednávek</small></p>
              		<h4 class="font-weight-bold mb-0"><?php echo number_format(array_sum(array_column($dataArray, 'numberOrders'))); ?></h4>
            	</div>
          	</div>
          	<div class="card-body pt-0">
	            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
	            	<?php 
					if ($compareWeeks['compareOrders'] > 0) {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareOrders']."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} elseif ($compareWeeks['compareOrders'] < 0) {
						echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareOrders']*(-1)."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} else {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					}
					?>
	            </div>
	            <p class="card-text">
	            	<?php 
					if ($compareWeeks['compareOrders'] > 0) {
						echo "O " . number_format($compareWeeks['compareOrders']) . "% více objednávek než minulý týden.";
					} elseif ($compareWeeks['compareOrders'] < 0) {
						echo "O " . number_format($compareWeeks['compareOrders']*(-1)) . "% méně objednávek než minulý týden.";
					} else {
						echo "Stejný počet objednávek jako minulý týden.";
					}
					?>
		        </p>
	        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card mt-3">
          	<div class="">
            	<i class="far fa-handshake fa-lg red z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
            	<div class="float-right text-right p-3">
              		<p class="text-uppercase text-muted mb-1"><small>Průměrná tržba na objednávku</small></p>
              		<h4 class="font-weight-bold mb-0">
              			<?php 
              			if (count($dataArray) > 0) {
              				echo number_format(array_sum(array_column($dataArray, 'income'))/count($dataArray), 1); 
              			} else {
              				echo "0";
              			}
              			?> Kč
              		</h4>
            	</div>
          	</div>
          	<div class="card-body pt-0">
	            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
	            	<?php 
					if ($compareWeeks['compareAvarage'] > 0) {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareAvarage']."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} elseif ($compareWeeks['compareAvarage'] < 0) {
						echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareAvarage']*(-1)."%;max-width: 100%;' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					} else {
						echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
					}
					?>
	            </div>
	            <p class="card-text">
	            	<?php 
					if ($compareWeeks['compareAvarage'] > 0) {
						echo "O " . number_format($compareWeeks['compareAvarage']) . "% více průměrných tržeb než minulý týden.";
					} elseif ($compareWeeks['compareAvarage'] < 0) {
						echo "O " . number_format($compareWeeks['compareAvarage']*(-1)) . "% méně průměrných tržeb než minulý týden.";
					} else {
						echo "Stejný počet průměrných tržeb jako minulý týden.";
					}
					?>
		        </p>
	        </div>
        </div>
    </div>
</div>