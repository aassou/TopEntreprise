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
	//classes managers 
	$affaireManager = new AffaireManager($pdo);
	$rendezVousManager = new RendezVousManager($pdo);
	$clientManager = new ClientManager($pdo);
	$sourceManager = new SourceManager($pdo);
	//classes
	//affaire pagination parameters and process begin
    $rendezVousPerPage = 10;
    $rendezVousNumber = $rendezVousManager->getRendezVousNumberEnCours();
    $pageNumber = ceil($rendezVousNumber/$rendezVousPerPage);
    $p = 1;
    if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
        $p = $_GET['p'];
    }
    else{
        $p = 1;
    }
    $begin = ($p - 1) * $rendezVousPerPage;
    $rendezVous = $rendezVousManager->getRendezVousEnCoursByLimits($begin, $rendezVousPerPage);
    $pagination = paginate('rendez-vous.php', '?p=', $pageNumber, $p);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
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
								Gestion des rendez-vous
							</h3>
							<ul class="breadcrumb">
								<li>
									<i class="icon-home"></i>
									<a>Accueil</a> 
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<i class="icon-briefcase"></i>
									<a>Affaires Topographes</a> 
									<i class="icon-angle-right"></i>
								</li>
								<li>
									<a>Les rendez-vous</a>
								</li>
							</ul>
							<!-- END PAGE TITLE & BREADCRUMB-->
							<a href="add-rendez-vous.php" class="btn blue big">Ajouter un rendez-vous
								<i class="icon-plus m-icon-white"></i>
							</a>
							<br><br>
						</div>
					</div>
					<!-- END PAGE HEADER-->
					<div class="row-fluid">
						<div class="span12">
					<!-- BEGIN PAGE CONTENT-->
					<!-- BEGIN Rendez-vous TABLE PORTLET-->
					<!-- BEGIN CONDENSED TABLE PORTLET-->
							<div class="portlet box green">
								<div class="portlet-title">
									<h4><i class="icon-calendar"></i>Liste des rendez-vous</h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
										<a href="javascript:;" class="remove"></a>
									</div>
								</div>
								<div class="portlet-body">
									<?php if(isset($_SESSION['rendez-vous-update-success'])){ ?>
	                                 	<div class="alert alert-success">
	    									<button class="close" data-dismiss="alert"></button>
	    									<?= $_SESSION['rendez-vous-update-success'] ?>		
	    								</div>
	                                 <?php } 
	                                 	unset($_SESSION['rendez-vous-update-success']);
	                                 ?>
									<table class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Heure</th>
												<th>Client</th>
												<th>Zone</th>
												<th>Nature</th>
												<th>Prix</th>
												<th>Tel1</th>
												<th>Tel2</th>
												<th>Mandataire</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$currentDate = date('Y-m-d');
											$currentTime = date('H:i');
											$color="";
											
											foreach($rendezVous as $rdv){
												$annulerPath = "controller/AnnulerAffaireController.php";
												$dateRdv = date('Y-m-d', strtotime($rdv->dateRdv()));
												$heureRdv = date('H:i',strtotime($rdv->heureRdv()));
												if($dateRdv>$currentDate){
													$color = "label-success";
												}
												else if($dateRdv>$currentDate and $heureRdv>$currentTime){
													$color = "label-success";
												}
												else if($dateRdv==$currentDate and $heureRdv>$currentTime){
													$color = "label-success";
												}
												else if($dateRdv<$currentDate){
													//if($heureRdv>$currentTime){
														//$color = "label-success";	
													//}
													//else{
														$color = "label-important";	
													//}
												}
										?>
											<tr>
												<td>
													<div class="btn-group">
													    <a class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
													    	<?= $dateRdv ?> 
													        <i class="icon-angle-down"></i>
													    </a>
													    <ul class="dropdown-menu">
													        <li>
													        	<?php //this part of code is for mohamed
													        	if($_SESSION['user']->login()=="mohamed"){
													        	?>
													        	<a href="terminer-affaire.php?idRdv=<?= $rdv->id() ?>">
													        		Terminer
													        	</a>
													        	<?php //this part of code is for mohamed
													        	}
													        	?>
													        </li>
													        <li>
													        	<a href="update-rendez-vous.php?idRdv=<?= $rdv->id() ?>">
													        	Modifier
													        	</a>
													        </li>
													        <li>
													        	<a href="#annuler<?php echo $rdv->id();?>" data-toggle="modal" data-id="<?php echo $rdv->id(); ?>">
													        		Annuler
													        	</a>
													        </li>
													    </ul>
													</div>	
												</td>
												<td><?= $heureRdv ?></td>
												<td><?= $rdv->nomClient() ?></td>
												<td><?= $rdv->province() //$zoneManager->getZoneById($affaire->idZone())->nom() ?></td>
												<td><?= $rdv->nature() ?></td>
												<td><?= $rdv->prix() ?></td>
												<td><?= $rdv->telefonClient() ?></td>
												<td><?= $rdv->telefonSource() ?></td></td>
												<td><?= $rdv->mandataire() ?></td>
												<td><span class="label <?= $color ?>"><?= $rdv->statut() ?></span></td>
											</tr>
											<!-- annuler affaire box begin-->
											<div id="annuler<?php echo $rdv->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Annuler Rendez-vous</h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal loginFrm" action="<?php echo $annulerPath;?>" method="post">
														<p>Êtes-vous sûr de vouloir annuler ce Rendez-vous ?</p>
														<div class="control-group">
															<label class="right-label"></label>
															<input type="hidden" name="idRdv" value="<?= $rdv->id() ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</form>
												</div>
											</div>
											<!-- annuler affaire box end -->
										<?php
											}
										?>
										</tbody>
										<?= $pagination ?>	
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- END CONDENSED TABLE PORTLET-->
					<!-- END Rendez-vous TABLE PORTLET-->
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