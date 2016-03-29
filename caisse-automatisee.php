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
    //classes loading end
    session_start();
    if(isset($_SESSION['user']) ){
    	if($_SESSION['user']->login()=="karim" or $_SESSION['user']->login()=="mohamed"){
			//define charges et paye des affaires managers 
			$affairesManager = new AffaireManager($pdo);
			$chargesManager = new ChargesManager($pdo);
			$cnssManager = new CnssManager($pdo);
			$comptableManager = new ComptableManager($pdo);
			$salairesManager = new SalairesManager($pdo);
			$voitureManager = new VoitureManager($pdo);
			$observationManager = new ObservationManager($pdo);
			//get all charges and paye
			$entreesKarim = 0;
			$entreesMohamed = $affairesManager->getTotalPaye();
			$sortiesKarim = 0;
			$sortiesMohamed = $chargesManager->getTotalCharges()+$cnssManager->getTotalChargesCnss()
			+$comptableManager->getTotalChargesComptable()+$salairesManager->getTotalChargesSalaires()
			+$voitureManager->getTotalChargesVoiture()+$observationManager->getTotalChargesObservation();
			//get totaux des entrees et sorties
			$entreesKarimTotal = 0;
			$entreesMohamedTotal = $entreesMohamed;
			$sortiesKarimTotal = 0;
			$sortiesMohamedTotal = $sortiesMohamed;
			//moyennes
			$moyenne = ($entreesKarimTotal + $entreesMohamedTotal)/2;

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
							Gestion de la caisse
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-money"></i>
								<a>Gérer la caisse automatisée</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span6">
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
                         <?php 
							//disabled form input process
							$disabledKarim="";
							$disabledMohamed="";
							if($_SESSION['user']->login()!="karim"){
								$disabledKarim='disabled="disabled"';
							}
							if($_SESSION['user']->login()!="mohamed"){
								$disabledMohamed='disabled="disabled"';
							}
                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Caisse de Topographie</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- Table Entrées Mohamed Begin -->
                                 <h3>Total des affaires payées</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="highlight">
												<a><?= $entreesMohamed ?> DH</a>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- Table Entrées Mohamed End -->
								<!-- Table Sorties Mohamed Begin -->
                                 <h3>Total des charges</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="highlight">
												<a><?= $sortiesMohamed ?> DH</a>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- Table Sorties Mohamed End -->
                              </div>
                           </div>
						<!-- END Charges TABLE PORTLET-->
					</div>
					<div class="span6">
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Caisse de l'Architecture</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <h3>Total des affaires payées</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="highlight">
												<a><?= $entreesKarim ?> DH</a>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- Table Entrées Karim End -->
								<!-- Table Sorties Karim Begin -->
                                 <h3>Total des charges</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="highlight">
												<a><?= $sortiesKarim ?> DH</a>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- Table Sorties Karim End -->
                              </div>
                           </div>
						<!-- END Charges TABLE PORTLET-->
					</div>
					<!-- ############## Les totaux et les moyennes Begin ############## -->
					 <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Total et moyenne Affaires payées/Charges</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                              	<div class="row-fluid">
	                              	<label class="span6">Total des affaires payées - charges (Topographie)</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $entreesMohamed-$sortiesMohamed ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Total des affaires payées - charges (Architecture)</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $entreesKarim-$sortiesKarim ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne des affaires payées Architecture/Topographie</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne - Charges Topographie</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne-$sortiesMohamedTotal ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne - Charges Architecture</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne-$sortiesKarimTotal ?>">
                              	</div>				
                              </div>
                     </div>
					<!-- ############## Les totaux et les moyennes End ############## -->
					<!-- ############## Terminer et archiver compte actuel begin ############## -->
					<a href="controller/GenererRapportCaisseAutomatiseeController.php" class="btn big red ">Générer le rapport de la caisse</a>
					<!-- ############## Terminer et archiver compte actuel end ############## -->
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
	header('Location:dashboard.php');
}
}
else{
    header('Location:index.php');    
}
?>