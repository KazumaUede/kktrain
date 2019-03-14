<?php
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
?>

<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>localhost</title>
	<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<script src="./js/jquery-3.3.1.slim.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/materialize.css">
	<script type="text/javascript" src="./js/materialize.js"></script>
</head>

<body>
	<div class="container">
		<h5>
			応募者情報
		</h5>
		<table class="striped">
			<thead>
				<tr>
					<?php
						foreach(array_keys($users[0]) as $key){
							$sort = $key === $basis && $before_sort ==="ASC"? "DESC":"ASC";
							echo '<th><a href="?key=' . $key .'&sort=' .$sort. '">' . $key . '</a></th>' ;
						}
					?>
				</tr>
			</thead>

			<tbody>

				<?php
					foreach($users as $user){
						echo '<tr>';
						foreach($user as $data){
							echo '<th>' . $data . '</th>';
						}
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
		<h5>CSV Download</h5>
		<?php
			echo '<p><a href="sqlcsv.php?key='.$basis.'&sort=' . $before_sort . '">Download</a></p>';
		?>
	</div>
</body>

</html>
