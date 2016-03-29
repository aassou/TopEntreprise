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
    if(!empty($_POST['nom'])){    
		$idCharge = htmlentities($_POST['idCharges']);
		$nom = htmlentities($_POST['nom']);
		$dateOperation = htmlentities($_POST['dateOperation']);
		$montant = htmlentities($_POST['montant']);
		$prime = htmlentities($_POST['prime']);
		//objects creation and adding
		$salaire = new Salaires(array('nom'=>$nom, 'montant'=>$montant, 'prime'=>$prime,
		'dateOperation'=>$dateOperation, 'idCharge'=>$idCharge));
		$salairesManager = new SalairesManager($pdo);
		$salairesManager->add($salaire);
		//validation
		$_SESSION['charges-salaires-success'] = "Les salaires sont ajoutés avec succès.";
		header('Location:../charges-salaires.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-salaires-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../charges-salaires.php?idCharges='.$idCharge);
    }
    
    