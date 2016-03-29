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
		//objects creation and adding
		$cnss = new Cnss(array('nom'=>$nom, 'montant'=>$montant,
		'dateOperation'=>$dateOperation, 'idCharge'=>$idCharge));
		$cnssManager = new CnssManager($pdo);
		$cnssManager->add($cnss);
		//validation
		$_SESSION['charges-cnss-success'] = "Les charges de CNSS sont ajoutées avec succès.";
		header('Location:../charges-cnss.php?idCharges='.$idCharge);
    }
    else{
        $_SESSION['charges-cnss-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../charges-cnss.php?idCharges='.$idCharge);
    }
    
    