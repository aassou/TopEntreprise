<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT nature FROM t_affaire WHERE nature LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$nature = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nature']);
	// add new option
	echo '<li onclick="set_item_nature(\''.str_replace("'", "\'", $rs['nature']).'\')">'.$nature.'</li>';
}
?>