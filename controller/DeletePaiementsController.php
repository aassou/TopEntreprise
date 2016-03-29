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
	$idPaiements = $_GET['idPaiements'];   
	$idAffaire = $_POST['idAffaire'];
    $paiementsManager = new PaiementsManager($pdo);
	$paiementsManager->delete($idPaiements);
	header('Location:../paiements.php?idAffaire='.$idAffaire);
    
    