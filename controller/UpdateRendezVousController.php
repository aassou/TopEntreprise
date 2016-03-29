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
    $idRdv = $_POST['idRdv'];
    if(!empty($_POST['client']) and !empty($_POST['dateSortie'])){    
		$nom = htmlentities($_POST['client']);
		$cin = htmlentities($_POST['cin']);
		$source = htmlentities($_POST['source']);
		$dateSortie = htmlentities($_POST['dateSortie']);
		$heureRdv = htmlentities($_POST['heureRdv']);
		$numeroTelefon1 = htmlentities($_POST['numeroTelefon1']);
		$mandataire = htmlentities($_POST['mandataire']);
		$numeroTelefon2 = htmlentities($_POST['numeroTelefon2']);
		//$zone = htmlentities($_POST['zone']);
		$natureTravail = htmlentities($_POST['natureTravail']);
		$prix = htmlentities($_POST['prix']);
		$provinceInput = "";
		$municipalite = "";
		$commune = "";
		$quartierInput = "";
		if(!empty($_POST['province'])){
			$provinceInput = htmlentities($_POST['province']);
		}
		if(!empty($_POST['municipalite'])){
			$municipalite = htmlentities($_POST['municipalite']);	
		}
		if(!empty($_POST['commune'])){
			$commune = htmlentities($_POST['commune']);	
		}
		if(!empty($_POST['quartier'])){
			$quartierInput = htmlentities($_POST['']);	
		}
		
		//add affaire class elements
		$rendezVous = new RendezVous(array('id'=>$idRdv, 'nomClient'=>$nom, 'cin'=>$cin, 'telefonClient'=>$numeroTelefon1,
		'source'=>$source,'telefonSource'=>$numeroTelefon2, 'dateRdv'=>$dateSortie, 'heureRdv'=>$heureRdv, 'nature'=> $natureTravail, 'prix'=>$prix,
		'mandataire'=>$mandataire, 'statut'=>"encours", 'province'=>$provinceInput, 'mp'=>$municipalite, 
		'cr'=>$commune, 'quartier'=>$quartierInput));
		$rendezVousManager = new RendezVousManager($pdo);
		$rendezVousManager->update($rendezVous);
		
		//validation
		$_SESSION['rendez-vous-update-success'] = "Le rendez-vous est modifé avec succès.";
		header('Location:../rendez-vous.php');
    }
    else{
        $_SESSION['rendez-vous-error'] = 
        "<strong>Erreur Rendez-vous</strong> : Vous devez remplir au moins les champs 'Nom du client', 'Date de sortie'";
		header('Location:../update-rendez-vous.php?idRdv='.$idRdv);
    }
    
    