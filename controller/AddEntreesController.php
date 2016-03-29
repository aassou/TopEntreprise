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
    if(!empty($_POST['entrees'])){    
        $entrees= htmlentities($_POST['entrees']);
		$user = htmlentities($_POST['user']);
		$dateOperation = date('Y-m-d h:i:s');
		$statut = "encours";
		//service creation
		$entrees = new Entrees(array('montant'=>$entrees, 
		'dateOperation'=>$dateOperation, 'statut'=>$statut, 'user'=>$user));
		$entreesManager = new EntreesManager($pdo);
		$entreesManager->add($entrees);
		$_SESSION['entrees-success'] = "L'entrée est ajoutée avec succès.";
		header('Location:../caisse.php');
    }
    else{
        $_SESSION['entrees-error'] = "Vous devez remplir le champ <strong>Nouvelle entrée</strong>.";
		header('Location:../caisse.php');
    }
    