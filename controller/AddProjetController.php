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
	
	if(!empty($_POST['nomProjet']) and !empty($_POST['client'])){
		//add important classes managers
		$clientManager = new ClientArchitecteManager($pdo);	
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
		 if($idClient==0 and !empty($_POST['client'])){
		 	$client = new ClientArchitecte(array('nom'=>$nomClient, 'numeroTelefon'=>$telefonClient));
		 	$clientManager->add($client);
			$clientFromDb = $clientManager->getClientArchitecteById($clientManager->getLastId());
		 }
		 else{
		 	$clientFromDb = $clientManager->getClientArchitecteById($idClient);
		 }
		 $idClientFromDb = $clientFromDb->id();
		 /* ---------- Test if client exists in DB End */
		
		/* Get form fields & other processes End : ################################################# 
		 * here we get first all the form fields 
		 * 
		 * `id`, `leve`, `dateCreation`, `dateFin`, `nom`, `type`, `objet`, `prix`, 
		 * `paye`, `architecte`, `statut`, `titre`, `ilot`, `lot`, `idClient`
		 * */
		$projetManager = new ProjetManager($pdo);
		$projet = new Projet(array('leve'=>$leve, 'dateCreation'=>$dateCreation,'dateFin'=>$dateFin, 
		'nom'=>$nomProjet, 'type'=>$type, 'objet'=>$objet, 'prix'=>$prix, 'paye'=>$paye, 
		'architecte'=>$architecte, 'statut'=>$statut, 'titre'=>$titre, 'ilot'=>$ilot, 
		'lot'=>$lot, 'idClient'=>$idClientFromDb));
		$projetManager->add($projet);
		
		$_SESSION['projet-add-sucess']="Projet ajouté avec succès.";
		header('Location:../projets.php');	
	}
	else{
		$_SESSION['projet-add-error']="<strong>Erreur Projet</strong> : Vous devez remplir au moins 'Nom du Client' et 'Nom du Projet' .";
		header('Location:../projets-add.php');
	}
	
	
