<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
	include('lib/pagination.php');
    //classes loading end
    session_start();
    if(isset($_SESSION['user'])){
    	//set manager classes 
		$chargesManager = new ChargesManager($pdo);
		$voituresManager = new VoitureManager($pdo);
		$cnssManager = new CnssManager($pdo);
		$salairesManager = new SalairesManager($pdo);
		$comptableManager = new ComptableManager($pdo);
		$observationManager = new ObservationManager($pdo);
		//get total
		$chargesPerPage = 10;
        $chargesNumber = $chargesManager->getChargesNumber();
        $pageNumber = ceil($chargesNumber/$chargesPerPage);
        $p = 1;
        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
            $p = $_GET['p'];
        }
        else{
            $p = 1;
        }
        $begin = ($p - 1) * $chargesPerPage;
        $charges = $chargesManager->getChargesByLimits($begin, $chargesPerPage);
        $pagination = paginate('charges.php', '?p=', $pageNumber, $p);
		        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>TopEntreprise - Management Application</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<?php include("include/top-menu.php"); ?>	
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<?php include("include/sidebar.php"); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Consultation des charges
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-bar-chart"></i>
								<a>Gestion interne</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Liste des charges</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
					<a href="printed-documents/charges-pdf.php" target="_blank" class="btn black big">
						Imprimer les charges
						<i class="icon-print"></i>
					</a>
					<br><br>
					<!-- BEGIN PAGE CONTENT-->
					<!-- BEGIN Charges TABLE PORTLET-->
						 <?php if(isset($_SESSION['charges-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['charges-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['charges-success']);
                                 ?>
						<div class="portlet box purple">
							<div class="portlet-title">
								<h4><i class="icon-shopping-cart"></i>Les charges</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Mois</th>
											<th>Eau</th>
											<th>Electr</th>
											<th>Fixe</th>
											<th>Port</th>
											<th>Net</th>
											<th>Loyer</th>
											<th>Salaire</th>
											<th>Compta</th>
											<th>Voiture</th>
											<th>CNSS</th>
											<th>Obser</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($charges as $charge){
											$totalSalaire = $salairesManager->getSalairesTotalMontantByIdCharge($charge->id())
											+$salairesManager->getSalairesTotalPrimeByIdCharge($charge->id());
											$totalComptable = $comptableManager->getComptableTotalByIdCharge($charge->id());
											$totalVoiture = $voituresManager->getVoitureTotalByIdCharge($charge->id());
											$totalCnss = $cnssManager->getCnssTotalByIdCharge($charge->id());
											$totalObservation = $observationManager->getObservationTotalByIdCharge($charge->id()); 
											$total = $charge->eau()+
											$charge->electricite()+
											$charge->fixe()+
											$charge->portable()+
											$charge->internet()+
											$charge->loyer()+
											$totalSalaire+$totalCnss+$totalComptable+$totalObservation+$totalVoiture;
											$month = date('m/Y', strtotime($charge->dateCharges())); 
											?>
										<tr>
											<td>
												<div class="btn-group">
												    <a class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $month ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li><a href="update-charges.php?idCharges=<?= $charge->id() ?>">Modifier les charges</a></li>
												        <li><a href="charges-voiture.php?idCharges=<?= $charge->id() ?>">Voiture</a></li>
												        <li><a href="charges-comptable.php?idCharges=<?= $charge->id() ?>">Comptable</a></li>
												        <li><a href="charges-salaires.php?idCharges=<?= $charge->id() ?>">Salaires</a></li>
												        <li><a href="charges-cnss.php?idCharges=<?= $charge->id() ?>">Cnss</a></li>
												        <li><a href="charges-observation.php?idCharges=<?= $charge->id() ?>">Observation</a></li>
												        <li><a href="charges-factures.php?idCharges=<?= $charge->id() ?>">Factures</a></li>
												    </ul>
												</div>	
											</td>
											<td><?= $charge->eau(); ?></td>
											<td><?= $charge->electricite() ?></td>
											<td><?= $charge->fixe() ?></td>
											<td><?= $charge->portable() ?></td>
											<td><?= $charge->internet() ?></td>
											<td><?= $charge->loyer() ?></td>
											<td>
												<?= $totalSalaire ?>
											</td>
											<td>
												<?= $comptableManager->getComptableTotalByIdCharge($charge->id()) ?>
											</td>
											<td>
												<?= $voituresManager->getVoitureTotalByIdCharge($charge->id()) ?>
											</td>
											<td>
												<?= $cnssManager->getCnssTotalByIdCharge($charge->id()) ?>
											</td>
											<td>
												<?= $observationManager->getObservationTotalByIdCharge($charge->id()) ?>
											</td>
											<td>
												<?= $total ?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
									<?= $pagination ?>
								</table>
							</div>
						</div>
						<!-- END Charges TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2014 &copy; TopEntreprise. Management Application.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>			
	<script src="assets/breakpoints/breakpoints.js"></script>			
	<script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage('calendar');
			App.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>