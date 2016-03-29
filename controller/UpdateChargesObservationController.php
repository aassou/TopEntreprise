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
    $idObservation = htmlentities($_POST['idObservation']);
    if(!empty($_POST['dateOperation'])){    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$operation = htmlentities($_POST['operation']);
		$montant = htmlentities($_POST['montant']);
		$idCharge = htmlentities($_POST['idCharges']);
		//objects creation and adding
		$observation = new Observation(array('id'=>$idObservation, 'operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation));
		$observationManager = new ObservationManager($pdo);
		$observationManager->update($observation);
		//validation
		$_SESSION['charges-observation-success'] = "La liste des charges d'Observation a été modifiée avec succès.";
		header('Location:../charges-observation.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-observation-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../charges-observation-update.php?idObservation='.$idObservation);
    }
    
    