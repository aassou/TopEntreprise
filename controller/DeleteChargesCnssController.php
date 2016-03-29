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
	$idCnss = $_GET['idCnss'];   
	$idCharge = $_POST['idCharges'];
    $cnssManager = new CnssManager($pdo);
	$cnssManager->delete($idCnss);
	header('Location:../charges-cnss.php?idCharges='.$idCharge);
    
    