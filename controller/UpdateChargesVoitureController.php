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
    $idVoiture = htmlentities($_POST['idVoiture']);
    if(!empty($_POST['dateOperation'])){    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$operation = htmlentities($_POST['operation']);
		$montant = htmlentities($_POST['montant']);
		$idCharge = htmlentities($_POST['idCharge']);
		//objects creation and adding
		$voiture = new Voiture(array('id'=>$idVoiture, 'operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation));
		$voitureManager = new VoitureManager($pdo);
		$voitureManager->update($voiture);
		//validation
		$_SESSION['charges-voiture-success'] = "La liste des charges de voiture a été modifié avec succès.";
		header('Location:../charges-voiture.php?idCharge='.$idCharge);
    }
    else{
        $_SESSION['charges-voiture-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../charges-voiture-update.php?idVoiture='.$idVoiture);
    }
    
    