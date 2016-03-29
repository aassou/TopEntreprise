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
        $nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$dateCharge = htmlentities($_POST['dateCharges']);
		//objects creation and adding
		$charges = new ChargesArchitecte(array('nom'=>$nom, 'montant'=>$montant, 
		'dateCharges'=>$dateCharge, 'paye'=>'non', 'idProjet'=>$idProjet));
		$chargesManager = new ChargesArchitecteManager($pdo);
		$chargesManager->add($charges);
		//validation
		$_SESSION['charges-success'] = "La charge est ajoutée avec succès.";
		header($link);
    }
    else{
        $_SESSION['charges-error'] = "<strong>Erreur Charges Architecte</strong> : Vous devez remplir au moins les champs 'Nom' et 'Montant'.";
		header($link);
    }
    
    