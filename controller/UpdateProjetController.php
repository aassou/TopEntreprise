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
	
	$idProjet = htmlentities($_POST['idProjet']);
	if(!empty($_POST['nomProjet']) and !empty($_POST['client'])){
		//add important classes managers
		$clientManager = new ClientArchitecteManager($pdo);
		$projetManager = new ProjetManager($pdo);	
		/* Get form fields begin processes : ################################################# 
		 * here we get first all the form fields 
		 * */
		//client informations
		$idClient = 0;
		if(!empty($_POST['idClient'])){
			$idClient = htmlentities($_POST['idClient']);	
		}
		$nomClient = htmlentities($_POST['client']);
		$telefonClient = htmlentities($_POST['numeroTelefon1']);
		//projet informations
		$nomProjet = htmlentities($_POST['nomProjet']);
		$leve = htmlentities($_POST['leve']);
		$titre = htmlentities($_POST['titre']);
		$architecte = htmlentities($_POST['architecte']);
		$type = htmlentities($_POST['type']);
		$objet = htmlentities($_POST['objet']);
		$ilot = htmlentities($_POST['ilot']);
		$lot = htmlentities($_POST['lot']);
		$prix = htmlentities($_POST['prix']);
		$paye = htmlentities($_POST['paye']);
		$dateCreation = htmlentities($_POST['dateCreation']);
		$dateFin = htmlentities($_POST['dateFin']);
		$statut = "encours";
		
		/* ---------- Test if client exists in DB Begin: 
		 * if no, add him to DB, 
		 * else do not add him ----- */
		 $clientFromDb = "";
		 $newClientId = $clientManager->getClientArchitecteById($projetManager->getProjetById($idProjet)->idClient())->id();
		 $nomClientFromDb = $clientManager->getClientArchitecteById($projetManager->getProjetById($idProjet)->idClient())->nom(); 
		 if($nomClientFromDb!=$nomClient and $idClient==0 and !empty($_POST['client'])){
		 	$client = new ClientArchitecte(array('nom'=>$nomClient, 'numeroTelefon'=>$telefonClient));
		 	$clientManager->add($client);
			$clientFromDb = $clientManager->getClientArchitecteById($clientManager->getLastId());
			$newClientId = $clientFromDb->id();
		 }
		 else if($nomClientFromDb!=$nomClient and $idClient!=0){
		 	$clientFromDb = $clientManager->getClientArchitecteById($idClient);
			$newClientId = $clientFromDb->id();
		 }
		 /* ---------- Test if client exists in DB End */
		
		/* Get form fields & other processes End : ################################################# 
		 * here we get first all the form fields
		 * */
		$projet = new Projet(array('id'=>$idProjet, 'leve'=>$leve, 'dateCreation'=>$dateCreation,'dateFin'=>$dateFin, 
		'nom'=>$nomProjet, 'type'=>$type, 'objet'=>$objet, 'prix'=>$prix, 'paye'=>$paye, 
		'architecte'=>$architecte, 'statut'=>$statut, 'titre'=>$titre, 'ilot'=>$ilot, 
		'lot'=>$lot, 'idClient'=>$newClientId));
		$projetManager->update($projet);
		
		$_SESSION['projet-update-sucess']="Projet modifié avec succès.";
		header('Location:../projets.php');	
	}
	else{
		$_SESSION['projet-update-error']="<strong>Erreur Projet</strong> : Vous devez remplir au moins 'Nom du Client' et 'Nom du Projet' .";
		header('Location:../modifier-projet.php?idProjet='.$idProjet);
	}
	
	
