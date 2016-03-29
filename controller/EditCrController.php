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
	
	if(!empty($_POST['nom'])){
		$idCr = $_GET['idCr'];
		$nom = htmlentities($_POST['nom']);
		$crManager = new CommuneRuraleManager($pdo);
		$cr = new CommuneRurale(array('id'=>$idCr, 'nom'=>$nom));
		$crManager->update($cr);
		$_SESSION['cr-update-success'] = "Commune modifiée avec succèes";
		header('Location:../crs.php');
	}
	else{
		$_SESSION['cr-update-error'] = "<strong>Erreur Modification Commune : </strong>Vous devez remplir le 'Nom'";
		header('Location:../crs.php');
	}
