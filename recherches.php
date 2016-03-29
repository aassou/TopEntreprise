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
    	$userManager = new UserManager($pdo);
		$users = $userManager->getUsers();
        
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
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<!-- affaire recherche begin -->
					<div class="span12">
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
					</div>
					<!-- affaire recherche end -->
				</div>
				<div class="row-fluid">
					<!-- source recherche begin -->
					<div class="span6">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher une source</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <form action="controller/SearchSourceController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Recherche par</label>
				                              <div class="controls">
				                                 <label class="radio">
				                                 <input type="radio" name="searchOption" value="searchByName" checked />
				                                 Nom
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOption" value="searchByCode" />
				                                 Code
				                                 </label>  
				                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="search">Tapez votre recherche</label>
                                             <div class="controls">
                                                <input type="text" id="search" name="search" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn green"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
					</div>
					<!-- source recherche end -->
					<!-- topographe recherche begin -->
					<div class="span6">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher un topographe</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <form action="controller/SearchTopographeController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Recherche par</label>
				                              <div class="controls">
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionTopographe" value="searchTopographeByName" checked />
				                                 Nom
				                                 </label>
				                                 <label class="radio">
				                                 <input type="radio" name="searchOptionTopographe" value="searchTopographeByCode" />
				                                 Code
				                                 </label>  
				                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchTopographe">Tapez votre recherche</label>
                                             <div class="controls">
                                                <input type="text" id="searchTopographe" name="searchTopographe" class="m-wrap span12" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
					</div>
					<!-- topographe recherche end -->
				</div>
				<div class="row-fluid">
					<!-- facture recherche begin -->
					<div class="span6">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher une facture</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <form action="controller/SearchFactureController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchMonthYearFacture">Mois-Année</label>
                                             <div class="controls">
                                                <input type="text" id="searchMonthYearFacture" name="searchMonthYearFacture" class="m-wrap span12" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchCategorieFacture">Catégorie</label>
                                             <div class="controls">
                                                <select name="searchCategorieFacture">
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
                                    <div class="form-actions">
                                       <button type="submit" class="btn yellow"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
					</div>
					<!-- facture recherche end -->
					<!-- congé recherche begin -->
					<div class="span6">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box red">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher un congé</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <form action="conges-search.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchYearConge">Année</label>
                                             <div class="controls">
                                                <input type="text" id="searchYearConge" name="searchYearConge" class="m-wrap span12" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="searchCongeByNom">Profil</label>
                                             <div class="controls">
                                                <select name="searchCongeByNom">
                                                	<?php foreach($users as $user){ ?>
		                                     		<option value="<?= $user->login() ?>"><?= $user->login() ?></option>
		                                     		<?php } ?>
		                                     	</select>
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
					</div>
					<!-- congé recherche end -->
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