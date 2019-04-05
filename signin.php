<?php

	session_start();
	$result = "";
	$title ="ログイン";
	//トークン作成
	require_once("./template/csrf.php");

	if(isset($_POST["name"]) && isset($_POST["password"])){
		if (mb_strlen($_POST["name"]) < 2) {
			$result = "<p>名前は２文字以上必要です。</p>";
			echo $result;
		}
		if (mb_strlen($_POST["password"]) < 6) {
			$result = "<p>パスワードは６文字以上必要です。</p>";
			echo $result;
		}
		if ($result ==="" && isset($_POST["send"])){
			try{
				$pdo = new PDO("mysql:host=localhost; dbname=miniapp;charset=utf8","Kazuma_U", "nakuyobou3");
				$sql = 'SELECT password FROM users WHERE name = :name;';
				$sth = $pdo->prepare($sql);
				$sth->bindParam(':name', $_POST['name']);
				$sth->execute();
				$pass = $sth->fetch();
				if(password_verify($_POST['password'], $pass['password'])){
					echo "ok";
					exit;
				}else{
					$result ='認証失敗';
					echo $result;
				}
			}catch (PDOException $e) {
				print('接続失敗:' . $e->getMessage());
				die();
			}
		}
		exit;
	}

	//ヘッダ
	$pagetitle = "ログイン";
	require_once("./template/system_header.php");
	require_once("./template/form.php"); ?>

			<input id="button" type="submit" value="ログイン"  name="send">
		</div>
	</div>
</form>
<!-- フッター -->
<?php require_once("./template/system_footer.php"); ?>