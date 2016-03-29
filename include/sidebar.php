<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
				</li>
				<!---------------------------- Dashboard Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="dashboard.php" 
				or $currentPage=="recherches.php"
				or $currentPage=="conges.php"
				or $currentPage=="configuration.php"
				or $currentPage=="conges-search.php"
				or $currentPage=="factures-search.php"
				or $currentPage=="users.php"){echo "active ";} ?>">
					<a href="dashboard.php">
					<i class="icon-home"></i> 
					<span class="title">Accueil</span>
					<span class="<?php if ( $currentPage == "dashboard.php" ) { echo "selected"; } ?>"></span>
					</a>
				</li>
				<!---------------------------- Dashboard End    -------------------------------------------->
				<!---------------------------- Affaires Topographe Begin ----------------------------------->
				<?php 
					$affairesTopographeClass="";
					if($currentPage=="sources.php" 
					or $currentPage=="services.php" 
					or $currentPage=="topographes.php"
					or $currentPage=="rendez-vous.php"
					or $currentPage=="add-rendez-vous.php"
					or $currentPage=="update-rendez-vous.php"
					or $currentPage=="affaires.php"
					or $currentPage=="affaire-update.php"
					or $currentPage=="affaires-group.php"
					or $currentPage=="add-affaire.php"
					or $currentPage=="clients.php"
					or $currentPage=="zones.php"
					or $currentPage=="update-affaire.php"
					or $currentPage=="terminer-affaire.php"
					or $currentPage=="clients-update.php"
					or $currentPage=="zones-update.php"
					or $currentPage=="topographe-update.php"
					or $currentPage=="source-update.php"
					or $currentPage=="service-update.php"
					or $currentPage=="sources-search.php"
					or $currentPage=="topographes-search.php"
					or $currentPage=="affaires-search.php"
					or $currentPage=="archive-affaire.php"
					or $currentPage=="paiements.php"
					or $currentPage=="paiements-update.php"
					or $currentPage=="provinces.php"
					or $currentPage=="mps.php"
					or $currentPage=="crs.php"
					or $currentPage=="quartiers.php"
					or $currentPage=="squartiers.php"
					){
						$affairesTopographeClass = "active ";
					} 
				?> 
				<li class="<?= $affairesTopographeClass; ?> has-sub" >
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Affaires Topographe</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="rendez-vous.php" 
						or $currentPage=="add-rendez-vous.php" 
						or $currentPage=="update-rendez-vous.php" 
						or $currentPage=="update-affaire.php"
						){?> class="active" <?php } ?> >
							<a href="rendez-vous.php">Les rendez-vous</a>
						</li>
						<li <?php if($currentPage=="affaires.php"
						or $currentPage=="affaires-group.php"  
						or $currentPage=="terminer-affaire.php" 
						or $currentPage=="affaires-search.php" 
						or $currentPage=="archive-affaire.php"
						or $currentPage=="paiements.php"
						or $currentPage=="paiements-update.php"
						){?> class="active" <?php } ?> >
							<a href="affaires-group.php">Les affaires</a>
						</li>
						<li <?php if($currentPage=="add-affaire.php"){?> class="active" <?php } ?> >
							<a href="add-affaire.php">Ajouter Affaire</a>
						</li>
						<li <?php if($currentPage=="sources.php" 
						or $currentPage=="source-update.php" 
						or $currentPage=="sources-search.php"
						){?> class="active" <?php } ?> >
							<a href="sources.php">Les sources</a>
						</li>
						<li <?php if($currentPage=="services.php" 
						or $currentPage=="service-update.php"
						){?> class="active" <?php } ?> >
							<a href="services.php">Les services</a>
						</li>
						<li <?php if($currentPage=="topographes.php" 
						or $currentPage=="topographe-update.php" 
						or $currentPage=="topographes-search.php"
						){?> class="active" <?php } ?> >
							<a href="topographes.php">Les topographes</a>
						</li>
						<li <?php if($currentPage=="clients.php" 
						or $currentPage=="clients-update.php"
						){?> class="active" <?php } ?> >
							<a href="clients.php">Les clients</a>
						</li>
						<li <?php if($currentPage=="zones.php" 
						or $currentPage=="zones-update.php"
						or $currentPage=="provinces.php"
						or $currentPage=="mps.php"
						or $currentPage=="crs.php"
						or $currentPage=="quartiers.php"
						or $currentPage=="squartiers.php"
						){?> class="active" <?php } ?> >
							<a href="zones.php">Les zones</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Affaires Topographe End -------------------------------------->
				<!---------------------------- Charges Topographe Begin ------------------------------------->
				<?php 
					$chargesTopographeClass="";
					if($currentPage=="charges.php" or $currentPage=="add-charges.php"
					or $currentPage=="charges-voiture.php"
					or $currentPage=="update-charges.php"
					or $currentPage=="charges-voiture.php"
					or $currentPage=="charges-cnss.php"
					or $currentPage=="charges-salaires.php"
					or $currentPage=="charges-comptable.php"
					or $currentPage=="charges-observation.php"
					or $currentPage=="charges-factures.php"){
						$chargesTopographeClass = "active ";
					} 
				?> 
				<li class="<?= $chargesTopographeClass; ?> has-sub ">
					<a href="javascript:;">
					<i class="icon-bar-chart"></i> 
					<span class="title">Charges Topographe</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="charges.php"){?> class="active" <?php } ?> >
							<a href="charges.php">Consulter les charges</a>
						</li>
						<li <?php if($currentPage=="add-charges.php" or $currentPage=="charges-voiture.php" 
						or $currentPage=="update-charges.php"
						or $currentPage=="charges-voiture.php"
						or $currentPage=="charges-cnss.php"
						or $currentPage=="charges-salaires.php"
						or $currentPage=="charges-comptable.php"
						or $currentPage=="charges-observation.php"
						or $currentPage=="charges-factures.php"){?> class="active" <?php } ?> >
							<a href="add-charges.php">Gérer les charges</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Charges Topographe End ------------------------------------->
				<!---------------------------- Affaires Architecte Begin ------------------------------------>
				<?php 
				/*
					$affairesArchitecteClass="";
					if($currentPage=="projets.php" 
					or $currentPage=="projets-add.php"
					or $currentPage=="modifier-projet.php"
					or $currentPage=="suivi-projet.php"
					or $currentPage=="add-charges.php"
					or $currentPage=="clients-architecte.php"
					or $currentPage=="clients-architecte-update.php"
					or $currentPage=="avancement-projets.php"){
						$affairesArchitecteClass = "active ";
					} 
				?> 
				<li class="<?= $affairesArchitecteClass; ?> has-sub ">
					<a href="javascript:;">
					<i class="icon-folder-open"></i> 
					<span class="title">Projets Architecte</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="projets.php"){?> class="active" <?php } ?> >
							<a href="projets.php">Consulter les projets</a>
						</li>
						<li <?php if($currentPage=="projets-add.php" 
						or $currentPage=="modifier-projet.php"
						or $currentPage=="suivi-projet.php"){?> class="active" <?php } ?> >
							<a href="projets-add.php">Gérer les projets</a>
						</li>
						<li <?php if($currentPage=="avancement-projets.php"){?> class="active" <?php } ?> >
							<a href="avancement-projets.php">Avancement des projets</a>
						</li>
						<li <?php if($currentPage=="clients-architecte.php" 
						or $currentPage=="clients-architecte-update.php"){?> class="active" <?php } ?> >
							<a href="clients-architecte.php">Les clients</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Affaires Architecte End --------------------------------------->
				<!---------------------------- Charges Architecte Begin -------------------------------------->
				<?php 
					$chargesArchitecteClass="";
					if($currentPage=="charges-architecte.php"){
						$chargesArchitecteClass = "active ";
					} 
				?> 
				<li class="<?= $chargesArchitecteClass; ?> has-sub ">
					<a href="javascript:;">
					<i class="icon-signal"></i> 
					<span class="title">Charges Architecte</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="charges-architecte.php"){?> class="active" <?php } ?> >
							<a href="charges-architecte.php">Consulter les charges</a>
						</li>
					</ul>
				</li>
				<!---------------------------- Charges Architecte End ------------------------------------->
				<!---------------------------- Caisse TopEntreprise Begin --------------------------------->
				<?php 
				 * 
				 */
				if($_SESSION['user']->login()=="mohamed" or $_SESSION['user']->login()=="karim"){
					$caisseClass="";
					if($currentPage=="caisse.php"
					or $currentPage=="caisse-automatisee.php"
					or $currentPage=="caisse-archive.php"){
						$caisseClass = "active ";
					} 
				?> 
				<li class="<?= $caisseClass; ?> has-sub ">
					<a href="javascript:;">
					<i class="icon-money"></i> 
					<span class="title">Caisse TopEntreprise</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($currentPage=="caisse-automatisee.php"){?> class="active" <?php } ?> >
							<a href="caisse-automatisee.php">Gérer la caisse automatisée</a>
						</li>
						<li <?php if($currentPage=="caisse.php"){?> class="active" <?php } ?> >
							<a href="caisse.php">Gérer la caisse manuelle</a>
						</li>
						<li <?php if($currentPage=="caisse-archive.php"){?> class="active" <?php } ?> >
							<a href="caisse-archive.php">Archive de la caisse</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<!---------------------------- Caisse TopEntreprise End ------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>