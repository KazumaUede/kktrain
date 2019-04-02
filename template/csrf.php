<?php
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
?>