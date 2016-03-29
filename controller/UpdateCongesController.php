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
    
    //post input processing
    $idConge = htmlentities($_POST['idConge']);
    if(!empty($_POST['dateDebut']) and !empty($_POST['dateFin'])){    
        $dateDebut = htmlentities($_POST['dateDebut']);
		$dateFin = htmlentities($_POST['dateFin']);
		//objects creation and adding
		$conge = new Conges(array('id'=>$idConge, 'dateDebut'=>$dateDebut, 'dateFin'=>$dateFin));
		$congeManager = new CongesManager($pdo);
		$congeManager->update($conge);
		//validation
		$_SESSION['conges-update-success'] = "Les infos du congé ont été modifiées avec succès.";
		header('Location:../conges.php');
    }
    else{
        $_SESSION['conges-update-error'] = "Vous devez remplir les champs \"Début congé\" et \"Fin congé\".";
		header('Location:../conges-update.php');
    }
    
    