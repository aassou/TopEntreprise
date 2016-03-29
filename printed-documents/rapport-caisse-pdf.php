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
    	$entreesManager = new EntreesManager($pdo);
		$entreesKarim = $entreesManager->getEntreesEnCoursKarim();
		$entreesMohamed = $entreesManager->getEntreesEnCoursMohamed();
		$sortiesManager = new SortiesManager($pdo);
		$sortiesKarim = $sortiesManager->getSortiesEnCoursKarim();
		$sortiesMohamed = $sortiesManager->getSortiesEnCoursMohamed();
		$totalEntrees = $entreesManager->getEntreesKarimTotal()+$entreesManager->getEntreesMohamedTotal();
		$totalSortie = $sortiesManager->getSortiesKarimTotal()+$sortiesManager->getSortiesMohamedTotal();
		$moyenne = $totalEntrees/2;
		$moyenneKarim = $moyenne-$sortiesManager->getSortiesKarimTotal();
		$moyenneMohamed = $moyenne-$sortiesManager->getSortiesMohamedTotal();
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
	    <br><br><br><br>
		<table>
			<thead>
				<tr>
					<th>Opérateur</th>
					<th>Date Opération</th>
					<th>Montant</th>
					<th>Statut</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($entreesKarim as $entree){ 
					?>
				<tr>
					<td><?= $entree->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $entree->montant() ?></td>
					<td><?= $entree->statut() ?></td>
				</tr>
				<?php } ?>
				<?php
				foreach($entreesMohamed as $entree){ 
					?>
				<tr>
					<td><?= $entree->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $entree->montant() ?></td>
					<td><?= $entree->statut() ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br><br><br><br>
		<!-- END Entrees TABLE PORTLET-->
		<!-- BEGIN Sorties TABLE PORTLET-->
		<table>
			<thead>
				<tr>
					<th>Opérateur</th>
					<th>Date Opération</th>
					<th>Montant</th>
					<th>Statut</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($sortiesKarim as $sortie){ 
					?>
				<tr>
					<td><?= $sortie->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $sortie->montant() ?></td>
					<td><?= $sortie->statut() ?></td>
				</tr>
				<?php } ?>
				<?php
				foreach($sortiesMohamed as $sortie){ 
					?>
				<tr>
					<td><?= $sortie->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $sortie->montant() ?></td>
					<td><?= $sortie->statut() ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<br><br><br><br>
		<table>
			<thead>
				<tr>
					<th>Total</th>
					<th>Moyenne</th>
					<th>Moyenne - Sorties (karim)</th>
					<th>Moyenne - Sorties (Mohamed)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $totalEntrees; ?></td>
					<td><?php echo $moyenne; ?></td>
					<td><?php echo $moyenneKarim; ?></td>
					<td><?php echo $moyenneMohamed; ?></td>
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
			$dateOp = "c://wamp/www/TopEntreprise/pdf/rapport-caisse".date('Y-m-d-h-i').".pdf";
	        $pdf->Output($dateOp, 'F');
	    }
	    catch(HTML2PDF_exception $e){
	        die($e->getMessage());
	    }
}
else{
    header("Location:../index.php");
}
?>
