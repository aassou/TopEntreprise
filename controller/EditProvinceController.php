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
	
	if(!empty($_POST['nom'])){
		$idProvince = $_GET['idProvince'];
		$nom = htmlentities($_POST['nom']);
		$provinceManager = new ProvinceManager($pdo);
		$province = new Province(array('id'=>$idProvince, 'nom'=>$nom));
		$provinceManager->update($province);
		$_SESSION['province-update-success'] = "Province modifiée avec succèes";
		header('Location:../provinces.php');
	}
	else{
		$_SESSION['province-update-error'] = "<strong>Erreur Modification Province : </strong>Vous devez remplir le 'Nom'";
		header('Location:../provinces.php');
	}
