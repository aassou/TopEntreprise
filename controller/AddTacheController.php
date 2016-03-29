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
    //post input processing
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$description = htmlentities($_POST['description']);
		$checked = "";
		//source creation
		$tacheManager = new TacheManager($pdo);
		$tache = new Tache(array('nom'=>$nom, 'description'=>$description, 
		'checked'=>$checked, 'idProjet'=>$idProjet));
		$tacheManager->add($tache);
		$_SESSION['tache-add-success'] = "La tâche est ajoutée avec succès.";
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
    }
    else{
        $_SESSION['tache-add-error'] = "<strong>Erreur Tâche </strong>: Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
    }
    