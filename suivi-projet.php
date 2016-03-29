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
    	$projetManager = new ProjetManager($pdo);
		$tacheManager = new TacheManager($pdo);
		$idProjet = 1;
		if(isset($_GET['idProjet']) and ($_GET['idProjet'] > 0 and $_GET['idProjet'] <= $projetManager->getLastId())){
			$idProjet = $_GET['idProjet'];
		}
		$projet = $projetManager->getProjetById($idProjet);
		$taches = $tacheManager->getTachesByIdProjet($idProjet);
		$tacheNumber = $tacheManager->getTacheNumberByIdProjet($idProjet);
		$checkedTacheNumber = $tacheManager->getCheckedTacheNumberByIdProjet($idProjet);
		$progress = 0;
		if($tacheNumber!=0){
			$progress = ($checkedTacheNumber/$tacheNumber)*100;	
		}
		//progress color
		$colorProgressBar = "";
		if($progress<25){
			$colorProgressBar = "progress-danger";	
		}
		else if($progress>=25 and $progress<50){
			$colorProgressBar = "progress-warning";
		}
		else if($progress>=50 and $progress<75){
			$colorProgressBar = "progress-success";
		}
        //services pagination parameters and process end
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
							<li><a>Suivi des projets</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter une tâche</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['tache-update-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['tache-update-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['tache-update-success']);
                                 ?>
                                  <?php if(isset($_SESSION['tache-update-error'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['tache-update-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['tache-update-error']);
                                 ?>
                                 <?php if(isset($_SESSION['tache-add-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['tache-add-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['tache-add-success']);
                                 ?>
                                 <?php if(isset($_SESSION['tache-add-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['tache-add-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['tache-add-error']);
                                 ?>
                                 
                                 <form action="controller/AddTacheController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="nom">Nom</label>
                                             <div class="controls">
                                                <input type="text" id="nom" name="nom" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="description">Description</label>
                                             <div class="controls">
                                                <textarea id="description" name="description"></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Ajouter</button>
                                       <button type="reset" class="btn">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
                        <div class="portlet box grey">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Avancement du projet : <?= $projet->nom() ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<div class="progress progress-striped <?= $colorProgressBar ?> active">
									<div style="width: <?= $progress ?>%;" class="bar"><span style="font-size: 14px; color:black"><?= $progress ?>%</span></div>
								</div>
							</div>
						</div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box grey">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Suivi du projet : <?= $projet->nom() ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
									<thead>
										<tr>
											<th>Nom</th>
											<th>Description</th>
											<th>Statut</th>
											<th>Modifier</th>
											<?php //this part of process is reserved to mohamed profil 
											if($_SESSION['user']->login()=="karim"){
											?>
											<th>Supprimer</th>
											<?php //this part of process is reserved to mohamed profil 
											}
											?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($taches as $tache) { 
											$deletePath = "controller/DeleteTacheController.php?idTache=".$tache->id();
											$editPath = "controller/EditTacheController.php?idTache=".$tache->id();	
										?>	
										<tr class="">
											<td><?= $tache->nom()?></td>
											<td><?= $tache->description()?></td>
											<td>
												<form id="form<?= $tache->id() ?>" method="post" action="controller/ChangeTacheStatutController.php?nomTache=<?= $tache->nom()?>">	
													<input class="checkbox" type="checkbox" name="<?= $tache->nom()?>" <?= $tache->checked()?> onchange="$('#form<?= $tache->id() ?>').submit();">
													<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" >
													<input type="hidden" name="idTache" value="<?= $tache->id() ?>" >
												</form>
											</td>
											<td>
												<a href="#edit<?php echo $tache->id();?>" data-toggle="modal" data-id="<?php echo $tache->id(); ?>">
													Modifier
												</a>		
											</td>
											<?php //this part of process is reserved to karim profil 
											if($_SESSION['user']->login()=="karim"){
											?>
											<td>
												<a href="#delete<?php echo $tache->id();?>" data-toggle="modal" data-id="<?php echo $tache->id(); ?>">
													Supprimer				
												</a>
											</td>
											<?php //this part of process is reserved to karim profil 
											}
											?>
										</tr>	
										<!-- edit box begin-->
										<div id="edit<?php echo $tache->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifiez la tâche</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="<?php echo $editPath;?>" method="post">
													<p>Êtes-vous sûr de vouloir modifier cette tâche ?</p>
													<div class="control-group">
														<label class="right-label">Nom</label>
														<input type="text" name="nom" value="<?= $tache->nom() ?>">
														<label class="right-label">Description</label>
														<input type="text" name="description" value="<?= $tache->description() ?>" >
														<label class="right-label"></label>
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" >
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- edit box end -->
										<!-- delete box begin-->
										<div id="delete<?php echo $tache->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimez la tâche</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="<?php echo $deletePath;?>" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cette tâche ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" >
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
		//change checkbox status submit
		/*$(function(){
         $('.checkbox').on('change',function(){
            $('#form').submit();
            });
        });*/
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