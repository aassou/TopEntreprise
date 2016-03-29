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
    	//define class managers
    	$clientManager = new ClientManager($pdo);
		$sourceManager = new SourceManager($pdo);
		$rendezVousManager = new RendezVousManager($pdo);
		//get client, zones and source lists
		$clients = $clientManager->getClients();
		$sources = $sourceManager->getSources();
		$idRdv = 1;
		if(isset($_GET['idRdv']) and ($_GET['idRdv']>0 and $_GET['idRdv']<=$rendezVousManager->getLastId())){
			$idRdv = $_GET['idRdv'];
		}
        $rendezVous = $rendezVousManager->getRendezVousById($idRdv);
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
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/clockface/css/clockface.css" />
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
								<a>Affaires Topographe</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Modifier un rendez-vous</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
						<a href="rendez-vous.php" class="btn green big">Retour vers rendez-vous
							<i class="m-icon-big-swapleft m-icon-white"></i>
						</a>
						<br><br>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
				<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Modifer un rendez-vous</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['rendez-vous-update-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['rendez-vous-update-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['rendez-vous-update-success']);
                                 ?>
                                 <?php if(isset($_SESSION['rendez-vous-update-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['rendez-vous-update-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['rendez-vous-update-error']);
                                 ?>
                                 <form action="controller/UpdateRendezVousController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="client">Nom du Client</label>
                                             <div class="controls">
                                                <input type="text" id="client_id" name="client" class="m-wrap span12" placeholder="" onkeyup="autocomplet()" value="<?= $rendezVous->nomClient() ?>">
                                                <ul id="client_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="cin">CIN du Client</label>
                                             <div class="controls">
                                                <input type="text" id="cin" name="cin" class="m-wrap span12" value="<?= $rendezVous->cin() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="numeroTelefon1">Numéro Téléphone 1</label>
                                             <div class="controls">
                                                <input type="text" id="numeroTelefon1" name="numeroTelefon1" class="m-wrap span12" value="<?= $rendezVous->telefonClient() ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       	<div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="mandataire">Mandataire</label>
                                             <div class="controls">
                                                <input type="text" id="mandataire" name="mandataire" class="m-wrap span12" value="<?= $rendezVous->mandataire() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="source_id">Source</label>
                                             <div class="controls">
                                                <input type="text" id="source_id" name="source" class="m-wrap span12" onkeyup="autocomplet_source()" <?= $rendezVous->source() ?> >
                                                <ul id="source_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="numeroTelefon2">Numéro Téléphone 2</label>
                                             <div class="controls">
                                                <input type="text" id="numeroTelefon2" name="numeroTelefon2" class="m-wrap span12" value="<?= $rendezVous->telefonSource() ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
									  <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateSortie">Date RDV</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateSortie" class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="<?= $rendezVous->dateRdv() ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
										    <label class="control-label">Heure RDV</label>
										    <div class="controls">
			                                 <div class="input-append">
			                                    <input type="text" name="heureRdv" id="clockface_2" class="m-wrap small" readonly="" value="<?= $rendezVous->heureRdv() ?>" />
			                                    <button class="btn" type="button" id="clockface_2_toggle-btn">
			                                    <i class="icon-time"></i>
			                                    </button>
			                                 </div>
			                              </div>
										</div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="natureTravail">Nature du travail</label>
                                             <div class="controls">
                                                <input type="text" id="natureTravail" name="natureTravail" class="m-wrap span12" value="<?= $rendezVous->nature() ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
										<div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="prix">Prix</label>
                                             <div class="controls">
                                                <input type="text" id="prix" name="prix" class="m-wrap span12" value="<?= $rendezVous->prix() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="province">Province</label>
                                             <div class="controls">
                                                <input type="text" id="province_id" name="province" class="m-wrap span12" value="<?= $rendezVous->province() ?>" onkeyup="autocomplet_province()">
                                                <ul id="province_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="municipalite">M.P</label>
                                             <div class="controls">
                                                <input type="text" id="municipalite_id" name="municipalite" class="m-wrap span12" value="<?= $rendezVous->mp() ?>" onkeyup="autocomplet_municipalite()">
                                                <ul id="municipalite_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
									<div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="commune">C.R</label>
                                             <div class="controls">
                                                <input type="text" id="commune_id" name="commune" class="m-wrap span12" value="<?= $rendezVous->cr() ?>" onkeyup="autocomplet_commune()">
                                                <ul id="commune_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="quartier">Quartier</label>
                                             <div class="controls">
                                                <input type="text" id="quartier_id" name="quartier" class="m-wrap span12" value="<?= $rendezVous->quartier() ?>" onkeyup="autocomplet_quartier()">
                                                <ul id="quartier_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
										<input type="hidden" id="idRdv" name="idRdv" class="m-wrap span12" value="<?= $idRdv ?>">
                                    	<input type="hidden" id="idProvince" name="idProvince" class="m-wrap span12">
                                    	<input type="hidden" id="idMp" name="idMp" class="m-wrap span12">
                                    	<input type="hidden" id="idCr" name="idCr" class="m-wrap span12">
                                    	<input type="hidden" id="idQuartier" name="idQuartier" class="m-wrap span12">
                                       <button type="submit" class="btn green"><i class="icon-ok"></i> Modifer</button>
                                       <button type="reset" class="btn">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
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
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="assets/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="script.js"></script>
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
