<?php 
	session_start();
	if(!isset($_SESSION)) {
		header('location:form.php');
		exit;		
	}
	$check_list = ['zipcode','prefectures','address','name','kana','telcode','email'];

	foreach($check_list as $text){
		if($_SESSION[$text] === ""){
			header('location:form.php');
			exit;
			
		}
	}
	if($_SESSION['age'] ===''){
		$_SESSION['age'] = NULL;
	}
	if($_SESSION['sex'] ===''){
		$_SESSION['sex'] = NULL;
	}

	try {
		// MySQLサーバへ接続
		$pdo = new PDO("mysql:host=localhost; dbname=formtest;charset=utf8",
					   "Kazuma_U", "nakuyobou3");
	} catch(PDOException $e){
		var_dump($e->getMessage());
	}
	$sql ="INSERT INTO users (zipcode,prefectures,address,name,kana,age,sex,telcode,email) VALUE (?,?,?,?,?,?,?,?,?) ";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute([$_SESSION['zipcode'],$_SESSION['prefectures'],$_SESSION['address'],$_SESSION['name'],$_SESSION['kana'],$_SESSION['age'],$_SESSION['sex'],$_SESSION['telcode'],$_SESSION['email']]);

	$pdo = null;
	session_unset();
	$pagetitle = "投稿完了";
	require_once("./template/system_header.php");
?>
<div class="container">
	<h6>応募が完了しました。</h6>
	<h6>Thank you for your entry!</h6>
	<input type="button" onclick="location.href='form.php'"value="戻る">
</div>
<?php require_once("./template/system_footer.php"); ?>
