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
    $idService = htmlentities($_POST['idService']);
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		//objects creation and adding
		$service = new Service(array('id'=>$idService, 'nom'=>$nom,
		'numeroTelefon'=>$numeroTelefon, 'montant'=>$montant));
		$serviceManager = new ServiceManager($pdo);
		$serviceManager->update($service);
		//validation
		$_SESSION['service-update-success'] = "Les infos du service ont été modifiées avec succès.";
		header('Location:../services.php');
    }
    else{
        $_SESSION['service-update-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../service-update.php?idService='.$idService);
    }
    
    