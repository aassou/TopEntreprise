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
		//test if the client exists
		/*$idClient = 0;
		if(!empty($_POST['idClient'])){
			$idClient = htmlentities($_POST['idClient']);
		}
		$clientManager = new ClientManager($pdo);
		$client = "";
		if($clientManager->exists($idClient)){
			$client = $clientManager->getClientById($idClient);
		}
		else{
			$client = new Client(array('nom'=>$nom, 'cin'=>$cin, 'numeroTelefon'=>$numeroTelefon1));
			$clientManager->add($client);
			$idClient = $clientManager->getLastId();
			$client = $clientManager->getClientById($idClient);
		}*/
		
		//test if the source exists
		/*
		$idSource = 0;
		if(!empty($_POST['idSource'])){
			$idSource = htmlentities($_POST['idSource']);
		}
		$sourceManager = new SourceManager($pdo);
		$source = "";
		if($sourceManager->exists($idSource)){
			$source = $sourceManager->getSourceById($idSource);
		}
		else{
			$lastId = $sourceManager->getLastId();
			if($lastId>=1){
				$code = 100+$lastId+1;
				$code = "S".$code;	
			}
			else{
				$code = "S101";
			}
			$source = new Source(array('nom'=>$nom, 'numeroTelefon'=>$numeroTelefon2, 'code'=>$code));
			$sourceManager->add($source);
			$idSource = $sourceManager->getLastId();
			$source = $sourceManager->getSourceById($idSource);
		}
		*/
		//province process begin
		if(empty($_POST['idProvince']) and !empty($_POST['province'])){
			$provinceManager = new ProvinceManager($pdo);
			if(!$provinceManager->exists2($provinceInput)){
				$province = new Province(array('nom'=>$provinceInput));
				$provinceManager->add($province);	
			}
		}
		
		//province process end
		//mp process begin
		if(empty($_POST['idMp']) and !empty($_POST['municipalite'])){
			$mpManager = new MunicipaliteManager($pdo);
			if(!$mpManager->exists2($municipalite)){
				$mp = new Municipalite(array('nom'=>$municipalite));
				$mpManager->add($mp);	
			}
		}
		//mp process end
		//cr process begin
		if(empty($_POST['idCr']) and !empty($_POST['commune'])){
			$crManager = new CommuneRuraleManager($pdo);
			if(!$crManager->exists2($commune)){
				$cr = new CommuneRurale(array('nom'=>$commune));
				$crManager->add($cr);	
			}
		}
		//cr process end
		//quartier process begin
		if(empty($_POST['idQuartier']) and !empty($_POST['quartier'])){
			$quartierManager = new QuartierManager($pdo);
			if(!$quartierManager->exists2($quartierInput)){
				$quartier = new Quartier(array('nom'=>$quartierInput));
				$quartierManager->add($quartier);	
			}
		}
		//quartier process end
		//add affaire class elements
		$rendezVous = new RendezVous(array('nomClient'=>$nom, 'cin'=>$cin, 'telefonClient'=>$numeroTelefon1,
		'source'=>$source,'telefonSource'=>$numeroTelefon2, 'dateRdv'=>$dateSortie, 'heureRdv'=>$heureRdv, 'nature'=> $natureTravail, 'prix'=>$prix,
		'mandataire'=>$mandataire, 'statut'=>"encours", 'province'=>$provinceInput, 'mp'=>$municipalite, 
		'cr'=>$commune, 'quartier'=>$quartierInput));
		$rendezVousManager = new RendezVousManager($pdo);
		$rendezVousManager->add($rendezVous);
		
		//validation
		$_SESSION['rendez-vous-success'] = "Le rendez-vous est ajouté avec succès.";
		header('Location:../add-rendez-vous.php');
    }
    else{
        $_SESSION['rendez-vous-error'] = 
        "<strong>Erreur Rendez-vous</strong> : Vous devez remplir au moins les champs 'Nom du client', 'Date de sortie'";
		header('Location:../add-rendez-vous.php');
    }
    
    