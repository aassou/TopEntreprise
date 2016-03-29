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
	$idProjet = $_POST['idProjet'];
	$link = "";
	if($idProjet!=0){
		$link = 'Location:../charges-architecte.php?idProjet='.$idProjet;
	}
	else{
		$link = "Location:../charges-architecte.php";
	}
	if(!empty($_POST['nom']) and !empty($_POST['montant'])){
		$idCharge = $_GET['idCharge'];
		$nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$dateCharges = htmlentities($_POST['dateCharges']);
		$paye = htmlentities($_POST['paye']);
	    $chargesManager = new ChargesArchitecteManager($pdo);
		$charge = new ChargesArchitecte(array('id'=>$idCharge, 'nom'=>$nom, 'montant'=>$montant, 
		'dateCharges'=>$dateCharges, 'paye'=>$paye));
		$chargesManager->update($charge);
		$_SESSION['charges-update-success'] = "La charges est modifiée avec succès";
		header($link);	
	}
	else{
		$_SESSION['charges-update-error'] = "Erreur Modification Charges : Vous devez remplir au moins 'Nom' et 'Montant'";
		header($link);
	}
	