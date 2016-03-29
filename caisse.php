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
			//define entrees et sorties 
			$entreesManager = new EntreesManager($pdo);
			$sortiesManager = new SortiesManager($pdo);
			//get entrees et sorties
			$entreesKarim = $entreesManager->getEntreesEnCoursKarim();
			$entreesMohamed = $entreesManager->getEntreesEnCoursMohamed();
			$sortiesKarim = $sortiesManager->getSortiesEnCoursKarim();
			$sortiesMohamed = $sortiesManager->getSortiesEnCoursMohamed();
			//get totaux des entrees et sorties
			$entreesKarimTotal = $entreesManager->getEntreesKarimTotal();
			$entreesMohamedTotal = $entreesManager->getEntreesMohamedTotal();
			$sortiesKarimTotal = $sortiesManager->getSortiesKarimTotal();
			$sortiesMohamedTotal = $sortiesManager->getSortiesMohamedTotal();
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
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Fixed Header</span>
								</label>							
							</div>
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
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
								<a>Gérer la caisse</a>
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
						 <?php if(isset($_SESSION['charges-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charges-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['charges-success']);
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
                                 <h4><i class="icon-edit"></i>Entrées/Sorties Mohamed</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <?php if(isset($_SESSION['charges-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['charges-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['charges-error']);
                                 ?>
                                 <!-- BEGIN FORM Entrées Mohamed-->
									<form action="controller/AddEntreesController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <label class="control-label" for="entrees">Nouvelle Entrée</label>
	                                          </div>
	                                 	</div>
	                                 	<div class="span6 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="text" <?= $disabledMohamed ?> id="entrees" name="entrees" class="m-wrap span12" placeholder="">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="submit" <?= $disabledMohamed ?> class="m-wrap span12" value="OK +">
	                                                <input type="hidden" name="user" value="<?= $_SESSION['user']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- END FORM Entrées Mohamed--> 
                                 <!-- BEGIN FORM Sorties Mohamed-->
									<form action="controller/AddSortiesController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <label class="control-label" for="sorties">Nouvelle Sortie</label>
	                                          </div>
	                                 	</div>
	                                 	<div class="span6 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="text" <?= $disabledMohamed ?> id="sorties" name="sorties" class="m-wrap span12" placeholder="">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="submit" <?= $disabledMohamed ?> class="m-wrap span12" value="OK -">
	                                                <input type="hidden" name="user" value="<?= $_SESSION['user']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- END FORM Sorties Mohamed-->
                                 <hr>
                                 <!-- Table Entrées Mohamed Begin -->
                                 <h3>Les entrées</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Date Opération</th>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($entreesMohamed as $entreeMohamed){ ?>
										<tr>
											<td class="highlight">
												<a><?= $entreeMohamed->dateOperation() ?></a>
											</td>
											<td><?= $entreeMohamed->montant() ?> DH</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<label class="span3">Total</label>
								<input class="span3" type="text" disabled="disabled" placeholder="<?= $entreesMohamedTotal ?> DH">
								<!-- Table Entrées Mohamed End -->
								<!-- Table Sorties Mohamed Begin -->
                                 <h3>Les sorties</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Date Opération</th>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($sortiesMohamed as $sortieMohamed){ ?>
										<tr>
											<td class="highlight">
												<a><?= $sortieMohamed->dateOperation() ?></a>
											</td>
											<td><?= $sortieMohamed->montant() ?> DH</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<label class="span3">Total</label>
								<input class="span3" type="text" disabled="disabled" placeholder="<?= $sortiesMohamedTotal ?> DH">
								<!-- Table Sorties Mohamed End -->
                              </div>
                           </div>
						<!-- END Charges TABLE PORTLET-->
					</div>
					<div class="span6">
				<!-- BEGIN PAGE CONTENT-->
				<!-- BEGIN Charges TABLE PORTLET-->
						 <?php if(isset($_SESSION['charges-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charges-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['charges-success']);
                         ?>
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Entrées/Sorties Karim</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <?php if(isset($_SESSION['charges-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['charges-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['charges-error']);
                                 ?>
                                 <!-- BEGIN FORM Entrées Karim-->
                                 <form action="controller/AddEntreesController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <label class="control-label" for="entrees">Nouvelle Entrée</label>
	                                          </div>
	                                 	</div>
	                                 	<div class="span6 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="text" <?= $disabledKarim ?> id="entrees" name="entrees" class="m-wrap span12" placeholder="">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="submit" <?= $disabledKarim ?> class="m-wrap span12" value="OK +">
	                                                <input type="hidden" name="user" value="<?= $_SESSION['user']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- End FORM Entrées Karim-->
                                 <!-- BEGIN FORM Sorties Karim-->
  								 <form action="controller/AddSortiesController.php" method="POST" class="horizontal-form">
	                                 <div class="row-fluid">	
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <label class="control-label" for="sorties">Nouvelle Sortie</label>
	                                          </div>
	                                 	</div>
	                                 	<div class="span6 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="text" <?= $disabledKarim ?> id="sorties" name="sorties" class="m-wrap span12" placeholder="">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 	<div class="span3 ">
	                                          <div class="control-group">
	                                             <div class="controls">
	                                                <input type="submit" <?= $disabledKarim ?> class="m-wrap span12" value="OK -">
	                                                <input type="hidden" name="user" value="<?= $_SESSION['user']->login() ?>">
	                                             </div>
	                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>
                                 <!-- END FORM Sorties Karim-->
                                 <hr>
                                 <!-- Table Entrées Karim Begin -->
                                 <h3>Les entrées</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Date Opération</th>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($entreesKarim as $entreeKarim){ ?>
										<tr>
											<td class="highlight">
												<a><?= $entreeKarim->dateOperation() ?></a>
											</td>
											<td><?= $entreeKarim->montant() ?> DH</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<label class="span3">Total</label>
								<input class="span3" type="text" disabled="disabled" placeholder="<?= $entreesKarimTotal ?> DH">
								<!-- Table Entrées Karim End -->
								<!-- Table Sorties Karim Begin -->
                                 <h3>Les sorties</h3>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Date Opération</th>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($sortiesKarim as $sortieKarim){ ?>
										<tr>
											<td class="highlight">
												<a><?= $sortieKarim->dateOperation() ?></a>
											</td>
											<td><?= $sortieKarim->montant() ?> DH</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<label class="span3">Total</label>
								<input class="span3" type="text" disabled="disabled" placeholder="<?= $sortiesKarimTotal ?> DH">
								<!-- Table Sorties Karim End -->
                              </div>
                           </div>
						<!-- END Charges TABLE PORTLET-->
					</div>
					<!-- ############## Les totaux et les moyennes Begin ############## -->
					 <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Total et moyenne Entrées/Sorties</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne des Entrées Karim/Mohamed</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne - Sorties Mohamed</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne-$sortiesMohamedTotal ?>">
                              	</div>
                              	<div class="row-fluid">
	                              	<label class="span6">Moyenne - Sorties Karim</label>
	                              	<input class="span6" type="text" disabled="disabled" placeholder="<?= $moyenne-$sortiesKarimTotal ?>">
                              	</div>				
                              </div>
                     </div>
					<!-- ############## Les totaux et les moyennes End ############## -->
					<!-- ############## Terminer et archiver compte actuel begin ############## -->
					<a href="#terminer" class="btn big red " data-toggle="modal">Terminer et archiver le compte actuel</a>
					<br><br>
					<!-- delete box begin-->
					<div id="terminer" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h3>Terminer et archiver le compte</h3>
						</div>
						<div class="modal-body">
							<form class="form-horizontal loginFrm" action="controller/TerminerCaisseController.php" method="post">
								<p>Êtes-vous sûr de vouloir terminer et archiver le compte actuel ?</p>
								<div class="control-group">
									<label class="right-label"></label>
									<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
									<button type="submit" class="btn red" aria-hidden="true">Oui</button>
								</div>
							</form>
						</div>
					</div>
					<!-- delete box end -->
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