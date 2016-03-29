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
    $idSalaire = htmlentities($_POST['idSalaire']);
    if(!empty($_POST['dateOperation'])){    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$prime = htmlentities($_POST['prime']);
		$idCharge = htmlentities($_POST['idCharges']);
		//objects creation and adding
		$salaire = new Salaires(array('id'=>$idSalaire, 'nom'=>$nom, 'montant'=>$montant,
		'prime'=>$prime, 'dateOperation'=>$dateOperation));
		$salairesManager = new SalairesManager($pdo);
		$salairesManager->update($salaire);
		//validation
		$_SESSION['charges-salaires-success'] = "La liste des charges des salaires a été modifiée avec succès.";
		header('Location:../charges-salaires.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-salaires-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../charges-salaires-update.php?idSalaire='.$idSalaire);
    }
    
    