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
	
	$idAffaire = htmlentities($_POST['idAffaire']);
	$affaireManager = new AffaireManager($pdo);
	$affaireManager->annulerAffaire($idAffaire);
	header('Location:../rendez-vous.php');
