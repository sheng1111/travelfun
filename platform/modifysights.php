<?php
session_start();
include '../dbconnect.php';
include '../function.php';
date_default_timezone_set("Asia/Taipei");
mysqli_query($con, "SET NAMES UTF8");
//使用者登入情況下可自動賦予管理權限
if (isset($_SESSION['user_id'])) {
    $sql = "SELECT Authority FROM user WHERE user_id = '" . $_SESSION["user_id"] . "'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row)) {
        $_SESSION['Authority'] = $row['Authority'];
        //顯示主功能頁面
    } else {
        header("Location:../index.php");
    }
} else {
    header("Location: ../login.php");
}
if (isset($_GET['view_id'])) {
    $_SESSION['do'] = strip_tags($_GET['view_id']);
}
$view_id = $_SESSION['do'];
$select = "SELECT * from `sight` where `view_id`='" . $view_id . "'";
$result1 = mysqli_query($con, "$select");
$row = mysqli_fetch_assoc($result1);
$view_name = $row["view_name"];
$shortcode = $row["shortcode"];
$timestamp = $row["timestamp"];
$tag_area = $row["tag_area"];
$source = $row["source"];
if (isset($_POST['submit'])) {
    $view_name = $_POST["view_name"];
    $shortcode = $_POST["shortcode"];
    $timestamp =  strtotime($_POST["timestamp"]);
    $tag_area = $_POST["tag_area"];
    $source = $_POST["source"];
    $updatesql = "UPDATE `sight` SET
    `view_name` = '$view_name',
    `shortcode` = '$shortcode',
    `timestamp` = '$timestamp',
    `tag_area`= '$tag_area',
    `source` ='$source'
    WHERE  `view_id` =$view_id";
    if (mysqli_query($con, $updatesql)) {
        header("Location:managesight.php");
    } else {
        echo "<script>alert(更新失敗!);</script>";
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (isset($view_name)) echo "修改" . $view_name;
            else echo "修改景點"; ?> | 管理後台</title>
    <link rel="icon" href="../image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mdb.min.css">
    <link rel='stylesheet' href='https://rawgit.com/adrotec/knockout-file-bindings/master/knockout-file-bindings.css'>
    <link rel="stylesheet" href="../css/addsight.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top stylish-color-dark">
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
                        <li class="nav-link p-0"> <a class="nav-link" href="index.php"><img src="../image/return.png" alt="返回使用者介面" height="25" width="25"></a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="../logout.php"><img src="../image/logout.png" alt="登出" height="25" width="25"></a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="py-md-5">
            <div class="container">
                <form class="text-center p-5 col-md-6 offset-md-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <h4 class="text-center card-title"><b>修改景點</b></h4>
                    <hr class="">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>☀景點名稱</label>
                            <input type="text" name="view_name" value="<?PHP echo $view_name; ?>" class="form-control mb-4" placeholder="景點名稱">
                        </div>
                        <div class="form-group col-md-8">
                            <label>☀貼文代碼<?php if ($facebookswitch == 1) echo "(連結)" ?></label>
                            <input type="text" name="shortcode" value="<?PHP echo $shortcode; ?>" class="form-control mb-4" placeholder="貼文代碼">
                        </div>
                        <div class="form-group col-md-8">
                            <label>☀發文時間</label>
                            <input type="text" name="timestamp" value="<?PHP echo date("Y/m/d H:i:s", $timestamp); ?>" class="form-control mb-4" placeholder="發文時間">
                        </div>
                        <div class="form-group col-md-8">
                            <label>☀發文地點</label>
                            <input type="text" name="tag_area" value="<?PHP echo $tag_area; ?>" class="form-control mb-4" placeholder="發文地點">
                        </div>
                        <?php if ($facebookswitch == 1) { ?>
                            <div class="form-group col-md-8">
                                <label>☀貼文來源</label>
                                <select name="source" class="form-control mb-4" required>
                                    <option value="" disabled="disabled">請選擇來源</option>
                                    <option value="0" <?php if (!(strcmp("0", $source))) {
                                                            echo "selected=\"selected\"";
                                                        } ?>>Instagram
                                    <option value="1" <?php if (!(strcmp("1", $source))) {
                                                            echo "selected=\"selected\"";
                                                        } ?>>FaceBook
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <center><input class="btn btn-info btn-block my-4 btn-lg" type="submit" name="submit" value="修改景點"></center>
                    <center><input class="btn btn-info btn-block my-4 btn-lg" type="button" name="button" value="回上一頁" onClick="location.href='managesight.php'"></center>
                    </p>
                </form>
            </div>
        </div>
    </main>

    <footer class="page-footer font-small stylish-color-dark fixed-bottom">
        <div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
    </footer>

    <script type="text/javascript" src="../js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js'></script>
    <script type="text/javascript" src="../js//knockout-file-bindings.js"></script>
    <script type="text/javascript" src="../js/addsight.js"></script>
    <script src="../js/jquery.samask-masker.js"></script>
    <script>
        $(function() {
            $.samaskHtml();
            $('.phone').samask("(0000)000-0000");
            $('.hour').samask("00:00:00");
            $('.date').samask("00/00/0000");
            $('.date_hour').samask("0000/00/00 00:00:00");
            $('.ip_address').samask("000.000.000.000");
            $('.percent').samask("%00");
            $('.mixed').samask("SSS-000");
        });
    </script>
</body>

</html>