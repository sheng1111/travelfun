<?php
session_start();
include_once 'dbconnect.php';
if(isset($_SESSION['user_id'])!="") {
	header("Location: index.php");
}

$sql2 = "SELECT * FROM user WHERE user_key = '" . $_COOKIE["user_key"]. "'";
$row2 = mysqli_fetch_assoc(mysqli_query($con, $sql2));
if($_COOKIE["user_key"] = $row2["user_key"]){
    $_SESSION['user_id'] = $row2["user_id"];
    $_SESSION['user_name'] = $row2["user_name"];
    header("Location: index.php");
}

//check if form is submitted
if (isset($_POST['login'])) {
    $sql="SELECT * FROM user WHERE user_id = '" . $_POST["user_id"]. "' and user_password = '" . $_POST["user_password"] . "'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);

	if (!empty($row)) {
		$_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];


        if(!empty($_POST["remember"])) {
            setcookie ("user_key", $row["user_key"], time()+ (60*60));
        }

        header("Location: index.php");
    }
    else{$errormsg = "帳號或密碼輸入錯誤!!!";}
}

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>登入｜TravelFun</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="icon" href="image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top unique-color">
            <div class="container">
                <a class="navbar-brand" href="index.php" ><strong>Travel Fun</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['user_name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-item p-0"> <a class="nav-link disabled" href="index.php">登入</a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="404.html"><img src="image/itinerary.png" alt="itineray" height="25" width="25"></a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="search.php"><img src="image/search.png" alt="search" height="25" width="25"></a> </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"><img src="image/login.png" alt="login" height="25" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default"aria-labelledby="navbarDropdownMenuLink-333">
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <a class="dropdown-item" href="update.php">修改個資</a>
                                    <a class="dropdown-item" href="logout.php">登出</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="login.php">登入</a>
                                    <a class="dropdown-item" href="register.php">註冊</a>
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
                <form class="text-center p-5 col-md-6 offset-md-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                    <h4 class="text-center card-title"><b>使用者登入</b></h4>
					<hr class="">
                    <!-- Email -->
                    <div class="form-group"><input type="text" name="user_id" class="form-control mb-4" placeholder="請輸入帳號" value="<?PHP echo $_COOKIE["user_id"] ?>" ></div>
                    <!-- Password -->
                    <div class="form-group"><input type="password" name="user_password"  class="form-control mb-4" placeholder="請輸入密碼" value="<?PHP echo $_COOKIE["user_password"] ?>"></div>
                    <span class="text-danger"><?php if (isset($errormsg)) echo $errormsg; ?></span>
                    <div class="d-flex justify-content-around">
                        <div>
                            <!-- Remember me -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember" name="remember">
                                <label class="custom-control-label" for="defaultLoginFormRemember">自動登入</label>
                            </div>
                        </div>
                        <div><a href="forgot_password.php">忘記密碼</a></div>
                    </div>
                    <!-- Sign in button -->
                    <center><button class="btn btn-info btn-block my-4" type="submit" name="login">登入</button></center>
                    <!-- Register -->
                    <p>不是會員?<a href="register.php">註冊</a></p>
                    <!--
                    <p>or sign in with:</p>
                    <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
                    <a href="#" class="mx-2" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
                    <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
                    <a href="#" class="mx-2" role="button"><i class="fab fa-github light-blue-text"></i></a>
                     --><!--尚未完成 -->

                </form>
            </div>
        </div>
    </main>

    <footer class="page-footer font-small unique-color fixed-bottom">
        <div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
    </footer>

    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>