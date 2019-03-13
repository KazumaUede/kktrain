<?php
	$pagetitle = "カレンダー";
	require_once("./template/system_header.php");
	
	
	
	
	$y = isset($_GET['year'])? $_GET['year'] : date("Y");
	$m = isset($_GET['month'])? $_GET['month'] : date("n");
	switch ($m){
		case 1:
			$ly = $y - 1;
			$ny = $y;
			$nm = $m + 1;
			$lm = 12;
			break;
		case 12:
			$ly = $y;
			$ny = $y + 1;
			$lm = $m - 1;
			$nm = 1;
			break;
    	default:
			$lm = $m - 1;
			$nm = $m + 1;
			$ly = $ny = $y;
	}
	$week = ['<span style="color:red">日</span>','月','火','水','木','金','<span style="color:royalblue">土</span>'];
	
	$today = date("j");
	?>
	<div class="calendar">
		<h5>
			<?php
				echo '<a href="?year=' . ($y -1) . '&month=' .$m. '">前年へ←</a></th>';			
				echo '<a href="?year=' . $ly . '&month=' .$lm. '">前月へ←</a></th>';
				echo ' ' . $y . '年 ' . $m .'月 '; 
				echo '<a href="?year=' . $ny . '&month=' .$nm. '">→翌月へ</a></th>';
				echo '<a href="?year=' . ($y +1) . '&month=' .$m. '">→翌年へ</a></th>';
			?>
		</h5>
		<table>
			<tr>
				<?php
					$i = 0;
					while ($i <= 6) {
						echo '<th>' .$week[$i] .'</th>' ;
						$i++;
					}
				?>
			</tr>
			<?php
			// 1日の曜日を取得
			$wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
			// 第一週空白を表示
			for ($i = 1; $i <= $wd1; $i++) {
				echo "<td>　</td>";
			}
			
			for($d = 1;checkdate($m, $d, $y);$d++){
				echo "<td>$d</td>";
				if(date("w", mktime(0,0,0,$m,$d,$y)) == 6){
					echo "</tr>";
					if(checkdate($m, $d + 1, $y)){
						echo "<tr>";
					}
				}				
				
			}
			// 月末週空白を表示
			$wdx = date("w", mktime(0,0,0, $m + 1,0, $y));
			for ($i = 1; $i <7 - $wdx; $i++){
				echo "<td> </td>";
			}
			?>
			</tr>
		</table>
		<?php
			echo '<a href="?year=' . date("Y") . '&month=' .date("n"). '">今月へ</a></th>';
		?>
	</div>
<?php require_once("./template/system_footer.php"); ?>