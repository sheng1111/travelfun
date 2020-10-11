<?php
session_start();
include_once '../dbconnect.php';
if (isset($_POST['login'])) {
    $sql="SELECT * FROM admin WHERE admin_id = '" . $_POST["admin_id"]. "' and admin_password = '" . $_POST["admin_password"] . "'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);

	if (!empty($row)) {
		$_SESSION['admin_id'] = $row['admin_id'];
		$_SESSION['admin_name'] = $row['admin_name'];
		header("Location:addsight.php");
	} else {
        $errormsg = "帳號或密碼輸入錯誤!!!";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>管理後台</title>
	<link rel="icon" href="../image/favicon.png" type="image/ico" />
	<link rel="stylesheet" type="text/css" href="../css/platform_style.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/mdb.min.css">

</head>

<body>
	<header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top unique-color">
            <div class="container">
                <a class="navbar-brand" href="index.php"><strong>管理員介面</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['admin_id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['admin_name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-item p-0"> <a class="nav-link disabled" href="index.php">新增景點</a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="addsight.php"><img src="../image/addsight.png" alt="新增景點" height="25" width="25"></a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="logout.php"><img src="../image/logout.png" alt="登出" height="25" width="25"></a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
	<div class="login-box">
		<h2>登入</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
			<div class="user-box">
				<input type="text" name="admin_id" required="請輸入帳號">
				<label>帳號</label>
			</div>
			<div class="user-box">
				<input type="password" name="admin_password" required="請輸入密碼">
				<label>密碼</label>
			</div>
			<center><button class="btn btn-info btn-block my-4" type="submit" name="login">登入</button></center>
		</form>
	</div>


	<script type="text/javascript" src="../js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>