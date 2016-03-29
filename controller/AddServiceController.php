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
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		$montant = htmlentities($_POST['montant']);
		//service creation
		$serviceManager = new ServiceManager($pdo);
		
		$service = new Service(array('nom'=>$nom, 'numeroTelefon'=>$numeroTelefon, 
		'montant'=>$montant));
		$serviceManager->add($service);
		$_SESSION['service-success'] = "Le service est ajouté avec succès.";
		header('Location:../services.php');
    }
    else{
        $_SESSION['service-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../services.php');
    }
    