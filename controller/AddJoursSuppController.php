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
    if(!empty($_POST['nom']) and !empty($_POST['dateTravail'])){
		$nom = htmlentities($_POST['nom']);
		$dateTravail = htmlentities($_POST['dateTravail']);
		//objects creation and adding
		$joursSupp = new JoursSupp(array('nom'=>$nom, 'dateTravail'=>$dateTravail));
		$joursSuppManager = new JoursSuppManager($pdo);
		$joursSuppManager->add($joursSupp);
		//validation
		$_SESSION['jours-success'] = "Le jours supplémentaire est ajouté avec succès.";
		header('Location:../conges.php');
    }
    else{
        $_SESSION['jours-error'] = "Vous devez remplir tous les champs.";
		header('Location:../conges.php');
    }
    
    