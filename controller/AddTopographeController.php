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
		$montant = htmlentities($_POST['montant']);
		//topographe creation
		$topographeManager = new TopographeManager($pdo);
		$lastId = $topographeManager->getLastId();
		if($lastId>=1){
			$code = 100+$lastId+1;
			$code = "T".$code;	
		}
		else{
			$code = "T101";
		}
		$topographe = new Topographe(array('nom'=>$nom, 'numeroTelefon'=>$numeroTelefon, 'montant'=>$montant, 'code'=>$code));
		$topographeManager->add($topographe);
		$_SESSION['topographe-success'] = "Le topographe est ajouté avec succès.";
		header('Location:../topographes.php');
    }
    else{
        $_SESSION['topographe-error'] = "Vous devez remplir au moins le champ <strong>Nom</strong>.";
		header('Location:../topographes.php');
    }
    