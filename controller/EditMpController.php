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
		$idMp = $_GET['idMp'];
		$nom = htmlentities($_POST['nom']);
		$mpManager = new MunicipaliteManager($pdo);
		$mp = new Municipalite(array('id'=>$idMp, 'nom'=>$nom));
		$mpManager->update($mp);
		$_SESSION['mp-update-success'] = "Municipalité modifiée avec succèes";
		header('Location:../mps.php');
	}
	else{
		$_SESSION['mp-update-error'] = "<strong>Erreur Modification Municipalité : </strong>Vous devez remplir le 'Nom'";
		header('Location:../mps.php');
	}
