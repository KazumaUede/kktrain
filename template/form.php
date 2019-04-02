<form id="formajax" action="" method="Post">
	<h6><?php echo $title; ?></h6>
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
	<h6>パスワード<em>(必須)</em></h6>
		<div class = "password_container">
			<div class ="inputswitch">
				<input  type="password" name="password" value="" placeholder="(例)となりの４８はあ０１" required maxlength="30" />
			</div>
		</div>
	<div class = "button_container">
		<div class ="inputswitch">