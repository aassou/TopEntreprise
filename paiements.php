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
    if(isset($_SESSION['user'])){
    	$affaireManager = new AffaireManager($pdo);	
    	$paiementsManager = new PaiementsManager($pdo);
		$clientManager = new ClientManager($pdo);
    	$idAffaire=1;
		$paiements = "";
		$totalPaiements = "";
		$affaire = "";
		$client = "";
		$numeroAffaire = "";
		$dateCreationAffaire = "";
		$nomClient = ""; 
    	if(isset($_GET['idAffaire']) and ($_GET['idAffaire']>0 and $_GET['idAffaire']<= $affaireManager->getLastId())){
    		$idAffaire = $_GET['idAffaire'];
			$paiements = $paiementsManager->getPaiementsByIdAffaire($idAffaire);
			$affaire = $affaireManager->getAffaireById($idAffaire);
			$numeroAffaire = $affaire->id();
			$dateCreationAffaire = $affaire->dateRdv();
			$client = $clientManager->getClientById($affaire->idClient());
			$nomClient = $client->nom();
			$totalPaiements = $paiementsManager->getPaiementsTotalByIdAffaire($idAffaire);
    	} 
		$paiements = $paiementsManager->getPaiementsByIdAffaire($idAffaire);
		//$month = date('m/Y', strtotime($charges->dateCharges()));
		//$cnsss = $cnssManager->getCnssByIdCharge($idCharge);
		
        
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
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
							Les paiements des affaires
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-bar-chart"></i>
								<a>Affaires Topographe</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Gérer les paiements des affaires</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
						<a href="affaires.php" class="btn blue big">Retour vers liste des affaires
							<i class="m-icon-big-swapleft m-icon-white"></i>
						</a>
						<br><br>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
				<div class="tab-pane active" id="tab_1">
                   <div class="portlet box grey">
                      <div class="portlet-title">
                         <h4><i class="icon-edit"></i>Ajouter Paiements</h4>
                         <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="remove"></a>
                         </div>
                      </div>
                      <div class="portlet-body form">
                         <!-- BEGIN FORM-->
                         <?php if(isset($_SESSION['paiements-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiements-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['paiements-success']);
                         ?>
                         <?php if(isset($_SESSION['paiements-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiements-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['paiements-error']);
                         ?>
                         <form action="controller/AddPaiementsController.php" method="POST" class="horizontal-form">
                            <div class="row-fluid">
                               <div class="span4 ">
                                  <div class="control-group">
                                     <label class="control-label" for="mois">Date Opération</label>
                                     <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
	                                    <input name="dateOperation" class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" />
	                                    <span class="add-on"><i class="icon-calendar"></i></span>
	                                 </div>
                                  </div>
                               </div>
                               <div class="span4 ">
                                  <div class="control-group">
                                     <label class="control-label" for="montant">Montant</label>
                                     <div class="controls">
                                        <input type="text" id="montant" name="montant" class="m-wrap span12" placeholder="">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <input type="hidden" name="idAffaire" class="m-wrap span12" value="<?= $idAffaire ?>">
                            <div class="form-actions">
                               <button type="submit" class="btn black"><i class="icon-ok"></i> Ajouter</button>
                               <button type="reset" class="btn">Annuler</button>
                            </div>
                         </form>
                         <!-- END FORM--> 
                      </div>
                   </div>
                </div>
				<div class="portlet box blue">
					<div class="portlet-title">
						<h4><i class="icon-shopping-cart"></i>Les paiements de l'affaire </h4>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="remove"></a>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>N°Affaire</th>
									<th>Date Affaire</th>
									<th>Nom Client</th>
									<th>Montant</th>
									<th>Date opération</th>
									<th>Modifier</th>
									<th>Supprimer</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($paiements as $paiement){
									$deletePath = "controller/DeletePaiementsController.php?idPaiements=".$paiement->id();
								?>
								<tr>
									<td><?= $idAffaire ?></td>
									<td><?= date('d-m-Y',strtotime($dateCreationAffaire)) ?></td>
									<td><?= $nomClient ?></td>
									<td><?= $paiement->montant() ?></td>
									<td><?= date('d-m-Y',strtotime($paiement->dateOperation())) ?></td>
									<td>
										<a href="paiements-update.php?idPaiements=<?= $paiement->id() ?>"  data-toggle="modal" data-id="<?php echo $paiement->id(); ?>">
											Modifier
										</a>
									</td>
									<td>
										<a href="#delete<?php echo $paiement->id();?>" data-toggle="modal" data-id="<?php echo $paiement->id(); ?>">
											Supprimer				
										</a>
									</td>
								</tr>
								<!-- delete box begin-->
									<div id="delete<?php echo $paiement->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h3>Supprimez les paiements</h3>
										</div>
										<div class="modal-body">
											<form class="form-horizontal loginFrm" action="<?php echo $deletePath;?>" method="post">
												<p>Êtes-vous sûr de vouloir supprimer cette opération ?</p>
												<div class="control-group">
													<label class="right-label"></label>
													<input type="hidden" name="idAffaire" value="<?= $paiement->idAffaire() ?>" />
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</form>
										</div>
									</div>
								<!-- delete box end -->
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="portlet box blue">
					<div class="portlet-title">
						<h4><i class="icon-shopping-cart"></i>Bilan de l'affaire N° : <?= $idAffaire ?></h4>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="remove"></a>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Prix de l'affaire</th>
									<th>Total des paiements</th>
									<th>Avance</th>
									<th>Total des paiements+Avance</th>
									<th>Reste</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $affaire->prix() ?></td>
									<td><?= $totalPaiements ?></td>
									<td><?= $affaire->paye() ?></td>
									<td><?= $totalPaiements+$affaire->paye() ?></td>
									<td><?= $affaire->prix()-($totalPaiements+$affaire->paye()) ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- END Charges TABLE PORTLET-->
				<br>
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
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>	
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