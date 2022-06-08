<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$dataArray = $statisticsObj->showDataByDate(NULL, NULL);
	$compareWeeks = $statisticsObj->compareTwoWeeks();
	//Filter
	if (!empty($_GET['dataOrderRange'])) {
		$graphDataArray = $statisticsObj->showDateProducts($_GET['dataOrderRange'], date('Y-m-d', strtotime(' +1 day')));
		$graphIdArray = $statisticsObj->showIdProducts($_GET['dataOrderRange'], date('Y-m-d', strtotime(' +1 day')));
		$dateRange = $_GET['dataOrderRange'];
	} elseif (!empty($_GET['specificDateStart']) && !empty($_GET['specificDateEnd'])) {
		$graphDataArray = $statisticsObj->showDateProducts($_GET['specificDateStart'], $_GET['specificDateEnd']);
		$graphIdArray = $statisticsObj->showIdProducts($_GET['specificDateStart'], $_GET['specificDateEnd']);
		$dateRange = strtotime($_GET['specificDateEnd']) - strtotime($_GET['specificDateStart']);
		$dateRange = round($dateRange / (60*24*24));
	} else {
		$graphDataArray = $statisticsObj->showDateProducts(NULL, NULL);
		$graphIdArray = $statisticsObj->showIdProducts(NULL, NULL);
		if (!empty($graphDataArray)) {
			$dateRange = time() - strtotime(min(array_column($graphDataArray, 'order_date')));
			$dateRange = round($dateRange / (60 * 60 * 24));
			if ($dateRange == 0) {
				$dateRange = $dateRange + 1;
			}
		} else {
			$dateRange = 0;
		}
	}
	if (empty($graphDataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	if (empty($dataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	//Proměnná pro sečtení všech zisků
	$totalEarnings = 0;

	include '../admin/headerAdmin.php';

	?>

	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		google.charts.setOnLoadCallback(drawPieChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
					['Datum', 'Kusů'],
					<?php
					foreach ($graphDataArray as $graph) {
						echo "['".$graph["dayGraph"].".".$graph["monthGraph"].".', ".$graph["sumProducts"]."],";
					}
					?>
				]);
			var options = {
					titleTextStyle: {color: 'white', fontSize: '20'},
					hAxis: {title: 'Datum',  titleTextStyle: {color: 'white'}, textStyle: {color: 'white'}},
					vAxis: {title: 'Kč',  titleTextStyle: {color: 'white'},minValue: 0, textStyle: {color: 'white'}, gridlines: {color: 'white'}, baselineColor: 'white'},
					backgroundColor: 'transparent',
					colors:['white','rgb(255,255,255,.5)'],
					legend: {textStyle: {color: 'white'}}
		        };
		    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
  			chart.draw(data, options);
		}

		function drawPieChart() {
			var data = google.visualization.arrayToDataTable([
					['Produkt', 'Kusů'],
					<?php
					foreach ($graphIdArray as $graph) {
						echo "['".$graph["product_name"]."', ".$graph["sumProducts"]."],";
					}
					?>
				]);
			var options = {
					titleTextStyle: {color: 'black', fontSize: '20'},
					hAxis: {title: 'Datum',  titleTextStyle: {color: 'black'}, textStyle: {color: 'black'}},
					vAxis: {title: 'Kč',  titleTextStyle: {color: 'black'},minValue: 0, textStyle: {color: 'black'}, gridlines: {color: 'black'}, baselineColor: 'black'},
					backgroundColor: 'transparent',
					legend: {textStyle: {color: 'black'}}
		        };
		    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
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
    		<blockquote class="blockquote bq-primary" style="margin-top: 6%;">
			  	<p class="bq-title">Celková data</p>
			  	<p>Analýza dat za celé období existence obchodu.</p>
			</blockquote>
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
			include 'includes/statistics-overall.inc.php';
			?>
		    <blockquote class="blockquote bq-primary" style="margin-top: 3%;">
			  	<p class="bq-title">Filtrovaná data</p>
			  	<p>Analýza dat za období definované uživatelem.</p>
			</blockquote>
			<div class="row wow fadeIn" style="margin: 2% 0 2% 0">
		    	<div class="col-md-12">
			        <div class="row">
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-box-open fa-lg primary-color z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Prodaných kusů</small></p>
									<h5 class="mb-0"><?php echo array_sum(array_column($graphIdArray, 'sumProducts')); ?></h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-chart-bar fa-lg warning-color z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Počet kusů na objednávku</small></p>
									<h5 class="mb-0">
										<?php 
										if (array_sum(array_column($graphDataArray, 'totalOrders')) !== 0) {
											echo number_format(array_sum(array_column($graphIdArray, 'sumProducts'))/array_sum(array_column($graphDataArray, 'totalOrders')), 1); 
										} else {
											echo "0";
										}
										?>
									</h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-chart-pie fa-lg light-blue z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Průměrná cena produktu</small></p>
									<h5 class="mb-0">
										<?php 
										if (array_sum(array_column($graphIdArray, 'sumProducts')) !== 0) {
											echo number_format(array_sum(array_column($graphIdArray, 'income'))/array_sum(array_column($graphIdArray, 'sumProducts')), 1); 
										} else {
											echo "0";
										}
										?> Kč
									</h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-calendar-day fa-lg red z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Průměr prodaných kusů na den</small></p>
									<h5 class="mb-0">
										<?php 
										if ($dateRange !== 0) {
											echo number_format(array_sum(array_column($graphDataArray, 'sumProducts'))/$dateRange, 1);  
										} else {
											echo "0";
										}
										?>
									</h5>
								</div>
							</div>		
			        	</div>
			        </div>
		        </div>
		    </div>
			<div class="row wow fadeIn">
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
										<option selected value="">---</option>
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
		        </div>
		        <div class="col-md-8 mb-4">
		          	<div class="card">
		          		<div class="card-header text-center">
		              		Prodané kusy
		            	</div>
		            	<div class="card-body indigo">
		              		<div id="chart_div" class="chartArea"></div>
		            	</div>
		          	</div>
		        </div>
		    </div>
		    <div class="row wow fadeIn" style="margin-bottom: 6%;">
		        <div class="col-md-12 mb-4">
		          	<div class="card">
		          		<div class="card-header text-center">
		              		Nejprodávanější produkty
		            	</div>
		            	<div class="card-body">
		            		<div class="row">
			            		<div class="col-md-6">
			            			<div id="pie_chart_div" class="chartArea"></div>
			            		</div>
			            		<div class="col-md-6">
			            			<table class="table">
			            				<thead>
			            					<tr>
			            						<th>
			            							Produkt
			            						</th>
			            						<th>
			            							Kód produktu
			            						</th>
			            						<th>
			            							Prodáno kusů
			            						</th>
			            						<th>
			            							Cena kusu
			            						</th>
			            						<th>
			            							Tržba z produktu
			            						</th>
			            					</tr>
			            				</thead>
			            				<tbody>
		            						<?php
		            						foreach ($graphIdArray as $rowId) {
		            							?>
												<tr>
			            							<td>
			            								<?php echo $rowId['product_name']; ?>
			            							</td>
			            							<td>
			            								<?php echo $rowId['product_code']; ?>
			            							</td>
			            							<td>
			            								<?php echo $rowId['sumProducts']; ?>
			            							</td>
			            							<td>
			            								<?php echo $rowId['price']; ?> Kč
			            							</td>
			            							<td>
			            								<?php echo $rowId['sumProducts']*$rowId['price']; ?> Kč
			            							</td>
		            							</tr>
		            							<?php
		            						}
		            						?>
			            				</tbody>
			            			</table>
			            		</div>	
		            		</div>
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