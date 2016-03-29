<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT type FROM t_projet WHERE type LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$type = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['type']);
	// add new option
	echo '<li onclick="set_item_type(\''.str_replace("'", "\'", $rs['type']).'\')">'.$type.'</li>';
}
?>