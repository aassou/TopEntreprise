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
    	//les services
    	$affaires="";
    	$affairesManager = new AffaireManager($pdo);
		$clientManager = new ClientManager($pdo); 
        if(isset($_SESSION['searchAffaireResult'])){
            $affaires = $_SESSION['searchAffaireResult'];
        }
		unset($_SESSION['searchAffaireResult']);
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
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
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
							Les recherches
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-search"></i>
								<a>Rechercher</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Affaires</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<a href="recherches.php" class="btn yellow big">
							Retour à la page des recherches
							<i class="icon-search"></i>
						</a>
						<br><br>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box purple">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher une affaire</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                              	<!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['affaire-search-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['affaire-search-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['affaire-search-error']);
                                 ?>
                                 <form action="controller/SearchAffaireController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Recherche par</label>
				                              <div class="controls">
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByNumeroAffaire" checked />
				                                 Num.Affaire
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByNomClient" />
				                                 Nom Client
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByReste" />
				                                 Reste
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByQuartier" />
				                                 Quartier
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByMois" />
				                                 Mois
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireBySource" />
				                                 Source
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionAffaire" value="searchAffaireByTopographe" />
				                                 Topographe
				                                 </label>  
				                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchAffaire">Tapez votre recherche</label>
                                             <div class="controls">
                                                <input type="text" id="searchAffaire" name="searchAffaire" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn black"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box purple">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Les affaires</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<?php if((bool)$affaires){ ?>
								<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
									<thead>
										<tr>
											<th>Num.Affaire</th>
											<th>Nom Client</th>
											<th>Date Sortie</th>
											<th>Emplacement</th>
											<th>Prix</th>
											<th>Payé</th>
											<th>Reste</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($affaires as $affaire) { 
										?>	
										<tr class="">
											<td><?= $affaire->id()?></td>
											<td><?= $clientManager->getClientById($affaire->idClient())->nom()?></td>
											<td><?= date('d-m-Y',strtotime($affaire->dateSortie()))?></td>
											<td><?= $affaire->quartier()?></td>
											<td><?= $affaire->prix()?></td>
											<td><?= $affaire->paye()?></td>
											<td><?= $affaire->prix()-$affaire->paye()?></td>
											<?php //this part of process is reserved to mohamed profil 
											}
											?>
										</tr>
									</tbody>
								</table>
								<?php
								}
								else{
								?>
									<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									Aucun résultat trouvé.
    								</div>
								<?php
								}
								?>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT -->
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
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>