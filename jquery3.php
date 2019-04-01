<?php

	session_start();
	$result = "";
	//トークン作成
	function get_csrf_token() {
		$TOKEN_LENGTH = 16;//16*2=32バイト
		$bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
		return bin2hex($bytes);
	}

	if (isset($_POST['csrf_token'])){
		if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
		}else{
			$result ="<p>不正な送信です</p>";
			echo $result;
			exit;
		}
	} else {
		$_SESSION['csrf_token'] = get_csrf_token();
	}

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
				$pdo = new PDO("mysql:host=localhost; dbname=jquery3;charset=utf8","Kazuma_U", "nakuyobou3");
			} catch(PDOException $e){
				var_dump($e->getMessage());
			}
			$sql ="INSERT INTO users (name,password) VALUE (?,?) ";
			$stmt = $pdo -> prepare($sql);
			$stmt -> execute([$_POST['name'],$_POST['password']]);
			$pdo = null;
			session_unset();
		}


		exit;
	}

	//ヘッダ
	$pagetitle = "セクション";
	require_once("./template/system_header.php"); ?>
<form id="formajax" action="" method="Post">
	<h6>投稿フォーム</h6>
	<div class = "title_container">
	</div>
	<div class = "error_msg"></div>
	<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
	<h6>名前<em>(必須)</em></h6>
		<div class = "name_container">
			<div class ="inputswitch">
				<input type="text" name="name" value="" placeholder=" (例)佐藤太郎" required maxlength="30" />
			</div>
		</div>
	<h6>おまじない<em>(必須)</em></h6>
		<div class = "password_container">
			<div class ="inputswitch">
				<input  type="password" name="password" value="" placeholder="(例)となりの４８はあ０１" required maxlength="30" />
			</div>
		</div>
	<div class = "button_container">
		<div class ="inputswitch">
			<input id="button1" type="submit" value="確認"  name="button1">
		</div>
	</div>
</form>
<!-- フッター -->
<?php require_once("./template/system_footer.php"); ?>