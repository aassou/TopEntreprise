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
    if(!empty($_POST['searchOption']) and !empty($_POST['search'])){
		$testRadio = 0;	    
		if(isset($_POST['searchOption'])){
			if($_POST['searchOption']=="searchByName"){
				$testRadio = 1;	
			}
			else if($_POST['searchOption']=="searchByCode"){
				$testRadio = 2;	
			}
		}
		$recherche = htmlentities($_POST['search']);
		$sourceManager = new SourceManager($pdo);
		$_SESSION['searchSourceResult'] = $sourceManager->getSourceBySearch($recherche, $testRadio);
		header('Location:../sources-search.php');
    }
    else{
        $_SESSION['source-search-error'] = 
        "<strong>Erreur Source</strong> : Vous devez séléctionner un choix 'Nom' ou 'Code' 
        et 'Tapez votre recherche'";
		header('Location:../sources-search.php');
    }
    
    