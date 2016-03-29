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
	
	$idAffaire = htmlentities($_POST['idAffaire']);
	if(!empty($_POST['dateSortie']) and !empty($_POST['client'])){
		//add important classes managers
		$clientManager = new ClientManager($pdo);
		$sourceManager = new SourceManager($pdo);
		$affaireManager = new AffaireManager($pdo);		
		//get some informations :)
		$affaire = $affaireManager->getAffaireById($idAffaire);
		$client = $clientManager->getClientById($affaire->idClient());
		$source = "";
		$newSourceId = 0;
		if($affaire->idSource()!="NULL" and $affaire->idSource()!=0){
			$source = $sourceManager->getSourceById($affaire->idSource());
			$newSourceId = $source->id();	
		}
		/* Get form fields begin processes : ################################################# 
		 * here we get first all the form fields 
		 * */
		//client informations
		$idClient = 0; //this id contains the id added by script.js in case of autocompletion
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
		if($affaire->idService()!="NULL" and $affaire->idService()!=0){
			$idService = $affaire->idService();	
		}
		if(!empty($_POST['idService'])){
			$idService = htmlentities($_POST['idService']);
		}
		$idTopographe = 0;
		if($affaire->idTopographe()!="NULL" and $affaire->idTopographe()!=0){
			$idTopographe = $affaire->idTopographe();
		}
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
		$statut = "";
		$statutParameter = 0;
		if($affaire->statut()=="archivee"){
			$statut = "archivee";
			$statutParameter = 1;
		}
		else if($affaire->statut()=="terminee"){
			if(!empty($_POST['archiver'])){
				$statut="archivee";
				$statutParameter = 2;
			}	
			else{
				$statut="terminee";
			}
		}
		/* ---------- Client Process Begin:  ------------ */
		/*First thing, we get the client id of our "affaire",
		 * we use this id to save the previous client id,
		 * if of our input is the same and didn't changed nothing will be happend
		 * */
		 $newClientId = $client->id();
		 $clientFromDb = "";
		 //else if our input field changed and doesn't exist in our DB, we add the new Client to DB
		 if($client->nom()!=$_POST['client'] and $idClient==0 and !empty($_POST['client'])){
		 	$client = new Client(array('nom'=>$nomClient, 'cin'=>$cinClient, 'numeroTelefon'=>$telefonClient));
		 	$clientManager->add($client);
			$clientFromDb = $clientManager->getClientById($clientManager->getLastId());
			$newClientId = $clientFromDb->id();
		 }
		 //else if our input field changed and it exists in our DB, we just get it to update 
		 //the client id in the "affaire"
		 else if($client->nom()!=$_POST['client'] and $idClient!=0){
		 	$clientFromDb = $clientManager->getClientById($idClient);
			$newClientId = $clientFromDb->id();
			$clientManager->update(new Client(array('id'=>$newClientId, 'nom'=>$nomClient, 
			'cin'=>$cinClient, 'numeroTelefon'=>$telefonClient)));
		 }
		 else{
		 	$clientFromDb = $clientManager->getClientById($newClientId);
		 	$clientManager->update(new Client(array('id'=>$newClientId, 'nom'=>$nomClient, 
			'cin'=>$cinClient, 'numeroTelefon'=>$telefonClient)));
		 }
		 /* ---------- Client Process End */
		 /* ---------- Source Process Begin */
		 /*First thing, we get the source id of our "affaire",
		 * we use this id to save the previous source id,
		 * if of our input is the same and didn't changed nothing will be happend
		 * */
		 $sourceFromDb = "";
		 if((bool)$source){
			 if($source->nom()!=$_POST['source'] and $idSource==0 and !empty($_POST['source'])){
			 	$code = "S101";
				$sourceLastId = $sourceManager->getLastId(); 
				if($sourceLastId >= 1){
					$code = "S".($sourceLastId+101);
				}
			 	$source = new Source(array('nom'=>$nomSource, 'numeroTelefon'=>$telefonSource, 'code'=>$code));
			 	$sourceManager->add($source);
				$sourceFromDb = $sourceManager->getSourceById($sourceManager->getLastId());
				$newSourceId = $sourceFromDb->id();
			 }
			 else if($source->nom()!=$_POST['source'] and $idSource!=0){
			 	$sourceFromDb = $sourceManager->getSourceById($idSource);
				$newSourceId = $sourceFromDb->id();
			 }
		 }
		 /* ---------- Test if source exists in DB End */
		
		/* ---------- Test if zone inputs exist in DB Begin: 
		 * if no, add them to DB, 
		 * else do not add them ----- */
		//province processing begin
		$provinceInput = htmlentities($_POST['province']);
		if($affaire->province()!=$_POST['province'] and empty($_POST['idProvince']) and !empty($_POST['province'])){
			$provinceManager = new ProvinceManager($pdo);
			if(!$provinceManager->exists2($provinceInput)){
				$province = new Province(array('nom'=>$provinceInput));
				$provinceManager->add($province);	
			}
		}
		//mp process begin
		$municipalite = htmlentities($_POST['mp']);
		if($affaire->mp()!=$_POST['mp'] and empty($_POST['idMp']) and !empty($_POST['mp'])){
			$mpManager = new MunicipaliteManager($pdo);
			if(!$mpManager->exists2($municipalite)){
				$mp = new Municipalite(array('nom'=>$municipalite));
				$mpManager->add($mp);
			}
		}
		//cr process begin
		$commune = htmlentities($_POST['cr']);
		if($affaire->cr()!=$_POST['cr'] and empty($_POST['idCr']) and !empty($_POST['cr'])){
			$crManager = new CommuneRuraleManager($pdo);
			if(!$crManager->exists2($commune)){
				$cr = new CommuneRurale(array('nom'=>$commune));
				$crManager->add($cr);
			}
		}
		//quartier process begin
		$quartierInput = htmlentities($_POST['quartier']);
		if($affaire->quartier()!=$_POST['quartier'] and empty($_POST['idQuartier']) and !empty($_POST['quartier'])){
			$quartierManager = new QuartierManager($pdo);
			if(!$quartierManager->exists2($quartierInput)){
				$quartier = new Quartier(array('nom'=>$quartierInput));
				$quartierManager->add($quartier);
			}
		}
		//sousquartier process begin
		$sousQuartierInput = htmlentities($_POST['sousquartier']);
		if($affaire->sousQuartier()!=$_POST['sousquartier'] and empty($_POST['idSousQuartier']) and !empty($_POST['sousquartier'])){
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
		$affaire = new Affaire(array('id'=>$idAffaire, 'dateRdv'=>$dateRdv, 'heureRdv'=>$heureRdv,'dateSortie'=>$dateSortie, 
		'nature'=>$nature, 'prix'=>$prix, 'paye'=>$paye, 'mandataire'=>$mandataire, 'statut'=>$statut, 
		'idTopographe'=>$idTopographe, 'idSource'=>$newSourceId, 'idService'=>$idService, 'idClient'=>$newClientId, 
		'province'=>$provinceInput, 'mp'=>$municipalite, 'cr'=>$commune, 'quartier'=>$quartierInput, 
		'sousQuartier'=>$sousQuartierInput, 'propriete'=>$propriete, 'montantTopographe'=>$montantTopographe, 
		'montantSource'=>$montantSource, 'montantService'=>$montantService));
		$affaireManager->update($affaire);
		/* Affaire Folder and PDF creation begin 
		 * ############################################
		 * */
		//if the affaire status was "terminee" and changed to "archivee", we have to show on 
		//the multiple folder upload button and create the affaire folder and generate the pdf
		if($statut=="archivee" and $statutParameter==2){
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
			    <p style="text-align: center;"><span>Municipalité / Commune rurale</span> : <?php echo $municipalite; echo $commune; ?> </p>
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
		//if the status of our affaire is already "archivee", we can add files to our directory
		//without changing the status of our affaire
		else if($statut=="archivee" and $statutParameter==1){
			if(file_exists('../affaires/affaire'.$idAffaire)){
				//multiple files upload begin
				$numberOfFilesUploaded = count($_FILES['documentsAffaire']['tmp_name']);
				for($i=0;$i<$numberOfFilesUploaded;$i++){
					$nameUpload = basename($_FILES['documentsAffaire']['name'][$i]);
					$nameUpload = uniqid().$nameUpload;
					move_uploaded_file($_FILES['documentsAffaire']['tmp_name'][$i], 'http://192.168.1.7/TopEntreprise/affaires/affaire'.$idAffaire.'/'.$nameUpload);
				}	
			}
		}
		/* Affaire Folder and PDF creation end 
		 * ############################################
		 * */
		$_SESSION['affaire-regler-sucess']="Affaire réglée avec succès.";
		header('Location:../affaires.php');	
	}
	else{
		$_SESSION['affaire-regler-error']="Vous devez remplir la <strong>Date de sortie</strong>.";
		header('Location:../archive-affaire.php?idAffaire='.$idAffaire);
	}
	
	
