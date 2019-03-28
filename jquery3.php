<?php
	session_start();

	if (isset($_POST['csrf_token'])
	&& $_POST['csrf_token'] === $_SESSION['csrf_token']) {
		echo "正常なリクエストです";
		$formcheck = true;
	} else {
		echo "不正なリクエストです";
		$formcheck = false;
	}
	//トークン作成
	function get_csrf_token() {
		$TOKEN_LENGTH = 16;//16*2=32バイト
		$bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
		return bin2hex($bytes);
	}
	$_SESSION['csrf_token'] = get_csrf_token();
	$_SESSION['name'] = !isset($_SESSION['name'])? '' : $_POST['name'] ;
	$_SESSION['password'] = !isset($_SESSION['password'])? '' : $_POST['password'] ;



	//ヘッダ
	$pagetitle = "セクション";
	require_once("./template/system_header.php"); ?>
<form action="" method="Post">
	<div class = "title_container">
		<div class ="inputswitch">
			<h5>投稿フォーム</h5>
		</div>
	</div>
	<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
	<h5>名前<em>(必須)</em></h5>
	<div class = "error_msg" id="name"></div>
		<div class = "name_container">
			<div class ="inputswitch">
				<input type="text" name="name" value="" placeholder=" (例)佐藤太郎" required maxlength="30" />
			</div>
		</div>
	<h5>おまじない<em>(必須)</em></h5>
	<div class = "error_msg" id="password"></div>
		<div class = "password_container">
			<div class ="inputswitch">
				<input  type="text" name="password" value="" placeholder="(例)となりの４８はあ０１" required maxlength="30" />
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