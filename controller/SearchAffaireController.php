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
    $testRadio = 0;	    
    //post input processing
    if((!empty($_POST['searchOptionAffaire']) and !empty($_POST['searchAffaire']))
	or ($_POST['searchOptionAffaire']=="searchAffaireByReste")){
		if(isset($_POST['searchOptionAffaire'])){
			if($_POST['searchOptionAffaire']=="searchAffaireByNumeroAffaire"){
				$testRadio = 1;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireByNomClient"){
				$testRadio = 2;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireByReste"){
				$testRadio = 3;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireByQuartier"){
				$testRadio = 4;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireByMois"){
				$testRadio = 5;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireBySource"){
				$testRadio = 6;	
			}
			else if($_POST['searchOptionAffaire']=="searchAffaireByTopographe"){
				$testRadio = 7;	
			}
		}
		$recherche = htmlentities($_POST['searchAffaire']);
		$affaireManager = new AffaireManager($pdo);
		$_SESSION['searchAffaireResult'] = $affaireManager->getAffaireBySearch($recherche, $testRadio);
		header('Location:../affaires-search.php');
    }
    else{
        $_SESSION['affaire-search-error'] = 
        "<strong>Erreur Affaire</strong> : Vous devez séléctionner un choix et 'Tapez votre recherche'";
		header('Location:../affaires-search.php');
    }
    
    