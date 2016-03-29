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
    $idZone = htmlentities($_POST['idZone']);
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$observation = htmlentities($_POST['observation']);
		//objects creation and adding
		$zone = new Zone(array('id'=>$idZone, 'nom'=>$nom, 'observation'=>$observation));
		$zoneManager = new ZoneManager($pdo);
		$zoneManager->update($zone);
		//validation
		$_SESSION['zone-update-success'] = "La zone a été modifiée avec succès.";
		header('Location:../zones.php');
    }
    else{
        $_SESSION['zone-update-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../zones.php');
    }
    
    