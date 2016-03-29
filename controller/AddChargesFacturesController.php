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
	include('../lib/image-processing.php');
    //classes loading end
    session_start();
	
	$idCharge = htmlentities($_POST['idCharges']);
	if(file_exists($_FILES['facture']['tmp_name']) || is_uploaded_file($_FILES['facture']['tmp_name'])) {
		$fichier = imageProcessing($_FILES['facture']);
		$categorie = htmlentities($_POST['categorie']);
		$facture = new Factures(array('chemin'=>$fichier, 'idCharge'=>$idCharge, 'categorie'=>$categorie));
		$factureManager = new FacturesManager($pdo);
		$factureManager->add($facture);
		$_SESSION['charges-factures-success'] = "Le fichier a été ajouté avec succès.";
		header('Location:../charges-factures.php?idCharges='.$idCharge);
	}
	else{
		$_SESSION['charges-factures-error'] = "Vous devez ajouté un fichier.";
		header('Location:../charges-factures.php?idCharges='.$idCharge);
	}
