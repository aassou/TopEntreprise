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
    $idTopographe = htmlentities($_POST['idTopographe']);
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$montant = htmlentities($_POST['montant']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		//objects creation and adding
		$topographe = new Topographe(array('id'=>$idTopographe, 'nom'=>$nom,
		'numeroTelefon'=>$numeroTelefon, 'montant'=>$montant));
		$topographeManager = new TopographeManager($pdo);
		$topographeManager->update($topographe);
		//validation
		$_SESSION['topographe-update-success'] = "Les infos du topographe ont été modifiées avec succès.";
		header('Location:../topographes.php');
    }
    else{
        $_SESSION['topographe-update-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../topographe-update.php?idTopographe='.$idTopographe);
    }
    
    