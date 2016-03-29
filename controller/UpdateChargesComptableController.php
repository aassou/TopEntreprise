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
    $idComptable = htmlentities($_POST['idComptable']);
    if(!empty($_POST['dateOperation'])){    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$operation = htmlentities($_POST['operation']);
		$montant = htmlentities($_POST['montant']);
		$idCharge = htmlentities($_POST['idCharges']);
		//objects creation and adding
		$comptable = new Comptable(array('id'=>$idComptable, 'operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation));
		$comptableManager = new ComptableManager($pdo);
		$comptableManager->update($comptable);
		//validation
		$_SESSION['charges-comptable-success'] = "La liste des charges du comptable a été modifié avec succès.";
		header('Location:../charges-comptable.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-voiture-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../charges-comptable-update.php?idComptable='.$idComptable);
    }
    
    