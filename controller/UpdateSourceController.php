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
    $idSource = htmlentities($_POST['idSource']);
    if(!empty($_POST['nom'])){    
        $nom = htmlentities($_POST['nom']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		//objects creation and adding
		$source = new Source(array('id'=>$idSource, 'nom'=>$nom,
		'numeroTelefon'=>$numeroTelefon));
		$sourceManager = new SourceManager($pdo);
		$sourceManager->update($source);
		//validation
		$_SESSION['source-update-success'] = "Les infos de la source ont été modifiées avec succès.";
		header('Location:../sources.php');
    }
    else{
        $_SESSION['source-update-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../source-update.php?idSource='.$idSource);
    }
    
    