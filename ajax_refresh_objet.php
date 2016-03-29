<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT objet FROM t_projet WHERE objet LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$objet = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['objet']);
	// add new option
	echo '<li onclick="set_item_objet(\''.str_replace("'", "\'", $rs['objet']).'\')">'.$objet.'</li>';
}
?>