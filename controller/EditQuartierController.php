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
		$idQuartier = $_GET['idQuartier'];
		$nom = htmlentities($_POST['nom']);
		$quartierManager = new QuartierManager($pdo);
		$quartier = new Quartier(array('id'=>$idQuartier, 'nom'=>$nom));
		$quartierManager->update($quartier);
		$_SESSION['quartier-update-success'] = "Quartier modifié avec succèes";
		header('Location:../quartiers.php');
	}
	else{
		$_SESSION['quartier-update-error'] = "<strong>Erreur Modification Quartier : </strong>Vous devez remplir le 'Nom'";
		header('Location:../quartiers.php');
	}
