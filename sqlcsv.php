<?php
//	require_once("./function/htmlspecialchars.php");
	// 出力情報の設定
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=応募者一覧.csv");
	header("Content-Transfer-Encoding: binary");

	try {
		// MySQLサーバへ接続
		$pdo = new PDO("mysql:host=localhost; dbname=formtest;charset=utf8",
					   "Kazuma_U", "nakuyobou3");
	} catch(PDOException $e){
		var_dump($e->getMessage());
	}
	$basis = isset($_GET['key'])? $_GET['key'] : "id";
	$before_sort = isset($_GET['sort'])? $_GET['sort'] : "ASC";
	$sql = "SELECT * FROM users ORDER BY " . $basis ." ". $before_sort;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	$users[] = $result;
	}

// 変数の初期化
$csv = "";
$csv .= '"' . join('","', array_keys($users[0])) . '"' . "\n";
foreach($users as $user){
	$csv .= '"' . join('","', $user) . '"' . "\n";
}
echo mb_convert_encoding($csv,"SJIS", "UTF-8");
//foreach($csv as $data){
//	echo mb_convert_encoding($data,"SJIS", "UTF-8");
//}
//return;
?>
