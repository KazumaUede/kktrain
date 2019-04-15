<?php

	session_start();
	$result = "";
	$title ="乗り換え検索";
	//トークン作成
	require_once("./template/csrf.php");

	if(isset($_POST["send"]) && isset($_POST["d_station"] ) && isset($_POST["a_station"])){
		if ($_POST["d_station"] !== $_POST["a_station"] ){
			header("Content-Type: application/json; charset=UTF-8");//json形式で出力するときは必須
			$d_station = get_rail($_POST["d_station"]);
			$a_station = get_rail($_POST["a_station"]);

			//中継の駅が選択された場合　[1]に初期値を設定
			$d_station["rail_id"] = $d_station["rail_id"] > 9? relay($d_station["rail_id"]) : $d_station["rail_id"];
			$a_station["rail_id"] = $a_station["rail_id"] > 9? relay($a_station["rail_id"]) : $a_station["rail_id"];
			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				// 二駅の所属IDを抽出する
				$sql = "SELECT id,MIN(belongs) FROM `routes` WHERE FIND_IN_SET(" . $d_station["rail_id"] . ", `belongs`) and FIND_IN_SET(". $a_station["rail_id"] .", `belongs`)";
				$stmt2 = $pdo->prepare($sql);
				$stmt2->execute();
			}catch (PDOException $e) {
				print('接続失敗:' . $e->getMessage());
				die();
			}
			while($result = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$route = $result;
			}

			try{
				$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
				// 対象駅を抽出する
				//さらに並び替えが必要か判別する　①枝から下へ向かうとき　②下から上の枝に向かうとき つまり上側の枝の順番をひっくり返す。
				if ($d_station["rail_id"]%2==0 && $d_station["rail_id"] < $a_station["rail_id"]){
					$sql = "(" . "SELECT `stations`.* , 1 AS row FROM `stations`WHERE rail_id =" . $d_station["rail_id"] . " order by id DESC LIMIT 20000". ")UNION all(" . "SELECT`stations`.* , 2 AS row FROM `stations`, `routes`, `rails` WHERE `stations`.`rail_id` = `rails`.id and  `rails`.route_id = `routes`.id and  `routes`.id =". $route["id"] . " and  `stations`.`rail_id`<> ". $d_station["rail_id"] ."  order by id  LIMIT 20000" . ")";
				} else if($a_station["rail_id"]%2==0 && $d_station["rail_id"] > $a_station["rail_id"]){
					$sql = "(" . "SELECT `stations`.* , 1 AS row FROM `stations`WHERE rail_id =" . $a_station["rail_id"] . " order by id DESC LIMIT 20000". ")UNION all(" . "SELECT`stations`.* , 2 AS row FROM `stations`, `routes`, `rails` WHERE `stations`.`rail_id` = `rails`.id and  `rails`.route_id = `routes`.id and  `routes`.id =". $route["id"] . " and  `stations`.`rail_id`<> ". $a_station["rail_id"] ."  order by id  LIMIT 20000" . ")";
				} else{
					$sql = "SELECT`stations`.* FROM `stations`, `routes`, `rails` WHERE `stations`.`rail_id` = `rails`.id and  `rails`.route_id = `routes`.id and  `routes`.id =" . $route["id"] ;
				}
				// $sql = "SELECT`stations`.* FROM `stations`, `routes`, `rails` WHERE `stations`.`rail_id` = `rails`.id and  `rails`.route_id = `routes`.id and  `routes`.id =" . $route["id"] ;
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
				// 隣接行列を作成する
				$bigarray = [];
				$bigarray2 = [];
				$station_names = [];
				$count = count($allstations) -1;
				$i = 0;
				foreach($allstations as $station){
					//出発駅
					if ($_POST["d_station"] === $station["id"]){
						$startstation = $i;
					}
					if ($_POST["a_station"] === $station["id"]){
						$goalstation = $i;
					}
					$i++;
				}




				$i = 0;
				foreach($allstations as $station){

					array_push($station_names, $station["name"]);
					$array = [];
					$array2 = [];
					//all0の配列を全体の配列に挿入する
					for($j = 0; $j <= $count; $j++ ){
						array_push($array, 0);
						array_push($array2, 0);
					}
					array_push($bigarray, $array);
					array_push($bigarray2, $array2);
					if($i == 0){
						// 初期値
						// 普通
						$local = $station["local"] ==1? 0: -1;
						// エアポート急行
						$a_express = $station["a_express"] ==1? 0: -1;
						// 特急
						$l_express = $station["l_express"] ==1? 0: -1;
						// 快特
						$kl_express = $station["kl_express"] ==1? 0: -1;
						// エアポート快特
						$ak_express = $station["ak_express"] ==1? 0: -1;
					}else{
						// コストを算出
						// 普通
						if ($station["local"] == 1 && $local !==-1 ){
							$bigarray[$local][$i] = 6;
							$bigarray[$i][$local] = 6;
							$bigarray2[$local][$i] = "普通";
							$bigarray2[$i][$local] = "普通";
							$local =  $i;
						}
						// エアポート急行
						if ($station["a_express"] == 1 && $a_express !==-1 ){
							$bigarray[$a_express][$i] = 4 * ($i - $a_express) +1;
							$bigarray[$i][$a_express] = 4 * ($i - $a_express) +1;
							$bigarray2[$a_express][$i] = "急行";
							$bigarray2[$i][$a_express] = "急行";
							$a_express =  $i;
						}
						// 特急
						if ($station["l_express"] == 1 && $l_express !==-1 ){
							$bigarray[$l_express][$i] = 3 * ($i - $l_express) +1;
							$bigarray[$i][$l_express] = 3 * ($i - $l_express) +1;
							$bigarray2[$l_express][$i] = "特急";
							$bigarray2[$i][$l_express] = "特急";

							$l_express =  $i;
						}
						// 快特
						if ($station["kl_express"] == 1 && $kl_express !==-1 ){
							$bigarray[$kl_express][$i] = 2 * ($i - $kl_express) +1;
							$bigarray[$i][$kl_express] = 2 * ($i - $kl_express) +1;
							$bigarray2[$kl_express][$i] = "快特";
							$bigarray2[$i][$kl_express] = "快特";
							$kl_express =  $i;
						}
						// エアポート快特
						if ($station["ak_express"] == 1 && $ak_express !==-1 ){
							$bigarray[$ak_express][$i] = 1 * ($i - $ak_express) +1;
							$bigarray[$i][$ak_express] = 1 * ($i - $ak_express) +1;
							$bigarray2[$ak_express][$i] = "エアポート快特";
							$bigarray2[$i][$ak_express] = "エアポート快特";
							$ak_express =  $i;
						}
						// 使用できる電車が増えたら追加する
						if ($local == -1 && $station["local"] ==1){
							$local = $i;
						}
						if ($a_express == -1 && $station["a_express"] ==1){
							$a_express = $i;
						}
						if ($l_express == -1 && $station["l_express"] ==1){
							$l_express = $i;
						}
						if ($kl_express == -1 && $station["kl_express"] ==1){
							$kl_express = $i;
						}
						if ($ak_express == -1 && $station["ak_express"] ==1){
							$ak_express = $i;
						}
					}
					$i++;
				}
				require_once("./template/Dijkstra.php");
				//json形式で出力する
				// echo json_encode($bigarray);
				exit;


				//json形式で出力する
				echo json_encode($allstations);
			}else{
				echo"失敗";
			}
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
	function get_rail($input){
		try{
			$pdo = new PDO("mysql:host=localhost; dbname=kktrain;charset=utf8","sampleuser", "momota6");
			$sql = 'SELECT id,rail_id FROM stations WHERE id in( '. $input . ')';
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

<h4>結果<h4>
<div class="result"></div>
<!-- フッター -->
<?php require_once("./template/system_footer.php"); ?>