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
		$voiture = new Voiture(array('operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation, 'idCharge'=>$idCharge));
		$voitureManager = new VoitureManager($pdo);
		$voitureManager->add($voiture);
		//validation
		$_SESSION['charges-voiture-success'] = "Les charges de voiture sont ajoutées avec succès.";
		header('Location:../charges-voiture.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-voiture-error'] = "Vous devez remplir au moins le champ <strong>Date de l'opération</strong>.";
		header('Location:../charges-voiture.php?idCharges='.$idCharge);
    }
    
    