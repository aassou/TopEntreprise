<?php 
function imageProcessing($source){
	$image="";
	if(isset($source) && $source['error']==0){
		if($source['size']<=1000000){
			$extensionsAutorise = array('png', 'gif', 'jpeg', 'jpg', 'PNG', 'JPG', 'JPEG', 'GIF');
			$infosFichier = pathinfo($source['name']);
			$extensionUpload = $infosFichier['extension'];
			if(in_array($extensionUpload, $extensionsAutorise)){
				$nameUpload = basename($source['name']);
				$nameUpload = uniqid().$nameUpload;
				move_uploaded_file($source['tmp_name'], '../factures/'.$nameUpload);
				$image = '../TopEntreprise/factures/'.$nameUpload;
			}
		}
	}
	return $image;
}
?>