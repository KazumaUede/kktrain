<?php
	session_start();
	$result = "";
	$title ="乗り換え検索";
	//トークン作成
	require_once("./template/csrf.php");

	if(isset($_POST["send"]) && isset($_POST["d_station"] ) && isset($_POST["a_station"])){
		if ($_POST["d_station"] !== $_POST["a_station"] ){
			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				$sql = "SELECT * FROM rails where FIND_IN_SET( '". $_POST["d_station"] ."', include_rails) and FIND_IN_SET( '". $_POST["a_station"] ."', include_rails)";
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
			echo $_POST["d_station"] . $_POST["a_station"];
			var_dump($rails) ;
			exit;
		}else{
			echo"お前はもう到着している!(出発駅と到着駅同じですよ)";
		}
		exit;

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