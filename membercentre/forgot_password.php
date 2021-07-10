<?php
include_once '../dbconnect.php';
include '../sendmail.php';
include '../function.php';
//接收key
if (isset($_GET['key'])) {
    $key = strip_tags($_GET['key']);
    $sql = "SELECT * FROM user WHERE user_key = '" . $key . "'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sql));
    if (!empty($row)) {
        $id = $row['user_id'];
    } else {
        echo "<script> alert('連結已失效!');parent.location.href='../index.php'; </script>";
    }
}
//設定新密碼
if (isset($_POST['change'])) {
    $userpassword = strip_tags($_POST['password']);
    $checkpassword = strip_tags($_POST['checkpassword']);
    $key = strip_tags($_POST['user_key']);
    if (strlen($userpassword) < 6) {
        $error = true; {
            echo "<script> alert('你的密碼不能小於6碼喔!');parent.location.href='forgot_password.php?key=" . $key . "'; </script>";
        }
    }
    if ($userpassword != $checkpassword) {
        $error = true; {
            echo "<script> alert('兩次密碼輸入要相同喔!');parent.location.href='forgot_password.php?key=" . $key . "'; </script>";
        }
    }
    if (!$error) {
        $random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $sqlUpdate = "UPDATE user SET
        user_password='" . hash('sha512',base64_encode($userpassword)) . "',
        user_key='" . $random . "',
        Authority=1
        WHERE `user_key` = '" . $key . "'";
        if (mysqli_query($con, $sqlUpdate)) {
            echo "<script> alert('修正成功!');parent.location.href='../login.php'; </script>";
        } else {
            header("Location: forgot_password.php?key=" . $key . "");
        }
    }
}
//寄送忘記密碼信件
if (isset($_POST['forgot_password'])) {
    $sql = "SELECT * FROM user WHERE user_id = '" . $_POST["user_id"] . "' and user_email = '" . $_POST["user_email"] . "'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sql));
    if (!empty($row)) {
        $random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $sqlUpdate = "UPDATE user SET user_key='" . $random . "', Authority=0 WHERE user_id = '" . $_POST["user_id"] . "'";
    } else {
        $errormsg = "輸入的帳號和信箱不符!!!";
    }

    if (mysqli_query($con, $sqlUpdate)) {
        $user_name = $row["user_name"];
        $user_email = $row["user_email"];
        $title = "TravelFun會員密碼重設信件";
        $content = '<span style="color:red">** 本郵件由系統自動發送，請勿直接回覆 **</span> <p>' . $user_name . '，您好! <br>'
            . "請點選下方修改密碼按鈕或連結完成密碼修改:<br>"
            . "<a href='127.0.0.1:8000/travelfun/membercentre/forgot_password.php?key=" . $random . "' style='text-decoration:none; color:black;'> 修改密碼 </a><p>"
            . "如按鈕點擊無效，請直接點選連結: 127.0.0.1:8000/travelfun/membercentre/forgot_password.php?key=" . $random
            . "<p><span style='color:#878787'>--</span>"
            . '<br><span style="color:#878787">Best Regard</span><br>"
        <span style="color:#878787">TravelFun團隊</span>';
        $result = "<script> alert('成功寄出信件');parent.location.href='../login.php'; </script>";
        //寄信
        sendmail($user_name, $user_email, $title, $content, $result);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>忘記密碼｜TravelFun</title>
    <link rel="icon" href="image/favicon.png" type="../image/ico" />
    <link rel="stylesheet" type="text/css" href="../css/platform_style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mdb.min.css">

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
        <?php if (!isset($_GET['key'])) { ?>
            <div class="py-md-5">
                <div class="container">
                    <form class="p-5 col-md-6 offset-md-3" method="post">
                        <h4 class="text-center card-title"><b>忘記密碼</b></h4>
                        <div class="user-box">
                            <label>帳號</label>
                            <input type="text" name="user_id" required="請輸入帳號">
                        </div>
                        <div class="user-box">
                            <label>信箱</label>
                            <input type="email" name="user_email" required="請輸入信箱">

                        </div>
                        <center><button class="btn btn-info btn-block my-4" type="submit" name="forgot_password" value=true>忘記密碼</button></center>
                        <?php if (isset($errormsg)) echo $errormsg; ?>
                    </form>
                </div>
            </div> <?php }
                if (isset($_GET['key'])) { ?>
            <div class="py-md-5">
                <div class="container">
                    <form class="p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h4 class="text-center card-title"><b>重設密碼</b></h4>
                        <div class="user-box">
                            <label>新密碼</label>
                            <input type="hidden" name="user_key" value=<?php echo $key; ?>>
                            <input type="password" name="password" required="請輸入密碼">

                            <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                        </div>
                        <div class="user-box">
                            <label>再次輸入新密碼</label>
                            <input type="password" name="checkpassword" required="請再次輸入密碼">
                            <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                        </div>
                        <center><button class="btn btn-info btn-block my-4" type="submit" name="change" value=true>變更密碼</button></center>
                        <?php if (isset($errormsg)) echo $errormsg; ?>
                    </form>
                </div>
            </div>
        <?php } ?>

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