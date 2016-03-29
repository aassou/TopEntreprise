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
    	//classes managers	
    	$provinceManager = new ProvinceManager($pdo);
		$mpManager = new MunicipaliteManager($pdo);
		$crManager = new CommuneRuraleManager($pdo);
		$quartierManager = new QuartierManager($pdo);
		$sousQuartierManager = new SousQuartierManager($pdo);
		//classes
		$provinces = $provinceManager->getProvinces();
		$mps = $mpManager->getMunicipalites();
		$crs = $crManager->getCommuneRurales();
		$quartiers = $quartierManager->getQuartiers();
		$sousQuartiers = $sousQuartierManager->getSousQuartiers();
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
							Gestion des zones
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a>Gestion des affaires</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Les zones</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box yellow">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter une zone</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['zone-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['zone-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['zone-success']);
                                 ?>
                                 <?php if(isset($_SESSION['zone-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['zone-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['zone-error']);
                                 ?>
                                 <form action="controller/AddZoneController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span1 ">
                                          <div class="control-group">
                                             <label class="control-label" for="province"><a href="provinces.php">Province</a></label>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <div class="controls">
                                                <input type="text" id="province_id" name="province" class="m-wrap span12" onkeyup="autocomplet_province()">
                                                <ul id="province_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span1 ">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" value="Ajouter" name="province_submit" class="btn">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span1 ">
                                          <div class="control-group">
                                             <label class="control-label" for="mp"><a href="mps.php">MP</a></label>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <div class="controls">
                                                <input type="text" id="municipalite_id" name="mp" class="m-wrap span12" onkeyup="autocomplet_municipalite()">
                                                <ul id="municipalite_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span1 ">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" value="Ajouter" name="mp_submit" class="btn">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span1 ">
                                          <div class="control-group">
                                             <label class="control-label" for="cr"><a href="crs.php">CR</a></label>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <div class="controls">
                                                <input type="text" id="commune_id" name="cr" class="m-wrap span12" onkeyup="autocomplet_commune()">
                                                <ul id="commune_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span1 ">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" value="Ajouter" name="cr_submit" class="btn">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span1 ">
                                          <div class="control-group">
                                             <label class="control-label" for="quartier"><a href="quartiers.php">Quartier</a></label>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group autocomplet_container">
                                             <div class="controls">
                                                <input type="text" id="quartier_id" name="quartier" class="m-wrap span12" onkeyup="autocomplet_quartier()">
                                                <ul id="quartier_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span1 ">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" value="Ajouter" name="quartier_submit" class="btn">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span1 ">
                                          <div class="control-group">
                                             <label class="control-label" for="sousquartier"><a href="squartiers.php">S.quartier</a></label>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group autocomplet_container">
                                             <div class="controls">
                                                <input type="text" id="sousquartier_id" name="sousquartier" class="m-wrap span12" onkeyup="autocomplet_sousquartier()">
                                                <ul id="sousquartier_list_id"></ul>
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span1 ">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" value="Ajouter" name="sousquartier_submit" class="btn">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>				
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
	<script type="text/javascript" src="script.js"></script>
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