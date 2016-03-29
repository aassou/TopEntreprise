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
    $idAffaire = htmlentities($_POST['idAffaire']);
    if(!empty($_POST['montant']) and !empty($_POST['dateOperation'])){
		$dateOperation = htmlentities($_POST['dateOperation']);
		$montant = htmlentities($_POST['montant']);
		//objects creation and adding
		$paiements = new Paiements(array('montant'=>$montant,'dateOperation'=>$dateOperation, 'idAffaire'=>$idAffaire));
		$paiementsManager = new PaiementsManager($pdo);
		$paiementsManager->add($paiements);
		//validation
		$_SESSION['paiements-success'] = "Les paiements sont ajoutés avec succès.";
		header('Location:../paiements.php?idAffaire='.$idAffaire);
    }
    else{
        $_SESSION['paiements-error'] = "<strong>Erreur paiements</strong> : Vous devez remplir au moins les champ 'Montant' et 'Date Opération'.";
		header('Location:../paiements.php?idAffaire='.$idAffaire);
    }
    
    