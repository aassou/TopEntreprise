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
    if(!empty($_POST['searchOptionTopographe']) and !empty($_POST['searchTopographe'])){
		$testRadio = 0;	    
		if(isset($_POST['searchOptionTopographe'])){
			if($_POST['searchOptionTopographe']=="searchTopographeByName"){
				$testRadio = 1;	
			}
			else if($_POST['searchOptionTopographe']=="searchTopographeByCode"){
				$testRadio = 2;	
			}
		}
		$recherche = htmlentities($_POST['searchTopographe']);
		$topographeManager = new TopographeManager($pdo);
		$_SESSION['searchTopographeResult'] = $topographeManager->getTopographeBySearch($recherche, $testRadio);
		header('Location:../topographes-search.php');
    }
    else{
        $_SESSION['topographe-search-error'] = 
        "<strong>Erreur Topographe</strong> : Vous devez séléctionner un choix 'Nom' ou 'Code' 
        et 'Tapez votre recherche'";
		header('Location:../topographes-search.php');
    }
    
    