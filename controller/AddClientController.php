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
		$cin = htmlentities($_POST['cin']);
		//client creation
		$client = new Client(array('nom'=>$nom, 'cin'=>$cin, 'numeroTelefon'=>$numeroTelefon));
		$clientManager = new ClientManager($pdo);
		$clientManager->add($client);
		$_SESSION['client-success'] = "Le client est ajouté avec succès.";
		header('Location:../clients.php');
    }
    else{
        $_SESSION['client-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../clients.php');
    }
    