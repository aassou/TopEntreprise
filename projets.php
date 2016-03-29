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
    	$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientArchitecteManager($pdo);
		//classes
		//projets pagination parameters and process begin
        $projetPerPage = 10;
        $projetNumber = ($projetManager->getProjetNumber());
        $pageNumber = ceil($projetNumber/$projetPerPage);
        $p = 1;
        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
            $p = $_GET['p'];
        }
        else{
            $p = 1;
        }
        $begin = ($p - 1) * $projetPerPage;
        $projets = $projetManager->getProjetsByLimits($begin, $projetPerPage);
        $pagination = paginate('projets.php', '?p=', $pageNumber, $p);
        
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
							Gestion des projets
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-folder-open"></i>
								<a>Projets Architecte</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Liste des projets</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
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
								<h4><i class="icon-calendar"></i>Liste des projets</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<?php if(isset($_SESSION['projet-add-sucess'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['projet-add-sucess'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['projet-add-sucess']);
                                 ?>
								<table class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>Date Création</th>
											<th>Client</th>
											<th>Nom Projet</th>
											<th>Type</th>
											<th>Objet</th>
											<th>Prix</th>
											<th>Payé</th>
											<th>Reste</th>
											<th>Statut</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$currentDate = date('Y-m-d');
										$color="";
										
										foreach($projets as $projet){
											$dateCreation = date('Y-m-d', strtotime($projet->dateCreation()));
											$statut = $projet->statut();
											//$link="";
											if($statut=="encours"){
												$color="label-success";
											}
											else if($statut=="terminee"){
												$color="label-success";
											}
											else if($statut=="archivee"){
												$color="label-inverse";
											}
											
									?>
										<tr>
											<td>
												<div class="btn-group">
												    <a class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $dateCreation ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="modifier-projet.php?idProjet=<?= $projet->id() ?>">
												        		Modifier
												        	</a>
												        	<a href="suivi-projet.php?idProjet=<?= $projet->id() ?>">
												        		Suivi 
												        	</a>
												        	<a href="charges-architecte.php?idProjet=<?= $projet->id() ?>">
												        		Gérer les charges
												        	</a>
												        	<a href="archive-affaire.php?idAffaire=<?= $projet->id() ?>">
												        		Gérer les dossiers
												        	</a>
												        	<?php if($statut=="archivee"){ ?>
												        	<a href="projets-documents.php?idProjet=<?= $projet->id() ?>">
												        		Consulter Documents
												        	</a>
												        	<?php } ?>
												        </li>
												    </ul>
												</div>	
											</td>
											<td><?= $clientManager->getClientArchitecteById($projet->idClient())->nom() ?></td>
											<td><?= $projet->nom() ?></td>
											<td><?= $projet->type() ?></td>
											<td><?= $projet->objet() ?></td>
											<td><?= $projet->prix() ?></td>
											<td><?= $projet->paye() ?></td>
											<td><?= $projet->prix()-$projet->paye() ?></td>
											<td><span class="label <?= $color ?>"><?= $statut ?></span></td>
										</tr>
									<?php
										}
									?>
									</tbody><?=	$pagination;?>
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