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
    if(!empty($_POST['searchMonthYearFacture']) and !empty($_POST['searchCategorieFacture'])){
		$moisAnnee = htmlentities($_POST['searchMonthYearFacture'])	;
		$categorie = htmlentities($_POST['searchCategorieFacture']);
		$facturesManager = new FacturesManager($pdo);
		$_SESSION['searchFactureResult'] = $facturesManager->getFacturesBySearch($categorie, $moisAnnee);
		header('Location:../factures-search.php');
    }
    else{
        $_SESSION['facture-search-error'] = 
        "<strong>Erreur Facture</strong> : Vous devez remplir la zone 'Mois-Année'";
		header('Location:../factures-search.php');
    }
    
    