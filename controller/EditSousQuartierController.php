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
		$idSousQuartier = $_GET['idSousQuartier'];
		$nom = htmlentities($_POST['nom']);
		$squartierManager = new SousQuartierManager($pdo);
		$squartier = new SousQuartier(array('id'=>$idSousQuartier, 'nom'=>$nom));
		$squartierManager->update($squartier);
		$_SESSION['squartier-update-success'] = "Sous-Quartier modifié avec succèes";
		header('Location:../squartiers.php');
	}
	else{
		$_SESSION['squartier-update-error'] = "<strong>Erreur Modification Sous-Quartier : </strong>Vous devez remplir le 'Nom'";
		header('Location:../squartiers.php');
	}
