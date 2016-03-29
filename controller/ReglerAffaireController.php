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
	
	$idRdv = htmlentities($_POST['idRdv']);
	if(!empty($_POST['client'])){
		//add important classes managers
		$clientManager = new ClientManager($pdo);
		$sourceManager = new SourceManager($pdo);
		$rendezVousManager = new RendezVousManager($pdo);		
		/* Get form fields begin processes : ################################################# 
		 * here we get first all the form fields 
		 * */
		//client informations
		$idClient = 0;
		if(!empty($_POST['idClient'])){
			$idClient = htmlentities($_POST['idClient']);	
		}
		$nomClient = htmlentities($_POST['client']);
		$cinClient = htmlentities($_POST['cin']);
		$telefonClient = htmlentities($_POST['numeroTelefon1']);
		$mandataire = htmlentities($_POST['mandataire']);
		//source informations
		$idSource = 0;
		if(!empty($_POST['idSource'])){
			$idSource = htmlentities($_POST['idSource']);	
		}
		$nomSource = htmlentities($_POST['source']);
		$telefonSource = htmlentities($_POST['numeroTelefon2']);
		$montantSource = htmlentities($_POST['montantSource']);
		//affaire informations
		$nature = htmlentities($_POST['natureTravail']);
		$dateRdv = htmlentities($_POST['dateRdv']);
		$heureRdv = htmlentities($_POST['heureRdv']);
		$dateSortie = htmlentities($_POST['dateSortie']);
		$prix = htmlentities($_POST['prix']);
		$paye = htmlentities($_POST['paye']);
		//zone informations
		$provinceInput = "";
		$municipalite = "";
		$commune = "";
		$quartierInput = "";
		$sousQuartierInput = "";
		$propriete = "";
		if(!empty($_POST['propriete'])){
			$propriete = htmlentities($_POST['propriete']);	
		}
		
		/* In this case it's supposed that Services and Topographes are all ready in our DB.
		 * So, here we don't add them automatically.
		 * */
		$idService = 0;
		if(!empty($_POST['idService'])){
			$idService = htmlentities($_POST['idService']);
		}
		$idTopographe = 0;
		if(!empty($_POST['idTopographe'])){
			$idTopographe = htmlentities($_POST['idTopographe']);
		}
		//We use Zero just to set other value than NULL in the DB
		$montantService = 0;
		$montantTopographe = 0;
		$montantSource = 0;
		if(!empty($_POST['montantService'])){
			$montantService = $_POST['montantService'];
		}
		if(!empty($_POST['montantTopographe'])){
			$montantTopographe = $_POST['montantTopographe'];
		}
		if(!empty($_POST['montantSource'])){
			$montantSource = $_POST['montantSource'];
		}
		
		/*If the CheckBox "Terminer et Archiver Affaire" isn't checked, the status of our affaire is "terminee",
		 * else the statuts is "Archivee", wich mean we can not modify some informations. 
		 */
		$statut = "terminee";
		if(!empty($_POST['archiver'])){
			$statut="archivee";
			
		}
		/* ---------- Test if client exists in DB Begin: 
		 * if no, add him to DB, 
		 * else do not add him ----- */
		 $clientFromDb = "";
		 if($idClient==0 and !empty($_POST['client'])){
		 	$client = new Client(array('nom'=>$nomClient, 'cin'=>$cinClient, 'numeroTelefon'=>$telefonClient));
		 	$clientManager->add($client);
			$clientFromDb = $clientManager->getClientById($clientManager->getLastId());
		 }
		 else{
		 	$clientFromDb = $clientManager->getClientById($idClient);
		 }
		 $idClientFromDb = $clientFromDb->id();
		 /* ---------- Test if client exists in DB End */
		 
		 /* ---------- Test if source exists in DB Begin: 
		 * if no, add him to DB, 
		 * else do not add him ----- */
		 $sourceFromDb = "";
		 if($idSource==0 and !empty($_POST['source'])){
		 	$code = "S101";
			$sourceLastId = $sourceManager->getLastId(); 
			if($sourceLastId >= 1){
				$code = "S".($sourceLastId+101);
			}
		 	$source = new Source(array('nom'=>$nomSource, 'numeroTelefon'=>$telefonSource, 'code'=>$code));
		 	$sourceManager->add($source);
			$sourceFromDb = $sourceManager->getSourceById($sourceManager->getLastId());
			$idSourceFromDb = $sourceFromDb->id();
		 }
		 else if($idSource!=0){
		 	$sourceFromDb = $sourceManager->getSourceById($idSource);
			$idSourceFromDb = $sourceFromDb->id();
		 }
		 else if($idSource==0 and empty($_POST['source'])){
		 	$idSourceFromDb = $idSource;
		 }
		 
		 /* ---------- Test if source exists in DB End */
		
		/* ---------- Test if zone inputs exist in DB Begin: 
		 * if no, add them to DB, 
		 * else do not add them ----- */
		//province processing begin
		if(empty($_POST['idProvince']) and !empty($_POST['province'])){
			$provinceInput = htmlentities($_POST['province']);
			$provinceManager = new ProvinceManager($pdo);
			if(!$provinceManager->exists2($provinceInput)){
				$province = new Province(array('nom'=>$provinceInput));
				$provinceManager->add($province);	
			}
		}
		//mp process begin
		if(empty($_POST['idMp']) and !empty($_POST['mp'])){
			$municipalite = htmlentities($_POST['mp']);
			$mpManager = new MunicipaliteManager($pdo);
			if(!$mpManager->exists2($municipalite)){
				$mp = new Municipalite(array('nom'=>$municipalite));
				$mpManager->add($mp);
			}
		}
		//cr process begin
		if(empty($_POST['idCr']) and !empty($_POST['cr'])){
			$commune = htmlentities($_POST['cr']);
			$crManager = new CommuneRuraleManager($pdo);
			if(!$crManager->exists2($commune)){
				$cr = new CommuneRurale(array('nom'=>$commune));
				$crManager->add($cr);
			}
		}
		//quartier process begin
		if(empty($_POST['idQuartier']) and !empty($_POST['quartier'])){
			$quartierInput = htmlentities($_POST['quartier']);
			$quartierManager = new QuartierManager($pdo);
			if(!$quartierManager->exists2($quartierInput)){
				$quartier = new Quartier(array('nom'=>$quartierInput));
				$quartierManager->add($quartier);
			}
		}
		//sousquartier process begin
		if(empty($_POST['idSousQuartier']) and !empty($_POST['sousquartier'])){
			$sousQuartierInput = htmlentities($_POST['sousquartier']);
			$sousQuartierManager = new SousQuartierManager($pdo);
			if(!$sousQuartierManager->exists2($sousQuartierInput)){
				$sousQuartier = new SousQuartier(array('nom'=>$sousQuartierInput));
				$sousQuartierManager->add($sousQuartier);
			}
		}
		//zone processing end
		/* ---------- Test if zone inputs exist in DB End --------------- */
		
		/* Get form fields & other processes End : ################################################# 
		 * here we get first all the form fields 
		 * */
		$affaireManager = new AffaireManager($pdo);
		$affaire = new Affaire(array('dateRdv'=>$dateRdv, 'heureRdv'=>$heureRdv,'dateSortie'=>$dateSortie, 
		'nature'=>$nature, 'prix'=>$prix, 'paye'=>$paye, 'mandataire'=>$mandataire, 'statut'=>$statut, 
		'idTopographe'=>$idTopographe, 'idSource'=>$idSourceFromDb, 'idService'=>$idService, 'idClient'=>$idClientFromDb, 
		'province'=>$provinceInput, 'mp'=>$municipalite, 'cr'=>$commune, 'quartier'=>$quartierInput, 
		'sousQuartier'=>$sousQuartierInput, 'propriete'=>$propriete, 'montantTopographe'=>$montantTopographe, 
		'montantSource'=>$montantSource, 'montantService'=>$montantService));
		$affaireManager->add($affaire);
		$rendezVousManager->terminerRendezVous($idRdv);
		$idAffaire = $affaireManager->getLastId();
		/* Affaire Folder and PDF creation begin 
		 * ############################################
		 * */
		if($statut=="archivee"){
			if(!file_exists('http://192.168.1.7/TopEntreprise/affaires/affaire'.$idAffaire)){
				mkdir("http://192.168.1.7/TopEntreprise/affaires/affaire".$idAffaire, 0777, true);
				chmod("http://192.168.1.7/TopEntreprise/affaires", 0777);
				chmod("http://192.168.1.7/TopEntreprise/affaires/affaire".$idAffaire, 0777);	
			}
			//multiple files upload begin
			$numberOfFilesUploaded = count($_FILES['documentsAffaire']['tmp_name']);
			for($i=0;$i<$numberOfFilesUploaded;$i++){
				$nameUpload = basename($_FILES['documentsAffaire']['name'][$i]);
				$nameUpload = uniqid().$nameUpload;
				move_uploaded_file($_FILES['documentsAffaire']['tmp_name'][$i], 'http://192.168.1.7/TopEntreprise/affaires/affaire'.$idAffaire.'/'.$nameUpload);
			}
			//multiple files upload end
			//---------------------- affaires pdf begin ----------------------------------------
			$topographeManager = new TopographeManager($pdo);
			$affaire = $affaireManager->getAffaireById($idAffaire);
			$client = $clientManager->getClientById($affaire->idClient());
			$topographeCode = "";
			$sourceCode = "";
			if($affaire->idTopographe()!="NULL" and $affaire->idTopographe()!=0){
				$topographe = $topographeManager->getTopographeById($affaire->idTopographe());
				$topographeCode = $topographe->code();	
			}
			if($affaire->idSource()!="NULL" and $affaire->idSource()!=0){
				$source = $sourceManager->getSourceById($affaire->idSource());
				$sourceCode = $source->code();	
			}
			ob_start();
			?>
			<style type="text/css">
				p{
					font-size : 16px;
					font-family : Arial;
				}
				span {
				    font-weight: bold;
				    text-decoration: underline;
				}
			</style>
			<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
			    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
			    <p style="font-size: 20px; text-align: right; text-decoration: underline"><span>Numéro Dossier</span> : <?php echo $affaire->id(); ?></p>
			    <br><br><br><br>
			    <p style="font-size: 20px; text-align: center;">
			    	<span>Nom du client</span> : <?php echo $client->nom(); ?>
			    </p>
			    <br><br><br>
			    <p style="text-align: center;"><span>Emplacement</span> : <?php echo $propriete; ?></p>
			    <br><br><br>
			    <p style="text-align: center;"><span>Municipalité / Commune rurale</span> : <?php echo $municipalite; echo " - ".$commune; ?> </p>
			    <br><br><br>
			    <p style="text-align: center;"><span>Nature du travail</span> : <?php echo $affaire->nature(); ?></p> 
				<br><br><br><br><br><br>
				<p><span>Source</span> : <?php echo $sourceCode; ?></p>
				<br>
				<p><span>Topographe</span> : <?php echo $topographeCode; ?></p>
				<br>
				<p style="text-align: right"><span>Num.Tél Client</span> : <?php echo $client->numeroTelefon(); ?></p>
				<br><br><br><br><br><br><br><br><br><br><br><br><br>
				<p style="text-align: center"><span>Date de sortie</span> : <?php echo date('d-m-Y',strtotime($dateSortie)); ?></p>
			</page>
			<?php
				$content = ob_get_clean();
			    require('../lib/html2pdf/html2pdf.class.php');
			    try{
			        $pdf = new HTML2PDF('P', 'A4', 'fr');
			        $pdf->pdf->SetDisplayMode('fullpage');
			        $pdf->writeHTML($content);
					$document = "http://192.168.1.7/TopEntreprise/affaires/affaire".$idAffaire."/rapport-affaire".date('Y-m-d-h-i').".pdf";
			        $pdf->Output($document, 'F');
			    }
			    catch(HTML2PDF_exception $e){
			        die($e->getMessage());
			    }
			//---------------------- affaires pdf end   ----------------------------------------
		}
		/* Affaire Folder and PDF creation begin 
		 * ############################################
		 * */
		$_SESSION['affaire-regler-sucess']="Affaire réglée avec succès.";
		header('Location:../affaires.php');	
	}
	else{
		$_SESSION['affaire-regler-error']="Vous devez remplir la <strong>Date de sortie</strong>.";
		header('Location:../terminer-affaire.php?idRdv='.$idRdv);
	}
	
	
