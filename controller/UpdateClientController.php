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
    $idClient = htmlentities($_POST['idClient']);
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$cin = htmlentities($_POST['cin']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		//objects creation and adding
		$client = new Client(array('id'=>$idClient, 'cin'=>$cin,
		'nom'=>$nom, 'numeroTelefon'=>$numeroTelefon));
		$clientManager = new ClientManager($pdo);
		$clientManager->update($client);
		//validation
		$_SESSION['client-update-success'] = "Les infos du client ont été modifiées avec succès.";
		header('Location:../clients.php');
    }
    else{
        $_SESSION['client-update-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../clients-update.php');
    }
    
    