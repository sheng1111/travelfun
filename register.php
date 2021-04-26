<?php
session_start();
include_once 'dbconnect.php';
include 'function.php';
include 'sendmail.php';
if (isset($_SESSION['user_id'])) {
    header("Location:login.php");
}

//check if form is submitted
if (isset($_POST['signup'])) {
    $error = false;
    $key_id = $_POST['user_id'];
    $cheek_password = $_POST['cheek_password'];
    $userpassword = $_POST['user_password'];
    $username = $_POST['user_name'];
    $useremail = $_POST['user_email'];
    //檢查帳號重複
    $check = "SELECT * FROM `user` WHERE `user_id` ='" . $key_id . "'";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row)) {
        $error = true;
        $id_error = "這個帳號已經有人註冊過了!";
    }
    //檢查信箱重複
    $check2 = "SELECT * FROM `user` WHERE `user_email` ='" . $useremail . "'";
    $result2 = mysqli_query($con, $check2);
    $row2 = mysqli_fetch_assoc($result2);
    if (!empty($row2)) {
        $error = true;
        $email_error = "這個信箱已經有人註冊過了!";
    }

    //給予user_key
    $random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

    if (strlen($userpassword) < 6) {
        $error = true;
        $password_error = "你的密碼不能小於6碼喔!";
    }
    if ($userpassword != $cheek_password) {
        $error = true;
        $cpassword_error = "兩次密碼輸入要相同喔!";
    }


    if (!$error) {
        $sql = "INSERT INTO `user`(`user_id`, `user_name`, `user_email`, `user_password`, `user_key`) VALUES
		('" . $key_id . "', '" . $username . "','" . $useremail . "','" . $userpassword . "', '" . $random . "')";
        if (mysqli_query($con, $sql)) {
            $title = "TravelFun會員驗證信件";
            $content = '<span style="color:red">** 本郵件由系統自動發送，請勿直接回覆 **</span> <p>' . $username . '，您好! <br>'
                . "請點選下方「驗證」按鈕完成驗證:<br>"
                . "<a href='127.0.0.1:8000/travelfun_test/membercentre/verification.php?key=" . $random . "' style='text-decoration:none; color:black;'> 驗證 </a>" . '<p><p><span style="color:#878787">--</span>
            <br><span style="color:#878787">Best Regard</span><br>
            <span style="color:#878787">TravelFun團隊</span>';
            $result = "<script> alert('成功寄出密碼');parent.location.href='login.php'; </script>";
            sendmail($username, $useremail, $title, $content, $result);
        } else {
            $errormsg = "註冊失敗，請重新註冊一次!";
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
    <title>註冊｜TravelFun</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
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
                <a class="navbar-brand" href="index.php"><strong>Travel Fun</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['user_name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-link p-0"> <a class="nav-link" href="search.php"><img src="image/search.png" alt="搜尋" height="25" width="25"></a> </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="image/all.png" alt="總覽" height="25" width="25"></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                                <a class="dropdown-item" href="tag.php">📁分類</a>
                                <a class="dropdown-item" href="result.php">🚩景點</a>
                                <a class="dropdown-item" href="itineraries.php">🧾行程</a>
                            </div>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="image/login.png" alt="login" height="25" width="25"></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <a class="dropdown-item" href="membercentre/manageFavorites.php">❤收藏</a>
                                    <a class="dropdown-item" href="membercentre/manageitinerary.php">🧾行程</a>
                                    <a class="dropdown-item" href="membercentre/modifyindividual.php">🔩設定</a>
                                    <a class="dropdown-item" href="about.php">👱關於我</a>
                                    <?php if ($_SESSION['Authority'] == 2) {
                                        echo "<a class='dropdown-item' href='platform/index.php'>💻管理員介面</a>";
                                    } ?>
                                    <a class="dropdown-item" href="logout.php">登出</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="login.php">📲登入</a>
                                    <a class="dropdown-item" href="register.php">📋註冊</a>
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
                <form class="text-center p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                    <h4 class="text-center card-title"><b>註冊</b></h4>
                    <hr class="">
                    <div class="form-group"><input type="text" name="user_id" class="form-control mb-4" placeholder="請輸入帳號" required>
                        <span class="text-danger"><?php if (isset($id_error)) echo $id_error; ?></span>
                    </div>
                    <div class="form-group"><input type="password" name="user_password" class="form-control mb-4" placeholder="請輸入密碼" required>
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>
                    <div class="form-group"><input type="password" name="cheek_password" class="form-control mb-4" placeholder="請再次輸入密碼" required>
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>
                    <div class="form-group"><input type="text" name="user_name" class="form-control mb-4" placeholder="請輸入姓名" required></div>
                    <div class="form-group"><input type="email" name="user_email" class="form-control mb-4" placeholder="電子郵件" required></div>
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
            </div>
            <center><input type="submit" name="signup" value="註冊" class="btn btn-info my-4 btn-lg "></center>
            <span class="text-success"><?php if (isset($successmsg)) echo $successmsg; ?></span>
            <span class="text-danger"><?php if (isset($errormsg)) {
                                            echo $errormsg;
                                        } ?></span>
            <div class="text-center">
                <!--
                        <p>or sign up with:</p>
                        <a type="button" class="light-blue-text mx-2"><i class="fab fa-facebook-f"></i></a>
                        <a type="button" class="light-blue-text mx-2"><i class="fab fa-twitter"></i></a>
                        <a type="button" class="light-blue-text mx-2"><i class="fab fa-linkedin-in"></i></a>
                        <a type="button" class="light-blue-text mx-2"><i class="fab fa-github"></i></a>
                         -->
            </div>
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