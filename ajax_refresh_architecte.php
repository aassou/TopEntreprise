<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT DISTINCT architecte FROM t_projet WHERE architecte LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$architecte = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['architecte']);
	// add new option
	echo '<li onclick="set_item_architecte(\''.str_replace("'", "\'", $rs['architecte']).'\')">'.$architecte.'</li>';
}
?>