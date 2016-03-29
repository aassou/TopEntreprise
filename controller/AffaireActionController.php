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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //Component Class Manager
    $affaireManager = new AffaireManager($pdo);
    $historyManager = new HistoryManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        $numero = htmlentities($_POST['numero']);
        if ( $affaireManager->exists($numero)  ) {
            $actionMessage = "Erreur Ajout affaire : Une affaire existe déjà avec ce Numéro : <strong>".$numero."</strong>.";
            $typeMessage = "error";
            header('Location:../add-affaire.php');
            exit();
        }
        if( !empty($_POST['nomClient']) ){
			//add important classes managers
            $clientManager = new ClientManager($pdo);
            $sourceManager = new SourceManager($pdo);
            $rendezVousManager = new RendezVousManager($pdo);       
            /* Get form fields begin processes : ################################################# 
             * here we get first all the form fields 
             * */
            //client informations
            $nomClient = htmlentities($_POST['nomClient']);
            $cinClient = htmlentities($_POST['cinClient']);
            $telephonClient = htmlentities($_POST['telephoneClient']);
            $mandataire = htmlentities($_POST['mandataire']);
            //source informations
            $nomSource = htmlentities($_POST['nomSource']);
            $telephoneSource = htmlentities($_POST['telephoneSource']);
            $montantSource = htmlentities($_POST['montantSource']);
            //service informations
            $nomService = htmlentities($_POST['nomService']);
            //$telephoneService = htmlentities($_POST['telephoneService']);
            $montantService = htmlentities($_POST['montantService']);
            //topographe informations
            $nomTopographe = htmlentities($_POST['nomTopographe']);
            //$telephoneTopographe = htmlentities($_POST['telephoneTopographe']);
            $montantTopographe = htmlentities($_POST['montantTopographe']);
            //affaire informations
            $nature = htmlentities($_POST['natureTravail']);
            $dateRdv = htmlentities($_POST['dateRdv']);
            $heureRdv = htmlentities($_POST['heureRdv']);
            $dateSortie = htmlentities($_POST['dateSortie']);
            if ( empty($dateSortie) ) {
                $dateSortie = htmlentities($_POST['dateRdv']);
            }
            $prix = htmlentities($_POST['prix']);
            $paye = htmlentities($_POST['paye']);
            //zone informations
            $province = "";
            $municipalite = "";
            $commune = "";
            $quartier = "";
            $sousQuartier = "";
            $propriete = "";
            if ( !empty($_POST['propriete']) ) {
                $propriete = htmlentities($_POST['propriete']); 
            }
            $status = htmlentities($_POST['status']);
            /* ---------- Test if zone inputs exist in DB Begin: 
             * if no, add them to DB, 
             * else do not add them ----- */
            //province processing begin
            $province = htmlentities($_POST['province']);
            if ( empty($_POST['idProvince']) and !empty($_POST['province']) ) {
                $provinceManager = new ProvinceManager($pdo);
                if ( !$provinceManager->exists2($province) ) {
                    //$province = new Province(array('nom'=>$province));
                    $provinceManager->add(new Province(array('nom'=>$province)));   
                }
            }
            //mp process begin
            $municipalite = htmlentities($_POST['mp']);
            if ( empty($_POST['idMp']) and !empty($_POST['mp']) ) {
                $mpManager = new MunicipaliteManager($pdo);
                if ( !$mpManager->exists2($municipalite) ) {
                    $mp = new Municipalite(array('nom'=>$municipalite));
                    $mpManager->add($mp);
                }
            }
            //cr process begin
            $commune = htmlentities($_POST['cr']);
            if ( empty($_POST['idCr']) and !empty($_POST['cr']) ) {
                $crManager = new CommuneRuraleManager($pdo);
                if ( !$crManager->exists2($commune) ) {
                    $cr = new CommuneRurale(array('nom'=>$commune));
                    $crManager->add($cr);
                }
            }
            //quartier process begin
            $quartier = htmlentities($_POST['quartier']);
            if ( empty($_POST['idQuartier']) and !empty($_POST['quartier']) ) {
                $quartierManager = new QuartierManager($pdo);
                if ( !$quartierManager->exists2($quartier) ) {
                    //$quartier = new Quartier(array('nom'=>$quartier));
                    $quartierManager->add(new Quartier(array('nom'=>$quartier)));
                }
            }
            //sousquartier process begin
            $sousQuartier = htmlentities($_POST['sousquartier']);
            if ( empty($_POST['idSousQuartier']) and !empty($_POST['sousquartier']) ) {
                $sousQuartierManager = new SousQuartierManager($pdo);
                if ( !$sousQuartierManager->exists2($sousQuartier) ) {
                    //$sousQuartier = new SousQuartier(array('nom'=>$sousQuartier));
                    $sousQuartierManager->add(new SousQuartier(array('nom'=>$sousQuartier)));
                }
            }
            //zone processing end
            /* ---------- Test if zone inputs exist in DB End --------------- */
            /* Get form fields & other processes End : ################################################# 
             * here we get first all the form fields 
             * */
			$createdBy = $_SESSION['user']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $affaire = new Affaire(array(
                'numero' => $numero,
				'dateRdv' => $dateRdv,
				'heureRdv' => $heureRdv,
				'dateSortie' => $dateSortie,
				'nature' => $nature,
				'prix' => $prix,
				'paye' => $paye,
				'nomClient' => $nomClient,
				'cinClient' => $cinClient,
				'telephoneClient' => $telephonClient,
				'mandataire' => $mandataire,
				'status' => $status,
				'province' => $province,
				'mp' => $municipalite,
				'cr' => $commune,
				'quartier' => $quartier,
				'sousquartier' => $sousQuartier,
				'propriete' => $propriete,
				'nomTopographe' => $nomTopographe,
				'montantTopographe' => $montantTopographe,
				'nomService' => $nomService,
				'montantService' => $montantService,
				'nomSource' => $nomSource,
				'telephoneSource' => $telephoneSource,
				'montantSource' => $montantSource,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $affaireManager->add($affaire);
            //Data traceability Begin
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des affaires",
                'description' => "Ajout Nouvelle Affaire = N°Affaire : ".$numero."- Client : ".$nomClient." - CIN Client : ".$cinClient." - Nature Travail : ".$nature." - Date Rdv/Sortie : ".$dateRdv,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //print_r($affaire);
            //print_r($history);
            $historyManager->add($history);
            //Data traceability End
            $actionMessage = "<strong>Opération Valide</strong> : Affaire Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Ajout Affaire</strong> : Vous devez remplir le champ 'Client'.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../add-affaire.php";
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idAffaire = htmlentities($_POST['idAffaire']);
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        $numero = htmlentities($_POST['numero']);
        if(!empty($_POST['dateRdv'])){
			$dateRdv = htmlentities($_POST['dateRdv']);
			$heureRdv = htmlentities($_POST['heureRdv']);
			$dateSortie = htmlentities($_POST['dateSortie']);
			$nature = htmlentities($_POST['nature']);
			$prix = htmlentities($_POST['prix']);
			$paye = htmlentities($_POST['paye']);
            $nomClient = htmlentities($_POST['nomClient']);
            $cinClient = htmlentities($_POST['cinClient']);
            $telephoneClient = htmlentities($_POST['telephoneClient']);
			$mandataire = htmlentities($_POST['mandataire']);
			$status = htmlentities($_POST['status']);
			//$idTopographe = htmlentities($_POST['idTopographe']);
			//$idSource = htmlentities($_POST['idSource']);
			//$idService = htmlentities($_POST['idService']);
			//$idClient = htmlentities($_POST['idClient']);
			$province = htmlentities($_POST['province']);
			$mp = htmlentities($_POST['mp']);
			$cr = htmlentities($_POST['cr']);
			$quartier = htmlentities($_POST['quartier']);
			$sousquartier = htmlentities($_POST['sousquartier']);
			$propriete = htmlentities($_POST['propriete']);
            $nomTopographe = htmlentities($_POST['nomTopographe']);
			$montantTopographe = htmlentities($_POST['montantTopographe']);
            $nomService = htmlentities($_POST['nomService']);
			$montantService = htmlentities($_POST['montantService']);
            $nomSource = htmlentities($_POST['nomSource']);
            $telephoneSource = htmlentities($_POST['telephoneSource']);
			$montantSource = htmlentities($_POST['montantSource']);
			$updatedBy = $_SESSION['user']->login();
            $updated = date('Y-m-d h:i:s');
            $affaire = new Affaire(array(
				'id' => $idAffaire,
				'numero' => $numero, 
				'dateRdv' => $dateRdv,
				'heureRdv' => $heureRdv,
				'dateSortie' => $dateSortie,
				'nature' => $nature,
				'prix' => $prix,
				'paye' => $paye,
				'nomClient' => $nomClient,
                'cinClient' => $cinClient,
                'telephoneClient' => $telephoneClient,
				'mandataire' => $mandataire,
				'status' => $status,
				'province' => $province,
				'mp' => $mp,
				'cr' => $cr,
				'quartier' => $quartier,
				'sousquartier' => $sousquartier,
				'propriete' => $propriete,
				'nomTopographe' => $nomTopographe,
                'montantTopographe' => $montantTopographe,
                'nomService' => $nomService,
                'montantService' => $montantService,
                'nomSource' => $nomSource,
                'telephoneSource' => $telephoneSource,
                'montantSource' => $montantSource,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $affaireManager->update($affaire);
            $actionMessage = "<strong>Opération Valide </strong>: Affaire Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "<strong>Erreur Modification Affaire</strong> : Vous devez remplir le champ 'dateRdv'.";
            $typeMessage = "error";
        }
        $redirectLink = "Location:../affaire-update.php?idAffaire=".$idAffaire."&mois=".$mois."&annee=".$annee;
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idAffaire = htmlentities($_POST['idAffaire']);
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $affaireManager->delete($idAffaire);
        $actionMessage = "<strong>Opération Valide</strong> : Affaire supprimé(e) avec succès.";
        $typeMessage = "success";
        $redirectLink = "Location:../affaires.php?mois=".$mois."&annee=".$annee;
    }
    //Action Delete Processing End
    $_SESSION['affaire-action-message'] = $actionMessage;
    $_SESSION['affaire-type-message'] = $typeMessage;
    header($redirectLink);

