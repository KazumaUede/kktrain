<?php
	require_once("./template/prefectures.php");
//	require_once("./template/htmlspecialchars.php");
	$pagetitle = "応募フォーム";
	require_once("./template/system_header.php");
	$today = date("Y/m/d");
	if(!isset($_COOKIE['count']) || $today !== $_COOKIE['before_day'] ){
		//初回アクセス時
		$count = 1;
		$before_day = date("Y/m/d");
		setcookie('count', $count, time()+86400);
		setcookie('before_day', $before_day, time()+86400);
	}else{
		//2回目以降
		$count = $_COOKIE['count'] + 1;
		setcookie('count', $count, time()+86400);
	}
	function check_session($s) {
		if(!isset($_SESSION[$s])){
			$_SESSION[$s] ='';
		};
	};
	session_start();
	check_session('zipcode');
	check_session('prefectures');
	check_session('address');
	check_session('name');
	check_session('kana');
	check_session('age');
	check_session('sex');
	check_session('telcode');
	check_session('email');
?>
<div class="container">
	<h3><?php echo'本日'. $count .'回目の訪問！'; ?></h3>
	<?php if (!empty($_SESSION['error'])){
		echo '<ul class="error_list">';
		foreach($_SESSION['error'] as $error){
			echo '<li>' . $error . '<li>';
		}
		echo '</ul>';
	}  ?>
	<h4>応募情報入力</h4>
	<form action="conf.php" method="Post">
		<h5>郵便番号(ハイフンなし)<em>(必須)</em></h5>
		<input type="text" name="zipcode" 　 value="<?php echo $_SESSION['zipcode']; ?>" placeholder=" (例)1234567" required maxlength="7" />
		<h5>住所：都道府県<em>(必須)</em></h5>
		<select name="prefectures">
			<option disabled selected>選択してください</option>
			<?php
				for ($i=0; $i < count($pref); $i++) {
					if ($_SESSION['prefectures'] === $pref[$i]){
						echo '<option selected="selected">'.$pref[$i]."</option>";
					}else{
						echo "<option>".$pref[$i]."</option>";
					}
				}
			?>
		</select>
		<h5>住所：市区町村以下<em>(必須)</em></h5>
		<input type="text" name="address" value="<?php echo $_SESSION['address']; ?>" placeholder=" (例)〇〇市〇〇町〇〇　〇〇-〇" required maxlength="127" />
		<h5>名前<em>(必須)</em></h5>
		<input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" placeholder=" (例)佐藤太郎" required maxlength="30" />
		<h5>フリガナ<em>(必須)</em></h5>
		<input type="text" name="kana" value="<?php echo $_SESSION['kana']; ?>" placeholder=" (例)サトウタロウ　ひらがなはカタカナに変換します。" required maxlength="30" />
		<h5>年齢</h5>
		<input type="var" name="age" value="<?php echo $_SESSION['age']; ?>" placeholder=" (例)24" maxlength="3" />
		<h5>性別</h5>
		<p>
			<label>
				<input type="radio" name="sex" value="男性" <?php
					if ($_SESSION['sex'] === "男性"){
						echo 'checked';
					}?> />
				<span>男性</span>
			</label>
		</p>
		<p>
			<label>
				<input type="radio" name="sex" value="女性" <?php
					if ($_SESSION['sex'] === "女性"){
						echo "checked";
					}
						?> />
				<span>女性</span>
			</label>
		</p>
		<h5>電話番号(ハイフンなし)<em>(必須)</em></h5>
		<input type="text" name="telcode" value="<?php echo $_SESSION['telcode']; ?>" placeholder=" (例)1234567890" required maxlength="20">
		<h5>メールアドレス<em>(必須)</em></h5>
		<input type="text" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder=" (例)example@gmail.com" required maxlength="127" /><br /><br />
		<button class="btn waves-effect waves-light" type="submit" name="action">
			確認
		</button>
	</form>
</div>
<?php require_once("./template/system_footer.php"); ?>