<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$dataArray = $statisticsObj->showDataByDate(NULL, NULL);
	$compareWeeks = $statisticsObj->compareTwoWeeks();
	//Filter
	if (!empty($_GET['dataOrderRange'])) {
		$graphDataArray = $statisticsObj->showDataOrders($_GET['dataOrderRange'], date('Y-m-d', strtotime(' +1 day')));
		$filterDataArray = $statisticsObj->showDataByDate($_GET['dataOrderRange'], date('Y-m-d', strtotime(' +1 day')));
		if (!empty($graphDataArray)) {
			$dailyIncome = array_sum(array_column($graphDataArray, 'total'))/$_GET['dataOrderRange'];
			$dailyEarnings = array_sum(array_column($graphDataArray, 'earnings'))/$_GET['dataOrderRange'];
		} else {
			$dailyIncome = 0;
			$dailyEarnings = 0;
		}
	} elseif (!empty($_GET['specificDateStart']) && !empty($_GET['specificDateEnd'])) {
		$graphDataArray = $statisticsObj->showDataOrders($_GET['specificDateStart'], $_GET['specificDateEnd']);
		$filterDataArray = $statisticsObj->showDataByDate($_GET['specificDateStart'], $_GET['specificDateEnd']);
		if (!empty($graphDataArray)) {
			$dateRange = strtotime($_GET['specificDateEnd']) - strtotime($_GET['specificDateStart']);
			$dateRange = round($dateRange / (60*24*24));
			$dailyIncome = array_sum(array_column($graphDataArray, 'total'))/$dateRange;
			$dailyEarnings = array_sum(array_column($graphDataArray, 'earnings'))/$dateRange;		
		} else {
			$dailyIncome = 0;
			$dailyEarnings = 0;
		}	
	} else {
		$graphDataArray = $statisticsObj->showDataOrders(NULL, NULL);
		$filterDataArray = $statisticsObj->showDataByDate(NULL, NULL);
		if (!empty($graphDataArray)) {
			$dateRange = time() - strtotime(min(array_column($graphDataArray, 'order_date')));
			$dateRange = round($dateRange / (60 * 60 * 24));
			if ($dateRange == 0) {
				$dateRange = $dateRange + 1;
			}
			$dailyIncome = array_sum(array_column($graphDataArray, 'total'))/$dateRange;
			$dailyEarnings = array_sum(array_column($graphDataArray, 'earnings'))/$dateRange;	
		} else {
			$dailyIncome = 0;
			$dailyEarnings = 0;
		}	
	}
	if (empty($graphDataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	if (empty($dataArray)) {
		$graphDataArray = array(array("income"=>"0", "numberOrders"=>"0", "earnings"=>"0"));
	}
	//Prom??nn?? pro se??ten?? v??ech zisk??
	$totalEarnings = 0;

	include '../admin/headerAdmin.php';

	?>

	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawAnthonyChart);

  		function drawAnthonyChart() {
			var data = google.visualization.arrayToDataTable([
					['Datum', 'Objedn??vky', 'Stornovan??'],
					<?php
					foreach ($graphDataArray as $graph) {
						$monthNum  = $graph["month"];
						$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
						echo "['". $graph["day"] . ". " . $monthName."', ".$graph["total"]."," . $graph["totalStorno"] . "],";
					}
					?>
				]);
			var options = {
					hAxis: {title: 'M??s??c',  titleTextStyle: {color: 'white'}, textStyle: {color: 'white'}},
					vAxis: {title: 'Po??et',  titleTextStyle: {color: 'white'},minValue: 0, textStyle: {color: 'white'}, gridlines: {color: 'white'}, baselineColor: 'white'},
					backgroundColor: 'transparent',
					colors:['white','red'],
					legend: {textStyle: {color: 'white'}}
		        };
		    var chart = new google.visualization.AreaChart(document.getElementById('chart_div_orders'));
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
				              	<a class="nav-link waves-effect" href="prehled.php" target="_blank">P??ehled</a>
				            </li>
				            <li class="nav-item <?php if($page == 'objednavky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="objednavky.php" target="_blank">Objedn??vky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty.php" target="_blank">Produkty</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-ceny.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-ceny.php" target="_blank">Ceny produkt??</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-sklad.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-sklad.php" target="_blank">Sklad produkt??</a>
				            </li>
				            <li class="nav-item <?php if($page == 'novy-produkt.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="novy-produkt.php" target="_blank">Nov?? produkt</a>
				            </li>
				            <li class="nav-item <?php if($page == 'zakaznici.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="zakaznici.php" target="_blank">Z??kazn??ci</a>
				            </li>
				            <li class="nav-item <?php if($page == 'statistiky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="statistiky.php" target="_blank">Statistiky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'contact-messages.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="contact-messages.php" target="_blank">Zpr??vy</a>
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
			  	<p class="bq-title">Celkov?? data</p>
			  	<p>Anal??za dat za cel?? obdob?? existence obchodu.</p>
			</blockquote>
			<?php
			if (isset($_GET['error']) && $_GET['error'] == 'get_data') {
				?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  	<strong>Nepoda??ilo se z??skat data!</strong> Pokud probl??m setrv??v?? kontaktujte spr??vce webu.
				  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    	<span aria-hidden="true">&times;</span>
				  	</button>
				</div>
				<?php
			}
			include 'includes/statistics-overall.inc.php';
			?>
		    <blockquote class="blockquote bq-primary" style="margin-top: 3%;">
			  	<p class="bq-title">Filtrovan?? data</p>
			  	<p>Anal??za dat za obdob?? definovan?? u??ivatelem.</p>
			</blockquote>
			<div class="row" style="margin: 2% 0 0 0">
		    	<div class="col-md-12">
			        <div class="row">
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-chart-line fa-lg primary-color z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Po??et objedn??vek</small></p>
									<h5 class="mb-0"><?php echo array_sum(array_column($graphDataArray, 'total')); ?></h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-chart-pie fa-lg warning-color z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Pr??m??rn?? cena objedn??vky</small></p>
									<h5 class="mb-0">
										<?php 
										if (array_sum(array_column($graphDataArray, 'total')) !== 0) {
											echo number_format(array_sum(array_column($filterDataArray, 'income'))/array_sum(array_column($graphDataArray, 'total')), 1); 
										} else {
											echo "0";
										}
										?> K??
									</h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-calendar-day fa-lg light-blue z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Denn?? po??et objedn??vek</small></p>
									<h5 class="mb-0"><?php echo number_format($dailyIncome, 1); ?></h5>
								</div>
							</div>		
			        	</div>
			        	<div class="col-lg-3 col-md-12 mb-4">
					        <div class="media white z-depth-1 rounded">
								<i class="fas fa-box-open fa-lg red z-depth-1 p-4 rounded-left text-white mr-3"></i>
								<div class="media-body p-1">
									<p class="text-uppercase text-muted mb-1"><small>Po??et kus?? na objedn??vku</small></p>
									<h5 class="mb-0">
										<?php 
										if (array_sum(array_column($graphDataArray, 'total')) !== 0) {
											echo number_format(array_sum(array_column($filterDataArray, 'quantity'))/array_sum(array_column($graphDataArray, 'total'))); 
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
			<div class="row wow fadeIn" style="margin-bottom: 6%;">
				<div class="col-md-12 mb-4">
					<?php
					if (isset($_GET['error'])) {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>????dn?? data ve v??b??ru!</strong> Ve zvolen??m rozsahu dat se nenach??z?? ????dn?? objedn??vky, pros??m vyberte jin?? rozsah.
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
										<option selected value="">---</option>
										<option value="1">1 den</option>
					                    <option value="2">2 dny</option>
					                    <option value="7">7 dn??</option>
					                    <option value="30">30 dn??</option>
					                    <option value="365">365 dn??</option>
									</select>
		          					<h2 style="font-size: 18px;font-weight: 100;text-transform: uppercase;margin-top: 30px;text-align: center;">
		          						Specifick?? rozsah
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
		          			Objedn??vky
		          		</div>
		            	<div class="card-body indigo">
		              		<div id="chart_div_orders" class="chartArea"></div>
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