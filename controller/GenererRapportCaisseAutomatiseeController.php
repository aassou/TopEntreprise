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
	//set managers
	$entreesManager = new EntreesManager($pdo);
	$sortiesManager = new SortiesManager($pdo);
	//set classes
	$dateOperation = date('h:i | Y-m-d');
	//include("printed-documents/rapport-caisse-pdf.php");
	//-----------------------------------------------------------------------
		$affairesManager = new AffaireManager($pdo);
			$chargesManager = new ChargesManager($pdo);
			$cnssManager = new CnssManager($pdo);
			$comptableManager = new ComptableManager($pdo);
			$salairesManager = new SalairesManager($pdo);
			$voitureManager = new VoitureManager($pdo);
			$observationManager = new ObservationManager($pdo);
			//get all charges and paye
			$entreesKarim = 0;
			$entreesMohamed = $affairesManager->getTotalPaye();
			$sortiesKarim = 0;
			$sortiesMohamed = $chargesManager->getTotalCharges()+$cnssManager->getTotalChargesCnss()
			+$comptableManager->getTotalChargesComptable()+$salairesManager->getTotalChargesSalaires()
			+$voitureManager->getTotalChargesVoiture()+$observationManager->getTotalChargesObservation();
			//get totaux des entrees et sorties
			$entreesKarimTotal = 0;
			$entreesMohamedTotal = $entreesMohamed;
			$sortiesKarimTotal = 0;
			$sortiesMohamedTotal = $sortiesMohamed;
			//moyennes
			$moyenne = ($entreesKarimTotal + $entreesMohamedTotal)/2;

		ob_start();
	?>
	<style type="text/css">
		table {
		    border-collapse: collapse;
		    width:100%
		}
		
		table, th, td {
		    border: 1px solid black;
		}
		td, th{
			padding : 5px;
		}
		td{
			width: 25%;
		}
		th{
			background-color: grey;
		}
	</style>
	<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
	    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
		<h2 style="text-align: center; text-decoration: underline">Rapport de la caisse</h2>
		<h3 style="text-align: center; text-decoration: underline">Les affaires payées et les charges : Topographie et Architecture</h3>
	    <br><br>
	    <h4>Caisse de Topographie</h4>
		<table>
			<thead>
				<tr>
					<th>Total des affaires payées</th>
					<th>Total des charges</th>
					<th>Affaires payées - Charges</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $entreesMohamed ?></td>
					<td><?= $sortiesMohamed ?></td>
					<td><?= $entreesMohamed-$sortiesMohamed ?></td>
				</tr>
			</tbody>
		</table>
		<br><br><br>
		<h4>Caisse d'Architecture</h4>
		<table>
			<thead>
				<tr>
					<th>Total des affaires payées</th>
					<th>Total des charges</th>
					<th>Affaires payées - Charges</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $entreesKarim ?></td>
					<td><?= $sortiesKarim ?></td>
					<td><?= $entreesKarim-$sortiesKarim ?></td>
				</tr>
			</tbody>
		</table>
		<br><br><br>
		<h4>Total des Caisses : Topographe/Architecte</h4>
		<table>
			<thead>
				<tr>
					<th>Total des affaires payées</th>
					<th>Total des charges</th>
					<th>Affaires payées - Charges</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $entreesKarim+$entreesMohamed ?></td>
					<td><?= $sortiesKarim+$sortiesMohamed ?></td>
					<td><?= ($entreesKarim+$entreesMohamed)-($sortiesKarim+$sortiesMohamed) ?></td>
				</tr>
			</tbody>
		</table>
		<br><br><br>
		<h4>Total et moyenne</h4>
		<table>
			<thead>
				<tr>
					<th>Total des affaires payées</th>
					<th>Moyenne</th>
					<th>Moyenne - Charges Topo</th>
					<th>Moyenne - Charges Archi</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $entreesKarim+$entreesMohamed; ?></td>
					<td><?php echo $moyenne; ?></td>
					<td><?php echo $moyenne-$sortiesMohamed; ?></td>
					<td><?php echo $moyenne-$sortiesKarim; ?></td>
				</tr>
			</tbody>
		</table>
		<!-- END Sorties TABLE PORTLET-->
	    <page_footer>
	    <hr/>
	    <p style="text-align: center">STE TopEntreprise SARL : Au capital de X DH – siège social QT Nador.<br> 
	    <em>Tèl 053 / 06 IF : X   RC : X  Patente X</em></p>
	    </page_footer>
	</page>

	<?php
	    $content = ob_get_clean();
	    
	    require('../lib/html2pdf/html2pdf.class.php');
	    try{
	        $pdf = new HTML2PDF('P', 'A4', 'fr');
	        $pdf->pdf->SetDisplayMode('fullpage');
	        $pdf->writeHTML($content);
	        $pdf->Output("caisse-automatisee.pdf", 'D');
	    }
	    catch(HTML2PDF_exception $e){
	        die($e->getMessage());
	    }
	
