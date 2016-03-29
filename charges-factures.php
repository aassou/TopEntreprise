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
    	$chargesManager = new ChargesManager($pdo);
		$facturesManager = new FacturesManager($pdo);
    	$idCharge=1;
    	if(isset($_GET['idCharges']) and ($_GET['idCharges']>0 and $_GET['idCharges']<= $chargesManager->getLastId())){
    		$idCharge = $_GET['idCharges'];
    	} 
		$charges = $chargesManager->getChargesById($idCharge);
		$month = date('m/Y', strtotime($charges->dateCharges()));
		$factures = $facturesManager->getFacturesByIdCharge($idCharge);
		
        
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
	<link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
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
							Les factures et paperasse
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
								<a>Gérer les fatures par charges</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
						<a href="charges.php" class="btn purple big">Retour vers liste des charges
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
                         <h4><i class="icon-edit"></i>Ajouter des factures</h4>
                         <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="remove"></a>
                         </div>
                      </div>
                      <div class="portlet-body form">
                         <!-- BEGIN FORM-->
                         <?php if(isset($_SESSION['charges-factures-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charges-factures-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['charges-factures-success']);
                         ?>
                         <?php if(isset($_SESSION['charges-factures-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charges-factures-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['charges-factures-error']);
                         ?>
                         <form action="controller/AddChargesFacturesController.php" method="POST" class="horizontal-form" enctype="multipart/form-data">
                            <div class="row-fluid">
                               <div class="span4 ">
                                  <div class="control-group">
                                     <label class="control-label" for="facture">Fichier à télécharger</label>
                                     <div class="controls">
                                        <input type="file" id="facture" name="facture" class="m-wrap span12" placeholder="">
                                     </div>
                                  </div>
                               </div>
                               <div class="span4 ">
                                  <div class="control-group">
                                     <label class="control-label" for="facture">Catégorie</label>
                                     <div class="controls">
                                     	<select name="categorie">
                                     		<option value="eau">Eau</option>
                                     		<option value="electricite">Electricité</option>
                                     		<option value="fix">Tél.Fix</option>
                                     		<option value="portable">Tél.Portable</option>
                                     		<option value="internet">Internet</option>
                                     		<option value="loyer">Loyer</option>
                                     	</select>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <input type="hidden" name="idCharges" class="m-wrap span12" value="<?= $idCharge ?>">
                            <div class="form-actions">
                               <button type="submit" class="btn black"><i class="icon-ok"></i> Ajouter</button>
                               <button type="button" class="btn">Annuler</button>
                            </div>
                         </form>
                         <!-- END FORM--> 
                      </div>
                   </div>
                </div>
				<div class="portlet box purple">
					<div class="portlet-title">
						<h4><i class="icon-shopping-cart"></i>Les factures et paperasse</h4>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="remove"></a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row-fluid">
								<?php
								foreach($factures as $facture){
									//$deletePath = "controller/DeleteChargesCnssController.php?idCnss=".$cnss->id();
								?>
								<div class="span3">
									<div class="item">
										<a class="fancybox-button" data-rel="fancybox-button" title="Photo" href="<?= $facture->chemin() ?>">
											<div class="zoom">
												<img src="<?= $facture->chemin() ?>" alt="Photo" />							
												<div class="zoom-icon"></div>
											</div>
										</a>
									</div>
								</div>
								<?php } ?>
						</div>
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
	<script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
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