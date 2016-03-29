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
    if(!empty($_POST['nom']) and !empty($_POST['dateDebut']) and !empty($_POST['dateFin'])){
		$nom = htmlentities($_POST['nom']);
		$dateDebut = htmlentities($_POST['dateDebut']);
		$dateFin = htmlentities($_POST['dateFin']);
		//objects creation and adding
		$conge = new Conges(array('nom'=>$nom, 'dateDebut'=>$dateDebut,
		'dateFin'=>$dateFin));
		$congeManager = new CongesManager($pdo);
		$congeManager->add($conge);
		//validation
		$_SESSION['conges-success'] = "Le congé est ajouté avec succès.";
		header('Location:../conges.php');
    }
    else{
        $_SESSION['conges-error'] = "Vous devez remplir tous les champs.";
		header('Location:../conges.php');
    }
    
    