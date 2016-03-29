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
    
	$idProjet = htmlentities($_POST['idProjet']);
	$idTache = htmlentities($_POST['idTache']);
	$nomTache = $_GET['nomTache'];
	$tacheManager = new TacheManager($pdo);
    //post input processing
    /*if(!empty($_POST[$nomTache])){
		$tacheManager->changeStatusOn($idTache);
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
    }
	else if(empty($_POST[$nomTache])){
		$tacheManager->changeStatusOff($idTache);
		header('Location:../suivi-projet.php?idProjet='.$idProjet);
	}*/
    $tacheStatus = $tacheManager->getStatus($idTache);
	$status = "checked";
	if($tacheStatus=="checked"){
		$status = "";
	}
	$tacheManager->changeStatus($idTache, $status);
	/*echo $status;
	echo $idProjet;
	echo $idTache;
	echo $nomTache;*/
	header('Location:../suivi-projet.php?idProjet='.$idProjet);
	
	
