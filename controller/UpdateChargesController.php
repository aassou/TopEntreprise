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
    if(!empty($_POST['mois'])){    
        $mois = htmlentities($_POST['mois']);
		$eau = htmlentities($_POST['eau']);
		$electricite = htmlentities($_POST['electricite']);
		$fixe = htmlentities($_POST['fixe']);
		$portable = htmlentities($_POST['portable']);
		$internet = htmlentities($_POST['internet']);
		$loyer = htmlentities($_POST['loyer']);
		$idCharge = htmlentities($_POST['idCharges']);
		//objects creation and adding
		$charges = new Charges(array('id'=>$idCharge, 'eau'=>$eau, 'electricite'=>$electricite, 'fixe'=>$fixe,
		'portable'=>$portable, 'internet'=>$internet, 'loyer'=>$loyer, 'dateCharges'=>$mois));
		$chargesManager = new ChargesManager($pdo);
		$chargesManager->update($charges);
		//validation
		$_SESSION['charges-success'] = "La liste des charges a été modifié avec succès.";
		header('Location:../charges.php');
    }
    else{
        $_SESSION['charges-error'] = "Vous devez remplir au moins le champ <strong>Mois</strong>.";
		header('Location:../update-charges.php');
    }
    
    