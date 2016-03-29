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
    	//topographes pagination parameters and process end
    	$topographesManager = new TopographeManager($pdo);
		//topographe pagination parameters and process begin
        $topographePerPage = 10;
        $topographeNumber = $topographesManager->getTopographesNumber();
        $pageNumber = ceil($topographeNumber/$topographePerPage);
        $p = 1;
        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
            $p = $_GET['p'];
        }
        else{
            $p = 1;
        }
        $begin = ($p - 1) * $topographePerPage;
        $topographes = $topographesManager->getTopographesByLimits($begin, $topographePerPage);
        $pagination = paginate('topographes.php', '?p=', $pageNumber, $p);
        //topographes pagination parameters and process end
        
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
							Gestion des topographes 
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
							<li><a>Les topographes</a></li>
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
                                 <h4><i class="icon-edit"></i>Ajouter un topographe</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['topographe-update-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['topographe-update-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['topographe-update-success']);
                                 ?>
                                 <?php if(isset($_SESSION['topographe-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['topographe-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['topographe-success']);
                                 ?>
                                 <?php if(isset($_SESSION['topographe-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['topographe-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['topographe-error']);
                                 ?>
                                 <form action="controller/AddTopographeController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="nom">Nom</label>
                                             <div class="controls">
                                                <input type="text" id="nom" name="nom" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="numeroTelefon">Numéro téléphone</label>
                                             <div class="controls">
                                                <input type="text" id="numeroTelefon" name="numeroTelefon" class="m-wrap span12" placeholder="">
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
                                    <div class="form-actions">
                                       <button type="submit" class="btn red"><i class="icon-ok"></i> Ajouter</button>
                                       <button type="reset" class="btn">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box grey">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Les topographes</h4>
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
											<th>Code</th>
											<th>Nom</th>
											<th>Numéro téléphone</th>
											<th>Montant</th>
											<th>Modifier</th>
											<?php //this part of process is reserved to mohamed profil 
											if($_SESSION['user']->login()=="mohamed"){
											?>
											<th>Supprimer</th>
											<?php //this part of process is reserved to mohamed profil 
											}
											?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($topographes as $topographe) { 
											$deletePath = "controller/DeleteTopographeController.php?idTopographe=".$topographe->id();	
										?>	
										<tr class="">
											<td><?= $topographe->code()?></td>
											<td><?= $topographe->nom()?></td>
											<td><?= $topographe->numeroTelefon()?></td>
											<td><?= $topographe->montant()?></td>
											<td><a class="edit" href="topographe-update.php?idTopographe=<?= $topographe->id() ?>">Modifier</a></td>
											<?php //this part of process is reserved to mohamed profil 
											if($_SESSION['user']->login()=="mohamed"){
											?>
											<td>
												<a href="#delete<?php echo $topographe->id();?>" data-toggle="modal" data-id="<?php echo $topographe->id(); ?>">
													Supprimer				
												</a>
											</td>
											<?php //this part of process is reserved to mohamed profil 
											}
											?>
										</tr>					
										<!-- delete box begin-->
										<div id="delete<?php echo $topographe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimez le topographe</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="<?php echo $deletePath;?>" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce topographe ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->					
										<?php } ?>
										<?= $pagination ?>	
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