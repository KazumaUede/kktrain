<?php
	session_start();
	$result = "";
	$title ="乗り換え検索";
	//トークン作成
	require_once("./template/csrf.php");
	// 二駅の所属IDを抽出する
	// SELECT `stations`.`affiliation_id` FROM `stations` WHERE id in( . $_POST["a_station"] . , . $_POST["a_station"] .)
	if(isset($_POST["send"]) && isset($_POST["d_station"] ) && isset($_POST["a_station"])){
		if ($_POST["d_station"] !== $_POST["a_station"] ){
			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				// 二駅の所属IDを抽出する
				$sql = "SELECT `stations`.`affiliation_id` FROM `stations` WHERE id in( ". $_POST["d_station"] . "," . $_POST["a_station"] . ")";
				$stmt2 = $pdo->prepare($sql);
				$stmt2->execute();
			}catch (PDOException $e) {
				print('接続失敗:' . $e->getMessage());
				die();
			}
			while($result = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$rails[] = $result;
			}
			// require_once("./template/Dijkstra.php");
			echo "出発駅ID" . $_POST["d_station"] . "到着駅ID" . $_POST["a_station"];
			foreach($rails as $rail){
				foreach($rail as $data){
					echo ":" . ($data);
				}
			}
			// var_dump($rails) ;
			exit;
		}else{
			echo"お前はもう到着している!(出発駅と到着駅同じですよ)";
		}
		exit;
		// SELECT * FROM `rails` WHERE FIND_IN_SET('1', `include_rails`) and FIND_IN_SET('5', `include_rails`)
	}else{
		try{
			$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
			$sql = 'SELECT name, FROM stations ';
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
		}catch (PDOException $e) {
			print('接続失敗:' . $e->getMessage());
			die();
		}
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$stations[] = $result;
		}
		// foreach($stations as $station){
		// 	foreach($station as $data){
		// 		var_dump($data);
		// 	}
		// }
	}
	$pagetitle = "miniapp";
	require_once("./template/system_header.php");
	function selectstation($name ,$stations){
		$i = 1;
		echo '<select name="' . $name . '">';
		echo '<option disabled selected>選択してください</option>';
		foreach($stations as $station){
			foreach($station as $data){
				echo '<option value="' . $i++ . '">'.$data.'</option>';
			}
		}
		echo '</select>';
	}
	?>
<h4>乗り換え検索<h4>
<form action="" method="Post">
	<h4>出発駅<h4>
	<?php selectstation('d_station',$stations) ?>
	<h4>到着駅<h4>
	<?php selectstation('a_station',$stations) ?>
	<input id="button" type="submit" value="検索"  name="send">
</form>
<!-- フッター -->
<?php require_once("./template/system_footer.php"); ?>