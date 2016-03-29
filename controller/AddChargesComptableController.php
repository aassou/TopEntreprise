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
		$comptable = new Comptable(array('operation'=>$operation, 'montant'=>$montant,
		'dateOperation'=>$dateOperation, 'idCharge'=>$idCharge));
		$comptableManager = new ComptableManager($pdo);
		$comptableManager->add($comptable);
		//validation
		$_SESSION['charges-comptable-success'] = "Les charges du comptable sont ajoutées avec succès.";
		header('Location:../charges-comptable.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-comptable-error'] = "Vous devez remplir au moins le champ <strong>Date de l'opération</strong>.";
		header('Location:../charges-comptable.php?idCharges='.$idCharge);
    }
    
    