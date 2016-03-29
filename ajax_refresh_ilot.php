<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT ilot FROM t_projet WHERE ilot LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$ilot = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['ilot']);
	// add new option
	echo '<li onclick="set_item_ilot(\''.str_replace("'", "\'", $rs['ilot']).'\')">'.$ilot.'</li>';
}
?>