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
    $idCnss = htmlentities($_POST['idCnss']);
    if(!empty($_POST['dateOperation'])){    
        $dateOperation = htmlentities($_POST['dateOperation']);
		$nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$idCharge = htmlentities($_POST['idCharges']);
		//objects creation and adding
		$cnss = new Cnss(array('id'=>$idCnss, 'nom'=>$nom, 'montant'=>$montant,
		'dateOperation'=>$dateOperation));
		$cnssManager = new CnssManager($pdo);
		$cnssManager->update($cnss);
		//validation
		$_SESSION['charges-cnss-success'] = "La liste des charges de CNSS a été modifiée avec succès.";
		header('Location:../charges-cnss.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-cnss-error'] = "Vous devez remplir au moins le champ <strong>Date opération</strong>.";
		header('Location:../charges-cnss-update.php?idCnss='.$idCnss);
    }
    
    