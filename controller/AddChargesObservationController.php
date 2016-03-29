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
    if(!empty($_POST['dateOperation'])){    
		$idCharge = htmlentities($_POST['idCharges']);
		$operation = htmlentities($_POST['operation']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		$montant = htmlentities($_POST['montant']);
		//objects creation and adding
		$observation = new Observation(array('operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation, 'idCharge'=>$idCharge));
		$observationManager = new ObservationManager($pdo);
		$observationManager->add($observation);
		//validation
		$_SESSION['charges-observation-success'] = "Les charges des observations sont ajoutées avec succès.";
		header('Location:../charges-observation.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-observation-error'] = "Vous devez remplir au moins le champ <strong>Date de l'opération</strong>.";
		header('Location:../charges-observation.php?idCharges='.$idCharge);
    }
    
    