<?php

	session_start();
	$result = "";
	$title ="新規作成";
	//トークン作成
	require_once("./template/csrf.php");

	if(isset($_POST["name"]) && isset($_POST["password"])){
		if (mb_strlen($_POST["name"]) < 2) {
			$result = "<p>名前は２文字以上必要です。</p>";
			echo $result;
		}
		if (mb_strlen($_POST["password"]) < 6) {
			$result = "<p>おまじないは６文字以上必要です。</p>";
			echo $result;
		}
		echo $result ===""? "ok" : "";
		if ($result ==="" && isset($_POST["send"])){

			try {
				// MySQLサーバへ接続
				$pdo = new PDO("mysql:host=localhost; dbname=miniapp;charset=utf8","Kazuma_U", "nakuyobou3");
			} catch(PDOException $e){
				var_dump($e->getMessage());
			}
			$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

			$sql ="INSERT INTO users (name,password) VALUE (?,?) ";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute([$_POST['name'],$hash]);
			$pdo = null;
			session_unset();
		}


		exit;
	}

	//ヘッダ
	$pagetitle = "セクション";
	require_once("./template/system_header.php");
	require_once("./template/form.php"); ?>
<form id="formajax" action="" method="Post">
			<input id="button1" type="submit" value="確認"  name="button1">
		</div>
	</div>
</form>
<!-- フッター -->
<?php require_once("./template/system_footer.php"); ?>