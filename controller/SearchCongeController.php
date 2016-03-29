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
    if(!empty($_POST['searchYearConge'])){
		$annee = htmlentities($_POST['searchYearConge']);
		$profil = htmlentities($_POST['searchCongeByNom']);
		$congesManager = new CongesManager($pdo);
		$_SESSION['searchCongeResult'] = $congesManager->getCongeBySearch($profil, $annee);
		header('Location:../conges-search.php');
    }
    else{
        $_SESSION['conge-search-error'] = 
        "<strong>Erreur Congé</strong> : Vous devez saisir une 'Année'";
		header('Location:../conges-search.php');
    }