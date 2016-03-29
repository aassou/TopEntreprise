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
        $nom = htmlentities($_POST['nom']);
		$numeroTelefon = htmlentities($_POST['numeroTelefon']);
		//source creation
		$sourceManager = new SourceManager($pdo);
		$lastId = $sourceManager->getLastId();
		if($lastId>=1){
			$code = 100+$lastId+1;
			$code = "S".$code;	
		}
		else{
			$code = "S101";
		}
		$source = new Source(array('nom'=>$nom, 'numeroTelefon'=>$numeroTelefon,
		'code'=>$code));
		$sourceManager->add($source);
		$_SESSION['source-success'] = "La source est ajoutée avec succès.";
		header('Location:../sources.php');
    }
    else{
        $_SESSION['source-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../sources.php');
    }
    