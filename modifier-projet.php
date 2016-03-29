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
    	$idProjet = 1;
		$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientArchitecteManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet']>0 and $_GET['idProjet']<=$projetManager->getLastId())){
			$idProjet = $_GET['idProjet'];
		}
		$projet = $projetManager->getProjetById($idProjet);
		$client = $clientManager->getClientArchitecteById($projet->idClient());
    	
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
							Gestion des affaires
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
								<a>Gérer les projets</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
						<a href="projets.php" class="btn purple big">Retour vers les projets
							<i class="m-icon-big-swapleft m-icon-white"></i>
						</a>
						<br><br>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
				<div class="tab-pane active" id="tab_1">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Gérer les projets</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['projet-update-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['projet-update-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['projet-update-error']);
                                 ?>
                                 <form action="controller/UpdateProjetController.php" method="POST" class="horizontal-form" enctype="multipart/form-data">
                                 	<div class="row-fluid">
                                      <fieldset><legend>Infos Client</legend>
                                       <div class="span3 ">
                                       		<div class="control-group autocomplet_container">
                                             <label class="control-label" for="client">Nom du Client</label>
                                             <div class="controls">
                                                <input type="text" id="client_id" name="client" class="m-wrap span12" value="<?= $client->nom() ?>" onkeyup="autocomplet_client()">
                                                <ul id="client_list_id"></ul>
                                             </div>
                                          </div>
                                        </div>
                                        <div class="span3 ">
	                                       <div class="control-group">
	                                          <label class="control-label" for="numeroTelefon1">Téléphone Client</label>
	                                          <div class="controls">
	                                             <input type="text" id="numeroTelefon1" name="numeroTelefon1" class="m-wrap span12" value="<?= $client->numeroTelefon() ?>">
	                                          </div>
	                                       </div>
                                       	</div>
                                       </fieldset>
                                       </div>
                                       <div class="row-fluid">
                                      <fieldset><legend>Infos Projet</legend>
                                       	<div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Nom du Projet</label>
                                             <div class="controls">
                                                <input type="text" name="nomProjet" class="m-wrap span12" value="<?= $projet->nom() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="type">Type</label>
                                             <div class="controls">
                                                <input type="text" id="type" name="type" class="m-wrap span12" value="<?= $projet->type() ?>" onkeyup="autocomplet_type()">
                                                <ul id="type_list"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="objet">Objet</label>
                                             <div class="controls">
                                                <input type="text" id="objet" name="objet" class="m-wrap span12" value="<?= $projet->objet() ?>" onkeyup="autocomplet_objet()">
                                                <ul id="objet_list"></ul>
                                             </div>
                                          </div>
                                       </div>  
                                       </fieldset>
                                       <fieldset><legend> </legend>
                                    	<div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="architecte">Architecte</label>
                                             <div class="controls">
                                                <input type="text" id="architecte" name="architecte" class="m-wrap span12" value="<?= $projet->architecte() ?>" onkeyup="autocomplet_architecte()">
                                                <ul id="architecte_list"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Levé</label>
                                             <div class="controls">
                                                <input type="text" name="leve" class="m-wrap span12" value="<?= $projet->leve() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label">Titre</label>
                                             <div class="controls">
                                                <input type="text" name="titre" class="m-wrap span12" value="<?= $projet->titre() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                       <fieldset><legend></legend>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="ilot">Ilot</label>
                                             <div class="controls">
                                                <input type="text" id="ilot" name="ilot" class="m-wrap span12" value="<?= $projet->ilot() ?>" onkeyup="autocomplet_ilot()">
                                                <ul id="ilot_list"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="lot">Lot</label>
                                             <div class="controls">
                                                <input type="text" id="lot" name="lot" class="m-wrap span12" value="<?= $projet->lot() ?>"  onkeyup="autocomplet_lot()">
                                                <ul id="lot_list"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                       </div>
                                      <div class="row-fluid">
                                      	<fieldset><legend>Dates</legend>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateCreation">Date Création</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateCreation" id="dateCreation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $projet->dateCreation() ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateFin">Date Fin</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateFin" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $projet->dateFin() ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                    </div>
                              		<div class="row-fluid">
                                    	<fieldset><legend>Infos Paiement</legend>
                                    	<div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="prix">Prix total</label>
                                             <div class="controls">
                                                <input type="text" id="prix" name="prix" class="m-wrap span12" value="<?= $projet->prix() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="paye">Payé</label>
                                             <div class="controls">
                                                <input type="text" id="paye" name="paye" class="m-wrap span12" value="<?= $projet->paye() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="reste">Reste</label>
                                             <div class="controls">
                                                <input type="text" id="reste" name="reste" class="m-wrap span12" value="<?= $projet->prix()-$projet->paye() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       </fieldset>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idClient" name="idClient" class="m-wrap span12">
                                    	<input type="hidden" id="idProjet" name="idProjet" class="m-wrap span12" value="<?= $projet->id() ?>">
                                       <button type="submit" class="btn black"><i class="icon-ok"></i> Modifier</button>
                                       <input type="reset" class="btn" value="Annuler">
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
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="assets/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="script_architecte.js"></script>
	<script>
	$(function(){
        $('#prix, #paye').change(function(){
            var prix = parseFloat($('#prix').val());
            var paye = parseFloat($('#paye').val());
            var reste = 0;
            reste = prix - paye;
            $('#reste').val(reste);
        });
    });
    function valueChanged(){
	    if($('.archiver_affaire').is(":checked"))   
	        $(".files_upload").show();
	    else
	        $(".files_upload").hide();
	}
    </script>    
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			$(".files_upload").hide();
			App.setPage('calendar');
			App.init();
		});
	</script>
	<script>
	//hidden inputs source and topographe begin
		$(document).ready(function(){
	        $('input[type="checkbox"]').click(function(){
	            if($(this).attr("value")=="cachet"){
	                $(".hiddenInput").toggle();
	            }
	        });
	    });
	//hidden inputs source and topographe end
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