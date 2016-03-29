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
	
	$idProjet = htmlentities($_POST['idProjet']);
	
	if(!empty($_POST['nom'])){
		$idTache = $_GET['idTache'];
		$nom = htmlentities($_POST['nom']);
		$description = htmlentities($_POST['description']);
		$tacheManager = new TacheManager($pdo);
		$tache = new Tache(array('id'=>$idTache, 'nom'=>$nom, 'description'=>$description));
		$tacheManager->update($tache);
		$_SESSION['tache-update-success'] = "Tache modifiée avec succèes";
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
	}
	else{
		$_SESSION['tache-update-error'] = "<strong>Erreur Modification Tâche : </strong>Vous devez remplir le 'Nom'";
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
	}
