<?php
session_start();
include_once '../dbconnect.php';
include '../function.php';
if (isset($_SESSION['user_id'])) {
} else {
	header("Location: ../login.php");
}

$result = mysqli_query($con, "SELECT * FROM user WHERE `user`.`user_id` = '" . $_SESSION['user_id'] . "'");
$row = mysqli_fetch_assoc($result);
$id = $row["user_id"];
$useremail = $row["user_email"];
$username = $row["user_name"];
$introduction = 	$row["introduction"];
$databasepassword = $row["user_password"];


if (isset($_POST['submit'])) {
	$username = strip_tags($_POST['user_name']);
	$rowuseremail = $row["user_email"];
	$useremail = strip_tags($_POST['user_email']);
	$userpassword = hash('sha512',base64_encode(strip_tags($_POST['password'])));
	$checkpassword = hash('sha512',base64_encode(strip_tags($_POST['checkpassword'])));
	$oldpassword = hash('sha512',base64_encode(strip_tags($_POST['oldpassword'])));
	$introduction = 	strip_tags($_POST["introduction"]);

	//檢查信箱重複
	$check = "SELECT * FROM `user` WHERE `user_email` ='" . $useremail . "' and  `user_email`!='" . $rowuseremail . "'";
	$result = mysqli_query($con, $check);
	$row = mysqli_fetch_assoc($result);
	if (!empty($row)) {
		$error = true;
		$email_error = "這個信箱已經有人註冊過了!";
	}
	if($useremail != $rowuseremail && $_POST['oldpassword'] == ""){
		$error = true;
		$email_error = "請輸入舊密碼才能變更信箱!";
	}

	if ($_POST['oldpassword'] != "") {
		if (strlen($_POST['password']) < 6 && $_POST['checkpassword'] != "") {
			$error = true;
			$password_error = "你的密碼不能小於6碼喔!";
		}
		if ($userpassword != $checkpassword) {
			$error = true;
			$cpassword_error = "兩次密碼輸入要相同喔!";
		}
		if ($databasepassword != $oldpassword) {
			$error = true;
			$upassword_error = "您的舊密碼輸入錯誤!";
		}
		if ($_POST['password'] == "" or $_POST['checkpassword'] == "") {
			$userpassword = $databasepassword;
		}
	} else if ($_POST['password'] != "" or $_POST['checkpassword'] != "") {
		$error = true;
		$errormsg = "修改個人資料失敗";
		$upassword_error2 = "請輸入舊密碼才能更改密碼喔!";
	} else {
		$userpassword = $databasepassword;
	}

	$random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

	if (!$error) {
		$_SESSION['user_name'] = $username;
		$sqlUpdate = "UPDATE user SET
				user_email='" . $useremail . "',
				user_name='" . $username . "',
				user_password='" . $userpassword . "',
				user_key='" . $random . "',
				introduction='" . $introduction . "'
				WHERE `user_id` = '" . $id . "'";
		if (mysqli_query($con, $sqlUpdate)) {
			if(isset($_COOKIE["user_key"]))
			{$_SESSION['user_key']=$random;}
			$successmsg = "修改個人資料成功";
		} else {
			$errormsg = "修改個人資料失敗";
		}
	}
}
?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Travel Fun">
	<meta name="keywords" content="Travel">
	<title>修改個人資料｜TravelFun</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
	<!-- Google Fonts Roboto -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/mdb.min.css">
	<link rel="icon" href="../image/favicon.png" type="image/ico" />
	<link rel="stylesheet" href="../css/style.css">
	<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark fixed-top unique-color">
			<div class="container">
				<a class="navbar-brand" href="../index.php"><strong>Travel Fun</strong></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
					<ul class="navbar-nav">
						<?php if (isset($_SESSION['user_id'])) { ?>
							<li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['user_name']; ?>!</a></li>
						<?php } else  ?>
						<li class="nav-link p-0"> <a class="nav-link" href="../search.php"><img src="../image/search.png" alt="搜尋" height="25" width="25"></a> </li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../image/all.png" alt="總覽" height="25" width="25"></a>
							<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
								<a class="dropdown-item" href="../tag.php">📁分類</a>
								<a class="dropdown-item" href="../result.php">🚩景點</a>
								<a class="dropdown-item" href="../itineraries.php">🧾行程</a>
							</div>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../image/login.png" alt="login" height="25" width="25"></a>
							<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
								<?php if (isset($_SESSION['user_id'])) { ?>
									<a class="dropdown-item" href="manageFavorites.php">❤收藏</a>
									<a class="dropdown-item" href="manageitinerary.php">🧾行程</a>
									<a class="dropdown-item" href="modifyindividual.php">🔩設定</a>
									<a class="dropdown-item" href="../about.php">👱關於我</a>
									<?php if ($_SESSION['Authority'] == 2) {
										echo "<a class='dropdown-item' href='../platform/index.php'>💻管理者介面</a>";
									} ?>
									<a class="dropdown-item" href="../logout.php">登出</a>
								<?php } else { ?>
									<a class="dropdown-item" href="../login.php">📲登入</a>
									<a class="dropdown-item" href="../register.php">📋註冊</a>
								<?php } ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>

	<main>
		<div class="py-md-5">
			<div class="container">
				<form class="p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
					<h4 class="text-center card-title"><b>設定</b></h4>
					<hr class="">
					<div class="form-group"><label for="name"> ☀帳號</label>
						<input type="text" name="id" value="<?PHP echo $id; ?>" class="form-control mb-4" disabled="true" />
					</div>

					<div class="form-group"><label for="name">☀電子郵件</label>
						<input type="hidden" name="rowemail" value="<?PHP echo $useremail; ?>">
						<input type="email" name="user_email" value="<?PHP echo $useremail; ?>" class="form-control mb-4" />
					</div>
					<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

					<div class="form-group"><label>☀姓名</label>
						<input type="text" name="user_name" class="form-control mb-4" value="<?PHP echo $username; ?>" />
					</div>

					<div class="form-group"><label for="name">☀輸入舊密碼</label>
						<input type="password" name="oldpassword" maxlength="20" placeholder="輸入舊密碼" class="form-control mb-4" />
					</div>
					<span class="text-danger"><?php if (isset($upassword_error)) echo $upassword_error; ?></span>

					<div class="form-group"><label for="name">☀輸入新密碼</label>
						<input type="password" name="password" maxlength="20" placeholder="輸入新密碼" class="form-control mb-4" />
					</div>
					<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>

					<div class="form-group"><label for="name">☀再次輸入新密碼</label>
						<input type="password" name="checkpassword" maxlength="20" placeholder="再次輸入新密碼" class="form-control mb-4" />
					</div>
					<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
					<div class="form-group"><label for="name">☀自我介紹</label>
						<textarea name="introduction"><?php echo $introduction; ?></textarea>
						<script>
							CKEDITOR.replace('introduction');
						</script>
						<center><button class="btn btn-info btn-block my-4" type="submit" name="submit">更改個資</button></center>
						<!-- 顯示結果 -->
						<span class="text-success"><?php if (isset($successmsg)) echo $successmsg; ?></span>
						<span class="text-danger"><?php if (isset($errormsg))  echo $errormsg; ?></span>
						<span class="text-success"><?php if (isset($photosuccessmsg)) echo $photosuccessmsg; ?></span>
						<span class="text-danger"><?php if (isset($photoerrormsg))  echo $photoerrormsg; ?></span>
				</form>
			</div>
		</div>
	</main>

	<footer class="page-footer font-small unique-color fixed-bottom">
		<div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
	</footer>

	<script type="text/javascript" src="../js/mdb.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>