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
    if(isset($_SESSION['user'])){
    	$chargesManager = new ChargesManager($pdo);
		$voituresManager = new VoitureManager($pdo);
		$cnssManager = new CnssManager($pdo);
		$salairesManager = new SalairesManager($pdo);
		$comptableManager = new ComptableManager($pdo);
		$observationManager = new ObservationManager($pdo);
		
		$charges = $chargesManager->getCharges();     
		ob_start();
	?>
	<style type="text/css">
		table {
		    border-collapse: collapse;
		    width: 100%;
		}
		
		table, th, td {
		    border: 1px solid black;
		}
		td, th{
			padding : 2px;
		}
		td{
			width: 7,7%;
		}
		th{
			background-color: grey;
		}
	</style>
	<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
	    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
	    <br><br><br><br>
	    <h3>Bilan des Charges de la société TopEntreprise</h3>
	    <br><br><br><br>
		<table>
			<thead>
				<tr>
					<th>Mois</th>
					<th>Eau</th>
					<th>Electricité</th>
					<th>Fixe</th>
					<th>Portable</th>
					<th>Net</th>
					<th>Loyer</th>
					<th>Salaires</th>
					<th>Comptable</th>
					<th>Voiture</th>
					<th>CNSS</th>
					<th>Observation</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($charges as $charge){ 
					$totalSalaire = $salairesManager->getSalairesTotalMontantByIdCharge($charge->id())
					+$salairesManager->getSalairesTotalPrimeByIdCharge($charge->id());
					$totalComptable = $comptableManager->getComptableTotalByIdCharge($charge->id());
					$totalVoiture = $voituresManager->getVoitureTotalByIdCharge($charge->id());
					$totalCnss = $cnssManager->getCnssTotalByIdCharge($charge->id());
					$totalObservation = $observationManager->getObservationTotalByIdCharge($charge->id()); 
					$total = $charge->eau()+
					$charge->electricite()+
					$charge->fixe()+
					$charge->portable()+
					$charge->internet()+
					$charge->loyer()+
					$totalSalaire+$totalCnss+$totalComptable+$totalObservation+$totalVoiture;
					$month = date('m/Y', strtotime($charge->dateCharges())); 
					?>
				<tr>
					<td><?= $month ?></td>
					<td><?= $charge->eau(); ?></td>
					<td><?= $charge->electricite() ?></td>
					<td><?= $charge->fixe() ?></td>
					<td><?= $charge->portable() ?></td>
					<td><?= $charge->internet() ?></td>
					<td><?= $charge->loyer() ?></td>
					<td>
						<?= $totalSalaire ?>
					</td>
					<td>
						<?= $comptableManager->getComptableTotalByIdCharge($charge->id()) ?>
					</td>
					<td>
						<?= $voituresManager->getVoitureTotalByIdCharge($charge->id()) ?>
					</td>
					<td>
						<?= $cnssManager->getCnssTotalByIdCharge($charge->id()) ?>
					</td>
					<td>
						<?= $observationManager->getObservationTotalByIdCharge($charge->id()) ?>
					</td>
					<td><a id="gritter-max" class="btn black"><?= $total ?></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br><br><br><br>
		<!-- END Entrees TABLE PORTLET-->
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
	        $pdf->Output('charges.pdf');
	    }
	    catch(HTML2PDF_exception $e){
	        die($e->getMessage());
	    }
}
else{
    header("Location:../index.php");
}
?>
