<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    //classes loading end
    session_start();
    
    //province input processing
    if(isset($_POST['province_submit'])){
    	if(!empty($_POST['province'])){    
	        $province = new Province(array('nom'=>htmlentities($_POST['province'])));
			$provinceManager = new ProvinceManager($pdo);
			if($provinceManager->exists2(htmlentities($_POST['province']))==false){
				$provinceManager->add($province);
				$_SESSION['zone-success'] = "La province est ajoutée avec succès.";
			}
			else{
				$_SESSION['zone-error'] = "Cette province existe déjà!";
			}
			header('Location:../zones.php');
	    }
		else{
			$_SESSION['zone-error'] = "Vous devez saisir une province !";
			header('Location:../zones.php');
		}
	}
	//mp input processing
    if(isset($_POST['mp_submit'])){
    	if(!empty($_POST['mp'])){    
	        $municipalite = new Municipalite(array('nom'=>htmlentities($_POST['mp'])));
			$municipaliteManager = new MunicipaliteManager($pdo);
			if($municipaliteManager->exists2(htmlentities($_POST['mp']))==false){
				$municipaliteManager->add($municipalite);
				$_SESSION['zone-success'] = "La municipalité est ajoutée avec succès.";
			}
			else{
				$_SESSION['zone-error'] = "Cette municipalité existe déjà!";
			}
			header('Location:../zones.php');
	    }
		else{
			$_SESSION['zone-error'] = "Vous devez saisir une municipalite !";
			header('Location:../zones.php');
		}
	}
	//cr input processing
    if(isset($_POST['cr_submit'])){
    	if(!empty($_POST['cr'])){    
	        $cr = new CommuneRurale(array('nom'=>htmlentities($_POST['cr'])));
			$crManager = new CommuneRuraleManager($pdo);
			if($crManager->exists2(htmlentities($_POST['cr']))==false){
				$crManager->add($cr);
				$_SESSION['zone-success'] = "La commune rurale est ajoutée avec succès.";
			}
			else{
				$_SESSION['zone-error'] = "Cette commune rurale existe déjà!";
			}
			header('Location:../zones.php');
	    }
		else{
			$_SESSION['zone-error'] = "Vous devez saisir une commune rurale !";
			header('Location:../zones.php');
		}
	}
	//quartier input processing
    if(isset($_POST['quartier_submit'])){
    	if(!empty($_POST['quartier'])){    
	        $quartier = new Quartier(array('nom'=>htmlentities($_POST['quartier'])));
			$quartierManager = new QuartierManager($pdo);
			if($quartierManager->exists2(htmlentities($_POST['quartier']))==false){
				$quartierManager->add($quartier);
				$_SESSION['zone-success'] = "Le quartier est ajouté avec succès.";
			}
			else{
				$_SESSION['zone-error'] = "Ce quartier existe déjà!";
			}
			header('Location:../zones.php');
	    }
		else{
			$_SESSION['zone-error'] = "Vous devez saisir un quartier !";
			header('Location:../zones.php');
		}
	}
	//sousquartier input processing
    if(isset($_POST['sousquartier_submit'])){
    	if(!empty($_POST['sousquartier'])){    
	        $sousQuartier = new SousQuartier(array('nom'=>htmlentities($_POST['sousquartier'])));
			$sousQuartierManager = new SousQuartierManager($pdo);
			if($sousQuartierManager->exists2(htmlentities($_POST['sousquartier']))==false){
				$sousQuartierManager->add($sousQuartier);
				$_SESSION['zone-success'] = "Le sous-quartier est ajouté avec succès.";
			}
			else{
				$_SESSION['zone-error'] = "Ce sous-quartier existe déjà!";
			}
			header('Location:../zones.php');
	    }
		else{
			$_SESSION['zone-error'] = "Vous devez saisir un sous-quartier !";
			header('Location:../zones.php');
		}
	}
    