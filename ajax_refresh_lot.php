<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT lot FROM t_projet WHERE lot LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$lot = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['lot']);
	// add new option
	echo '<li onclick="set_item_lot(\''.str_replace("'", "\'", $rs['lot']).'\')">'.$lot.'</li>';
}
?>