<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT nomService FROM t_affaire WHERE nomService LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$nom = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nomService']);
	// add new option
	echo '<li onclick="set_item_service(\''.str_replace("'", "\'", $rs['nomService']).'\')">'.$nom.'</li>';
}
?>