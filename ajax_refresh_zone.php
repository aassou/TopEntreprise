<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM t_zone WHERE nom LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$nom = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nom']);
	// add new option
	echo '<li onclick="set_item_zone(\''.str_replace("'", "\'", $rs['nom']).'\')">'.$nom.'</li>';
}
?>