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
		$entreesNumber = $entreesManager->getEntreesNumber();
		$entrees = "";
		if($entreesNumber!=0){
			$entrees = $entreesManager->getEntreesArchive();	
		}
		$sortiesManager = new SortiesManager($pdo);
		$sortiesNumber = $sortiesManager->getSortiesNumber();
		$sorties = "";
		if($sortiesNumber!=0){
			$sorties = $sortiesManager->getSortiesArchive();	
		}
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
	    <h3>Archive des Charges de la société TopEntreprise</h3>
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
				if((bool)$entrees){
				foreach($entrees as $entree){ 
					?>
				<tr>
					<td><?= $entree->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $entree->montant() ?></td>
					<td><?= $entree->statut() ?></td>
				</tr>
				<?php }} ?>
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
				if((bool)$sorties){
				foreach($sorties as $sortie){ 
					?>
				<tr>
					<td><?= $sortie->user() ?></td>
					<td><?= date('d-m-Y | h:i:s',strtotime($entree->dateOperation())) ?></td>
					<td><?= $sortie->montant() ?></td>
					<td><?= $sortie->statut() ?></td>
				</tr>
				<?php }} ?>
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
	        $pdf->Output('caisse-archive.pdf');
	    }
	    catch(HTML2PDF_exception $e){
	        die($e->getMessage());
	    }
}
else{
    header("Location:../index.php");
}
?>
