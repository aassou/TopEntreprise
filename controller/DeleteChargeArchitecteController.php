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
	$idCharge = $_GET['idCharge'];
    $chargesManager = new ChargesArchitecteManager($pdo);
	$chargesManager->delete($idCharge);
	header($link);