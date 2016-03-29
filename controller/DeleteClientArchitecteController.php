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
	$idClient = $_GET['idClient'];   
    $clientArchitecteManager = new ClientArchitecteManager($pdo);
	$clientArchitecteManager->delete($idClient);
	header('Location:../clients-architecte.php');
    
    