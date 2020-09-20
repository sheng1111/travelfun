<?php
session_start();
include_once '../dbconnect.php';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>管理後台</title>
	<link rel="icon" href="../image/favicon.png" type="image/ico" />
	<link rel="stylesheet" type="text/css" href="../css/platform_style.css">

</head>

<body>
	<div class="login-box">
		<h2>Login</h2>
		<form>
			<div class="user-box">
				<input type="text" name="" required="">
				<label>Username</label>
			</div>
			<div class="user-box">
				<input type="password" name="" required="">
				<label>Password</label>
			</div>
			<a href="#">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
				Submit
			</a>
		</form>
	</div>
</body>

</html>