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
	$idObservation = $_GET['idObservation'];   
	$idCharge = $_POST['idCharges'];
    $observationManager = new ObservationManager($pdo);
	$observationManager->delete($idObservation);
	header('Location:../charges-observation.php?idCharges='.$idCharge);
    
    