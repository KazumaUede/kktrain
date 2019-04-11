<?php
define('STATION_NUMBER',count($allstations));
define('START_STATION', $startstation);
define('GOAL_STATION', $goalstation);
$stations = $station_names;
$route = [];
$result = [];

//隣接行列
//各所要時間を保持する
$adjacencyMatrix = $bigarray;
//初期設定する
for ($i=0; $i < STATION_NUMBER; $i++) {
    $currentCost[$i] = -1; //-1は無限大とする
    $fix[$i]         = false;
}

//スタート地点を0とする
$currentCost[START_STATION] = 0;
array_push($route,START_STATION);

while (true) {
    //所要時間を無限大に初期設定する
    $minStation = -1;
    $minTime    = -1;
    for ($i = 0; $i < STATION_NUMBER; $i++) {
        if (!$fix[$i] && ($currentCost[$i] != -1)) {
            if ($minTime == -1 || $minTime > $currentCost[$i]) {
                //パターン洗い出しが終わってなく、所要時間の短い駅を調べる
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
        if (!$fix[$i] && $adjacencyMatrix[$minStation][$i] > 0) {
            // 自分の駅経由で移動する場合の必要時間
            $newTime = $minTime + $adjacencyMatrix[$minStation][$i];
            if ($currentCost[$i] == -1 || $currentCost[$i] > $newTime) {
                // 今登録されている時間よりも、この駅経由で移動した時間が速いので、新しい時間を登録する
                $currentCost[$i] = $newTime;
			}
        }
    }
    // 自分の駅を確定する
    $fix[$minStation] = true;
}
//最短経路を探す






array_push($result, $stations[START_STATION] . "→" . $stations[GOAL_STATION] . "：" . ($currentCost[GOAL_STATION] - 1) . "分");

// for ($i = 0; $i < STATION_NUMBER; $i++) {
// 	array_push($result, $stations[START_STATION] . "→" . $stations[$i] . "：" . ($currentCost[$i] - 1) . "分");
// }
echo json_encode($result);
?>


