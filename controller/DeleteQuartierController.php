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
	$idQuartier = $_GET['idQuartier'];   
    $quartierManager = new QuartierManager($pdo);
	$quartierManager->delete($idQuartier);
	header('Location:../quartiers.php');
    
    