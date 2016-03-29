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
    if(!empty($_POST['sorties'])){    
        $sorties= htmlentities($_POST['sorties']);
		$user = htmlentities($_POST['user']);
		$dateOperation = date('Y-m-d h:i:s');
		$statut = "encours";
		//service creation
		$sorties = new Sorties(array('montant'=>$sorties, 
		'dateOperation'=>$dateOperation, 'statut'=>$statut, 'user'=>$user));
		$sortiesManager = new SortiesManager($pdo);
		$sortiesManager->add($sorties);
		$_SESSION['sorties-success'] = "La sortie est ajoutée avec succès.";
		header('Location:../caisse.php');
    }
    else{
        $_SESSION['sorties-error'] = "Vous devez remplir le champ <strong>Nouvelle sortie</strong>.";
		header('Location:../caisse.php');
    }
    