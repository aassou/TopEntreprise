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
    $idPaiements = htmlentities($_POST['idPaiements']);
    if(!empty($_POST['dateOperation']) and !empty($_POST['montant'])){
        $idAffaire = htmlentities($_POST['idAffaire']);	    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$montant = htmlentities($_POST['montant']);
		//objects creation and adding
		$paiements = new Paiements(array('id'=>$idPaiements, 'montant'=>$montant,'dateOperation'=>$dateOperation));
		$paiementsManager = new PaiementsManager($pdo);
		$paiementsManager->update($paiements);
		//validation
		$_SESSION['paiements-success'] = "L'opération de paiement a été modifiée avec succès.";
		header('Location:../paiements.php?idAffaire='.$idAffaire);
    }
    else{
        $_SESSION['charges-cnss-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../paiements-update.php?idPaiements='.$idPaiements);
    }
    
    