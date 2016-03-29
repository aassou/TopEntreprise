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
		//client creation
		$client = new ClientArchitecte(array('nom'=>$nom, 'numeroTelefon'=>$numeroTelefon));
		$clientArchitecteManager = new ClientArchitecteManager($pdo);
		$clientArchitecteManager->add($client);
		$_SESSION['client-success'] = "Le client est ajouté avec succès.";
		header('Location:../clients-architecte.php');
    }
    else{
        $_SESSION['client-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../clients-architecte.php');
    }
    