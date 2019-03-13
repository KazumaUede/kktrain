<?php
	require_once("./template/htmlspecialchars.php");
	session_start();
	if(!isset($_SESSION)) {
		header('location:form.php');
		exit;		
	}
	$check_list = ['zipcode','address','name','kana','age','telcode','email'];
	foreach($check_list as $text){
		if(!isset($_POST[$text])){
			header('location:form.php');
			exit;
			
		}
	}

	$_SESSION['error'] =[];

	function check_post($s) {
		if(!isset($_POST[$s])){
			$_POST[$s] ='';
		}else{
			$_SESSION[$s] = h($_POST[$s]);
		}
	};
	check_post('prefectures');
	check_post('sex');
	$_SESSION['zipcode'] =mb_convert_kana(h(trim($_POST['zipcode'])),'n');


	$_SESSION['address'] = h($_POST['address']);
	$_SESSION['name'] = h($_POST['name']);
	$_SESSION['kana'] = mb_convert_kana(h($_POST['kana']),'CKV');
	$_SESSION['age'] =mb_convert_kana(h(trim($_POST['age'])),'n');

	$_SESSION['telcode'] =mb_convert_kana(h(trim($_POST['telcode'])),'n');
	$_SESSION['email'] = h(trim($_POST['email']));

	//入力内容チェック。
	if ($_SESSION['zipcode'] === ''){
		$_SESSION['error']['zipcode'] = "郵便番号: 必須項目です。";
	}elseif (!preg_match("/^\d{7}$/",$_SESSION['zipcode'])){
		$_SESSION['error']['zipcode'] = "郵便番号: 数字7桁を入力してください。";
	}
	if ($_SESSION['prefectures'] === ''){
		$_SESSION['error']['prefectures'] = "住所_都道府県: 必須項目です。";
	}
	if ($_SESSION['address'] === ''){
		$_SESSION['error']['address'] = "住所_市区町村以下: 必須項目です。";
	}
	if ($_SESSION['name'] === ''){
		$_SESSION['error']['name'] = "名前: 必須項目です。";
	}
	if ($_SESSION['kana'] === ''){
		$_SESSION['error']['kana'] = "フリガナ: 必須項目です。";
	}elseif(!preg_match("/^([ァ-ン]|ー)+$/u",$_SESSION['kana'])){
		$_SESSION['error']['kana'] = "フリガナ: 英数字は無効です。";
	}
	if ($_SESSION['age'] !== '' && !preg_match("/^[0-9]+$/",$_SESSION['age'])){
		$_SESSION['error']['telcode'] = "年齢: 数字を入力してください。";
	}

	if ($_SESSION['telcode'] === ''){
		$_SESSION['error']['telcode'] = "電話番号: 必須項目です。";
	}elseif (!preg_match("/[0-9]{10,20}/",$_SESSION['telcode'])){
		$_SESSION['error']['telcode'] = "電話番号: ハイフンを抜くか、使用できるものを入力してください。";
	}
	if ($_SESSION['email'] === ''){
		$_SESSION['error']['email'] = "メールアドレス: 必須項目です。";
	}elseif (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$_SESSION['email'])){
		$_SESSION['error']['email'] = "メールアドレス: 使用できるものを入力してください。";
	}

	//ひとつでもエラーがあればフォームに戻る。
	if (!empty($_SESSION['error'])){
		header('location:form.php');
		exit;
	}
	$pagetitle = "応募フォーム";
	require_once("./template/system_header.php");
?>
<div class="container">
	<h5>以下の内容でよろしいですか？</h5>
	<div class="divider"></div>
	<ul>
		<li>
			郵便番号:<em><?php echo h($_SESSION['zipcode']); ?></em>
		</li>
		<li>
			住所　　:<em><?php echo h($_SESSION['prefectures']) .  h($_SESSION['address']); ?></em>
		</li>
		<li>
			氏名　　:<em><?php 	echo h($_SESSION['name']); ?></em>
		</li>
		<li>
			かな　　:<em><?php echo h($_SESSION['kana']); ?></em>
		</li>
		<li>
			年齢　　:<em><?php echo h($_SESSION['age']); ?></em>
		</li>
		<li>
			性別　　:<em><?php echo h($_SESSION['sex']); ?></em>
		</li>
		<li>
			電話番号:<em><?php echo h($_SESSION['telcode']); ?></em>
		</li>
		<li>
			Email 　 :<em><?php echo h($_SESSION['email']); ?></em>
		</li>
	</ul>
	<div class="buttonlist">
		<form action="form.php" method="Post">
			<button type="submit" class="waves-effect waves-light btn">修正する</button>
		</form>
		<br>
		<form action="comp.php" method="Post">
			<button type="submit" class="waves-effect waves-light btn">応募する</button>
		</form>
	</div>
</div>
<?php require_once("./template/system_footer.php"); ?>
