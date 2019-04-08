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

			// var_dump($stations);
			$d_station = get_affiliation($_POST["d_station"]);
			$a_station = get_affiliation($_POST["a_station"]);
			// var_dump($d_station);
			// exit;

			//中継の駅が選択された場合　[1]に初期値を設定
			$d_station["affiliation_id"] = $d_station["affiliation_id"] > 9? relay($d_station["affiliation_id"]) : $d_station["affiliation_id"];
			$a_station["affiliation_id"] = $a_station["affiliation_id"] > 9? relay($a_station["affiliation_id"]) : $a_station["affiliation_id"];
			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				// 二駅の所属IDを抽出する
				$sql = "SELECT id,MIN(include_rails) FROM `rails` WHERE FIND_IN_SET(" . $d_station["affiliation_id"] . ", `include_rails`) and FIND_IN_SET(". $a_station["affiliation_id"] .", `include_rails`)";
				$stmt2 = $pdo->prepare($sql);
				$stmt2->execute();
			}catch (PDOException $e) {
				print('接続失敗:' . $e->getMessage());
				die();
			}
			while($result = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$rail = $result;
			}
			// require_once("./template/Dijkstra.php");
			echo "出発駅ID" . $_POST["d_station"] . "到着駅ID" . $_POST["a_station"];
			echo  "最短ルート" . $rail["id"];

			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				// 対象駅を抽出する
				$sql = "SELECT`stations`.* FROM `stations`, `rails`, `affiliations` WHERE `stations`.`affiliation_id` = `affiliations`.id and  `affiliations`.rails_id = `rails`.id and  `rails`.id =" . $rail["id"] ;
				$stmt3 = $pdo->prepare($sql);
				$stmt3->execute();
			}catch (PDOException $e) {
				print('接続失敗:' . $e->getMessage());
				die();
			}
			while($result = $stmt3->fetch(PDO::FETCH_ASSOC)){
				$allstations[] = $result;
			}
			if (isset($allstations)){
				var_dump($allstations);
			}else{
				echo"失敗";
			}
			exit;



			// echo "最短ルート:" . $rail["id"];
			// SELECT`stations`.* FROM `stations`, `rails`, `affiliations` WHERE `stations`.`affiliation_id` = `affiliations`.id and  `affiliations`.rails_id = `rails`.id and  `rails`.id = 1
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
			$sql = 'SELECT name FROM stations ';
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
	function relay($i){
		switch ($i) {
			case 10:
				return 1;
				break;
			case 11:
				return 3;
				break;
			case 12:
				return 5;
				break;
			case 13:
				return 7;
				break;
			}
	}
	function get_affiliation($input){
		try{
			$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
			$sql = 'SELECT id,affiliation_id FROM stations WHERE id in( '. $input . ')';
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
		}catch (PDOException $e) {
			print('接続失敗:' . $e->getMessage());
			die();
		}
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$stations = $result;
		}
		return $stations;
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