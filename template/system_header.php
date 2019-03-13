<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo isset($pagetitle)? $pagetitle: "";?></title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./css/reset.css">
	<link rel="stylesheet" href="./css/style.min.css">
	<link rel="stylesheet" href="./css/color.css">
	<?php 
	$name = './css/' . str_replace(".php", "", basename($_SERVER['PHP_SELF'])) .'.min.css';
	if (file_exists($name)){
		echo '<link rel="stylesheet" href="'. $name .'">'; 	
	}?>
</head>

<body>
	<?php
		require_once(dirname(__FILE__) . "/header.php");
	?>