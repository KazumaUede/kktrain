<?php
define('STATION_NUMBER',count($bigarray));
define('START_STATION', $start);
define('GOAL_STATION', $goal);
$stations = $station_names;
$routes = [];
$result = [];

//隣接行列
//各所要時間を保持する
$adjacencyMatrix = $bigarray;
$adjacencyMatrix2 = $bigarray2;
//1.初期設定する
for ($i=0; $i < STATION_NUMBER; $i++) {
    $currentCost[$i] = -1; //-1は無限大とする
    $fix[$i]         = false;
}
//2.スタート地点を-1→0とする（スタートノード）
$currentCost[START_STATION] = 0;
$test = array();
while (true) {

    //3.所要時間を無限大に初期設定する
    $minStation = -1;
    $minTime    = -1;
    for ($i = 0; $i < STATION_NUMBER; $i++) {
		//4.もし$fix[$i]がfalse　かつ　$currentCost[$i]が-1でないなら(初めはスタートノード、以降は次の駅を探している？)
        if (!$fix[$i] && ($currentCost[$i] != -1)) {
			//5.もし$minTimeが∞　か　$minTime　が$currentCost[$i]よりおおきいなら
			// $minTime == -1はスタートノードで０が代入
            if ($minTime == -1 || $minTime > $currentCost[$i]) {
				//パターン洗い出しが終わってなく、所要時間の短い駅を調べる
				//6.(ここで下のFor分に使う変数を代入する。)
                $minTime    = $currentCost[$i];
                $minStation = $i;
			}
		}
	}

    if ($minTime == -1) {
        //全ての駅が確定したか、最初の所要時間が無限大のとき
        break;
    }
	// 自分の駅から伸びているすべての駅の所要時間を調べる
    for ($i = 0; $i < STATION_NUMBER; $i++) {
		// もし　$fix[$i]が　false　かつ　$minStation番目の駅情報が０より大きいとき
        if (!$fix[$i] && $adjacencyMatrix[$minStation][$i] > 0) {
            // 自分の駅経由で移動する場合の必要時間
			$newTime = $minTime + $adjacencyMatrix[$minStation][$i];
            if ($currentCost[$i] == -1 || $currentCost[$i] > $newTime) {
				// 今登録されている時間よりも、この駅経由で移動した時間が速いので、新しい時間を登録する
				$train = $adjacencyMatrix2[$minStation][$i];
				$currentCost[$i] = $newTime;
				if(!isset($test[$i])){$test[$i] = array();}
				//電車の初期値

				//途中経路を表示
				$test[$i][] = array($train,$stations[$i]);
				if(isset($test[$minStation])){
					$test[$i] = array_merge($test[$minStation],$test[$i]);
				}
			}
		}
	}
    // 自分の駅を確定する
	$fix[$minStation] = true;

}
$savetrain;
$getroutes =[];


foreach($test[GOAL_STATION] as $route){
		// スタートの隣がゴールなら
		if (count($test[GOAL_STATION]) === 1){
			array_push($getroutes,$route);
		}elseif ($route === reset($test[GOAL_STATION])) {
			// 最初
			$savetrain = $route;
		}else if ($savetrain[0] === $route[0] && $route === end($test[GOAL_STATION])) {
			// 最後
			array_push($getroutes,$route);
		}else{
			if($savetrain[0] === $route[0]){

				$savetrain = $route;
			}else{
				array_push($getroutes,$savetrain);
					// 最後
					if ($route === end($test[GOAL_STATION])) {
						array_push($getroutes,$route);
					}
		}
		$savetrain = $route;

		}
	}
$text = "";
foreach($getroutes as $getroute){
	$text .= "-(" . $getroute[0] . ")-" . $getroute[1];
}
$result = $stations[START_STATION] . $text . "[所要時間" . ($currentCost[GOAL_STATION] - 1) . "分]";
//　途中駅を表示
// array_push($result, $stations[START_STATION] . $test[GOAL_STATION]);
// array_push($result,"[所要時間" . ($currentCost[GOAL_STATION] - 1) . "分]");
// array_push($result, "\n" . $stations[START_STATION] . "→" . $stations[GOAL_STATION] . "：" . ($currentCost[GOAL_STATION] - 1) . "分");

// for ($i = 0; $i < STATION_NUMBER; $i++) {
// 	array_push($result, $stations[START_STATION] . "→" . $stations[$i] . "：" . ($currentCost[$i] - 1) . "分");
// }

echo json_encode($result);
exit;
?>


