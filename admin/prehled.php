<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$totalDataArray = $statisticsObj->showDataByDate(NULL, NULL);
	//Filtr
	if (!empty($_GET['dataOrderRange'])) {
		$graphDataArray = $statisticsObj->showDataByDate($_GET['dataOrderRange'], date('Y-m-d', strtotime(' +1 day')));
	} elseif (!empty($_GET['specificDateStart']) && !empty($_GET['specificDateEnd'])) {
		$graphDataArray = $statisticsObj->showDataByDate($_GET['specificDateStart'], $_GET['specificDateEnd']);
	} else {
		$graphDataArray = $statisticsObj->showDataByDate(NULL, NULL);
	}
	//Celkem ve filtru
	$totalIncome = array_sum(array_column($graphDataArray, 'income'));
	$countRange = array_sum(array_column($graphDataArray, 'numberOrders'));
	if ($countRange !== 0) {
		$avarageIncome = $totalIncome/$countRange;
	} else {
		$avarageIncome = 0;
	}	
	//Denní příjem
	if (!empty($graphDataArray)) {
		$now = time();
		$myDate = strtotime(min(array_column($graphDataArray, 'order_date')));
		$dailyIncome = $now - $myDate;
		$dailyIncome = round($dailyIncome / (60 * 60 * 24));
		if ($dailyIncome == 0) {
			$dailyIncome = $dailyIncome + 1;
		}
		$dailyIncome = $totalIncome / $dailyIncome;	
	} else {
		$dailyIncome = 0;
	}
	if (empty($graphDataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	if (empty($totalDataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	
		
	//Porovnání tohoto a minulého týdne
	$compareWeeks = $statisticsObj->compareTwoWeeks();
	//Posledních 5 objednávek
	$lastFiveOrders = $statisticsObj->showLatestOrders();

	include '../admin/headerAdmin.php';

	?>

	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
					['Datum', 'Tržba'],
					<?php
					foreach ($graphDataArray as $rowGraph) {
						echo "['".$rowGraph["dayGraph"].".".$rowGraph["monthGraph"].".', ".$rowGraph["income"]."],";
					}
					?>
				]);
			var options = {
					hAxis: {title: 'Datum',  titleTextStyle: {color: 'black'}, textStyle: {color: 'black'}},
					vAxis: {title: 'Kč',  titleTextStyle: {color: 'black'},minValue: 0, textStyle: {color: 'black'}, gridlines: {color: '#999'}, baselineColor: '#999'},
					backgroundColor: 'rgba(0, 137, 132, .2)',
					colors:['#007bff'],
					legend: {textStyle: {color: '#999'}}
		        };
		    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
  			chart.draw(data, options);
		}
	</script>


	<header>
    	<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      		<div class="container-fluid">
        		<a class="navbar-brand waves-effect" href="https://mdbootstrap.com/docs/jquery/" target="_blank">
          			<strong class="blue-text">MDB</strong>
        		</a>
        		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          			<span class="navbar-toggler-icon"></span>
        		</button>
        		<div class="collapse navbar-collapse" id="navbarSupportedContent">
          			<!-- Left -->
          			<ul class="navbar-nav mr-auto">
          				<div id="asd">
				            <li class="nav-item <?php if($page == 'prehled.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="prehled.php" target="_blank">Přehled</a>
				            </li>
				            <li class="nav-item <?php if($page == 'objednavky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="objednavky.php" target="_blank">Objednávky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty.php" target="_blank">Produkty</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-ceny.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-ceny.php" target="_blank">Ceny produktů</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-sklad.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-sklad.php" target="_blank">Sklad produktů</a>
				            </li>
				            <li class="nav-item <?php if($page == 'novy-produkt.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="novy-produkt.php" target="_blank">Nový produkt</a>
				            </li>
				            <li class="nav-item <?php if($page == 'zakaznici.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="zakaznici.php" target="_blank">Zákazníci</a>
				            </li>
				            <li class="nav-item <?php if($page == 'statistiky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="statistiky.php" target="_blank">Statistiky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'contact-messages.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="contact-messages.php" target="_blank">Zprávy</a>
				            </li>
          				</div>
          			</ul>
		          	<!-- Right -->
		          	<ul class="navbar-nav nav-flex-icons">
			            <li class="nav-item">
				            <a href="order-create.php">
				                <button type="button" class="btn btn-outline-info btn-md waves-effect">Nová objednávka</button>
				            </a>
			            </li>
			            <li class="nav-item">
				            <a href="novy-produkt.php">
				                <button type="button" class="btn btn-outline-info btn-md waves-effect">Nový produkt</button>
				            </a>
			            </li>
			            <li class="nav-item">
				            <a href="user.php">
							  	<?php echo "<img src='../images/".$userArray['user_image']."' style='margin-right: -20px;margin-left: 15px;' alt='avatar image' class='rounded-circle z-depth-0' width='50'>"; ?>
							  	<span class="badge badge-danger ml-2"><?php echo count($tasksArray); ?></span>
				            </a>
			            </li>
		          	</ul>
        		</div>
      		</div>
    	</nav>
    	<?php include 'includes/nav.inc.php'; ?>
    </header>

	<main class="pt-5 mx-lg-5">
    	<div class="container-fluid mt-5">
			<div class="row wow fadeIn">
				<div class="col-md-12 mb-4">
					<?php
					if (isset($_GET['error']) && $_GET['error'] == 'get_data') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepodařilo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					}
					?>
				</div>
		        <div class="col-md-4 mb-4">
			        <div class="card mb-4">
			            <div class="card-header text-center">
			              	Filtr
			            </div>
			            <div class="card-body text-center">
			              	<form method="GET" action="">
	          					<div style="text-align: left;width: 80%;margin: 0 auto;">
		          					<h2 style="font-size: 18px;font-weight: 100;text-transform: uppercase;text-align: center;">
		          						Rozsah dat
		          					</h2>
					                <select class="custom-select custom-select-sm" name="dataOrderRange" style="margin-top: 3%;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
										<option selected value="">Celkem</option>
										<option value="1">1 den</option>
					                    <option value="2">2 dny</option>
					                    <option value="7">7 dní</option>
					                    <option value="30">30 dní</option>
					                    <option value="365">365 dní</option>
									</select>
		          					<h2 style="font-size: 18px;font-weight: 100;text-transform: uppercase;margin-top: 30px;text-align: center;">
		          						Specifický rozsah
		          					</h2>
						            <div class="md-form">
						            	<input type="date" id="form1" class="form-control" name="specificDateStart">
						            	<label for="form1" class="" style="color: black;padding-top: 3%;">OD: </label>
						            </div>
						            <div class="md-form">
						            	<input type="date" id="form1" class="form-control" name="specificDateEnd">
						            	<label for="form1" class="" style="color: black;padding-top: 3%;">DO: </label>
						            </div>
	          					</div>
					            <button type="submit" name="filterData" class="btn btn-outline-primary waves-effect">Zobrazit</button>
					        </form>
			            </div>
			        </div>
			        <div class="card mb-4">
			        	<div class="card-header text-center">
			              	Statistiky tržeb
			            </div>
			            <div class="card-body">
			            	<div class="row">
			            		<div class="col">
			            			<h2 style="font-size: 14px;font-weight: 600;text-transform: uppercase;margin: 20px;">
			          					Celková tržba<br>
										<label style="text-align: left;font-weight: 100;font-size: 16px;color: black;padding-top: 5px;">
											<?php echo number_format($totalIncome); ?> Kč
										</label>
									</h2>
			            		</div>
			            		<div class="col">
			            			<h2 style="font-size: 14px;font-weight: 600;text-transform: uppercase;margin: 20px;">
			          					Počet objednávek<br>
										<label style="text-align: left;font-weight: 100;font-size: 16px;color: black;padding-top: 5px;">
											<?php echo number_format($countRange); ?>
										</label>
									</h2>	
			            		</div>
			            	</div>
			            	<div class="row">
			            		<div class="col">
			            			<h2 style="font-size: 14px;font-weight: 600;text-transform: uppercase;margin: 20px;">
			          					Průměrná tržba<br>
										<label style="text-align: left;font-weight: 100;font-size: 16px;color: black;padding-top: 5px;">
											<?php echo number_format($avarageIncome); ?> Kč
										</label>
									</h2>
			            		</div>
			            		<div class="col">
			            			<h2 style="font-size: 14px;font-weight: 600;text-transform: uppercase;margin: 20px;">
			          					Denní tržba<br>
										<label style="text-align: left;font-weight: 100;font-size: 16px;color: black;padding-top: 5px;">
											<?php echo number_format($dailyIncome); ?> Kč
										</label>
									</h2>	
			            		</div>
			            	</div>
			            </div>
			        </div>
		        </div>
		        <div class="col-md-8 mb-4">
		          	<div class="card">
		          		<div class="card-header text-center">
		          			Graf tržeb
		          		</div>
		            	<div class="card-body">
		              		<div id="chart_div" class="chartArea"></div>
		            	</div>
		          	</div>
		        </div>
		    </div>
		    <div class="row wow fadeIn">
		        <div class="col-lg-4 col-md-6 mb-4">
			        <div class="card mt-3">
			          	<div class="">
			            	<i class="fas fa-chart-line fa-lg primary-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
			            	<div class="float-right text-right p-3">
			              		<p class="text-uppercase text-muted mb-1"><small>Celkový počet objednávek</small></p>
			              		<h4 class="font-weight-bold mb-0"><?php echo array_sum(array_column($totalDataArray, 'numberOrders')); ?></h4>
			            	</div>
			          	</div>
			          	<div class="card-body pt-0">
				            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
				            	<?php 
				            	if (empty($compareWeeks['compareOrders'])) {
									echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
								} else {
									if ($compareWeeks['compareOrders'] > 0) {
										echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareOrders']."%;max-width: 100%;' aria-valuenow='".$compareWeeks['compareOrders']."' aria-valuemin='0' aria-valuemax='100'></div>";
									} elseif ($compareWeeks['compareOrders'] < 0) {
										echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareOrders']*(-1)."%;max-width: 100%;' aria-valuenow='".$compareWeeks['compareOrders']."' aria-valuemin='0' aria-valuemax='100'></div>";
									} else {
										echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
									}	
								}
								?>
				            </div>
				            <p class="card-text">
				            	<?php
				            	if (empty($compareWeeks['compareOrders'])) {
									echo "Nepodařilo se získat data k porovnání.";
								} else {
									if ($compareWeeks['compareOrders'] > 0) {
										echo "O " . number_format($compareWeeks['compareOrders']) . "% více objednávek než minulý týden.";
									} elseif ($compareWeeks['compareOrders'] < 0) {
										echo "O " . number_format($compareWeeks['compareOrders']*(-1)) . "% méně objednávek než minulý týden.";
									} else {
										echo "Stejný počet objednávek jako minulý týden.";
									}	
								}
								?>
					        </p>
				        </div>
			        </div>
			    </div>
		        <div class="col-lg-4 col-md-6 mb-4">
			        <div class="card mt-3">
			          	<div class="">
			            	<i class="far fa-money-bill-alt fa-lg warning-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
			            	<div class="float-right text-right p-3">
			              		<p class="text-uppercase text-muted mb-1"><small>Celková tržba</small></p>
			              		<h4 class="font-weight-bold mb-0"><?php echo number_format(array_sum(array_column($totalDataArray, 'income')), 1); ?> Kč</h4>
			            	</div>
			          	</div>
				        <div class="card-body pt-0">
				            <div class="progress md-progress" style="height: 5px!important;margin: 15px 0 15px 0;">
				            	<?php
				            	if (empty($compareWeeks['compareIncomes'])) {
									echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
								} else {
									if ($compareWeeks['compareIncomes'] > 0) {
										echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$compareWeeks['compareIncomes']."%;max-width: 100%;' aria-valuenow='".$compareWeeks['compareIncomes']."' aria-valuemin='0' aria-valuemax='100'></div>";
									} elseif ($compareWeeks['compareIncomes'] < 0) {
										echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$compareWeeks['compareIncomes']*(-1)."%;max-width: 100%;' aria-valuenow='".$compareWeeks['compareIncomes']*(-1)."' aria-valuemin='0' aria-valuemax='100'></div>";
									} else {
										echo "<div class='progress-bar bg-success' role='progressbar' style='width: 0%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>";
									}	
								}
								
								?>
				            </div>
				            <p class="card-text">
				            	<?php
				            	if (empty($compareWeeks['compareIncomes'])) {
									echo "Nepodařilo se získat data k porovnání.";
								} else {
									if ($compareWeeks['compareIncomes'] > 0) {
										echo "O " . number_format($compareWeeks['compareIncomes']) . "% více tržeb než minulý týden.";
									} elseif ($compareWeeks['compareIncomes'] < 0) {
										echo "O " . number_format($compareWeeks['compareIncomes']*(-1)) . "% méně tržeb než minulý týden.";
									} else {
										echo "Stejný počet tržeb jako minulý týden.";
									}	
								}
								?>
					        </p>
				        </div>
				    </div>
			    </div>
			    <div class="col-lg-4 col-md-12 mb-4">
			        <div class="card mt-3">
			          	<div class="">
			            	<i class="far fa-calendar-alt fa-lg light-blue z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
			            	<div class="float-right text-right p-3">
			              		<p class="text-uppercase text-muted mb-1"><small>Pět nejnovějších objednávek</small></p>
			            	</div>
			          	</div>
			          	<div class="card-body pt-0" style="margin-top: 30px;">
				            <table style="width: 90%;margin: 0 auto;">
								<thead>
									<th style="width: 30%;">
										Objednávka
									</th>
									<th style="width: 25%;">
										Stav
									</th>
									<th style="width: 20%;">
										Cena
									</th>
								</thead>
								<tbody>
									<?php
									if (empty($lastFiveOrders)) {
										?>
										<tr>
											<td class="tdBody">
												Žádné aktuální objednávky
											</td>
											<td class="tdBody"></td>
											<td class="tdBody"></td>
										</tr>
										<?php
									} elseif ($lastFiveOrders == false) {
										?>
										<tr>
											<td class="tdBody">
												Došlo k chybě, kontaktujte správce webu.
											</td>
											<td class="tdBody"></td>
											<td class="tdBody"></td>
										</tr>
										<?php
									} else {
										foreach ($lastFiveOrders as $rowLatestRecords) { ?>
											<tr>
												<td class="tdBody">
													<a style="color: #557ff9;font-weight: 500;" href="detail-objednavky.php?id=<?php echo $rowLatestRecords['order_id']; ?>">
														<?php echo $rowLatestRecords['order_code'];?>
													</a><br>
													<p style="font-size: 14px; color: #9e9e9e;margin: 0;padding: 0;">
														<?php echo date("d.m.Y H:i:s", strtotime($rowLatestRecords['order_date'])); ?>
													</p>
												</td>
												<td class="tdBody">
													<?php echo $rowLatestRecords['condition_condition']; ?>
												</td>
												<td class="tdBody" style="font-weight: 400;">
													<?php echo $rowLatestRecords['payment_amount']; ?> Kč
												</td>
											</tr> <?php
										}	
									}
									?>		
								</tbody>
							</table>
				        </div>
			        </div>
			    </div>
		    </div>
    	</div>
    </main>

	<?php
	include 'footer.php';

} else {

	header("Location: ../index.php");
}
?>