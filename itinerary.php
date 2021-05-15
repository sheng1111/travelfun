<?php
//顯示所有行程的詳細資訊
session_start();
include 'dbconnect.php';
date_default_timezone_set("Asia/Taipei");
$user_id = $_SESSION['user_id'];
$id = strip_tags($_GET['id']);
mysqli_query($con, "SET NAMES UTF8");
$googlemapurl = "https://www.google.com/maps/dir/";

//讀取行程名稱
$sql1 = "SELECT `itinerary`.`itinerary_name`,`itinerary`.`public_status`,`itinerary`.`itinerary_date`,`itinerary`.`itinerary_days`,`itinerary`.`user_id`,`user`.`user_name`";
$sql1 .= " FROM itinerary , user";
$sql1 .= " WHERE itinerary_id=" . $id . " and";
$sql1 .= " `itinerary`.`user_id`=`user`.`user_id`";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($result1);
$itinerary_name = $row1["itinerary_name"];
$public_status = $row1["public_status"];
$itinerary_date = $row1["itinerary_date"];
$itinerary_days = $row1["itinerary_days"];
$user_id = $row1["user_id"];
$user_name = $row1["user_name"];
//讀取行程裡的景點順序
$sql   = "SELECT sequence.view_id , sight.view_name, sequence.opt_day,sight.shortcode,sight.source FROM `sequence`,sight WHERE `itinerary_id`=$id and sequence.view_id=sight.view_id ";
$sql  .= "ORDER BY `sequence`.`opt_day`,`sequence`.`sequence`  ASC";
$query = mysqli_query($con, $sql);
$total_records1 = mysqli_num_rows($query);
//跑出google輸出行程
$sql2   = "SELECT sequence.view_id , sight.view_name FROM `sequence`,sight WHERE `itinerary_id`=$id and sequence.view_id=sight.view_id ";
$sql2  .= "ORDER BY `sequence`.`opt_day`,`sequence`.`sequence`  ASC";
$query2 = mysqli_query($con, $sql2);
$total_records2 = mysqli_num_rows($query2);
if ($total_records2 != 0) {
    while ($row2 = mysqli_fetch_row($query2)) {
        $view_id      = $row2[0];
        $view_name    = $row2[1];
        //確認是否有輸入過地址
        $checkaddresssql = "SELECT * FROM `note` where view_id=" . $view_id;
        $checkaddressresult = mysqli_query($con, $checkaddresssql);
        $checkaddressrow = mysqli_fetch_assoc($checkaddressresult);
        if (!empty($checkaddressrow)) {
            $address = "+" . $checkaddressrow['address'];
        } else {
            $address = "";
        }
        $url = $url . $view_name . $address . "/";
    }
}
//檢視存取權限
if ($public_status != 1) {
    $check = "SELECT itinerary.`user_id` FROM `itinerary`,`share` WHERE `share`.`itinerary_id`= $id and`share`.`user_id` ='" . $_SESSION['user_id'] . "' and `itinerary`.`itinerary_id`=`share`.`itinerary_id`";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row)) {
    } else {
        $check1 = "SELECT `user_id` FROM `itinerary` WHERE `itinerary_id`= $id and `user_id` ='" . $_SESSION['user_id'] . "'";
        $result1 = mysqli_query($con, $check1);
        $row1 = mysqli_fetch_assoc($result1);
        if (!empty($row1)) {
        } else {
            header("Location: index.php");
        }
    }
}
//設定day變數
$day = $_GET['day'];
if ($day <= 0 || $day == null) {
    $day = 1;
}
if ($day >= $itinerary_days) {
    $day = $itinerary_days;
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>行程-<?php echo $itinerary_name;  ?> | TravelFun</title>
    <link rel="icon" href="image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel='stylesheet' href='https://rawgit.com/adrotec/knockout-file-bindings/master/knockout-file-bindings.css'>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="css/result.css">
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
            <div class="container2">
                <div class="row">
                    <div class="text-center p-5 col-lg-10 offset-lg-1">
                        <fieldset></fieldset>
                        <h4 class="text-center card-title"><b><?php echo $itinerary_name; ?></b></h4>
                        <hr>
                        <td colspan="2" align="center" valign="top">
                            <?php
                            $totalday = $itinerary_days - 1;
                            echo "<B>起始日期：</B>" . date("Y年m月d日", strtotime($itinerary_date)) . "</p>";
                            echo "<B>終止日期：</B>" . date("Y年m月d日", strtotime($itinerary_date . "+ " . $totalday . " day")) . "(共" . $itinerary_days . "天)</p>";
                            echo "<B>發文者:</B><a href='about.php?id=" . $user_id . "'>" . $user_name . "</a></p>";
                            ?>
                        </td>
                        <table class="table">
                            <thead>
                                <tr align="center" valign="center">
                                    <td align='center'>項次</td>
                                    <td align='center'>景點名稱</td>
                                    <td align='center'>出遊日期</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $j = 0;
                                if ($total_records1 != 0) {
                                    while ($row2 = mysqli_fetch_row($query)) {
                                        $j = $j + 1;
                                        $view_id      = $row2[0];
                                        $view_name    = $row2[1];
                                        $opt_day      = $row2[2] - 1;
                                        $shortcode    = $row2[3];
                                        $source       = $row2[4];
                                ?>
                                        <tr align="center" valign="center">
                                            <th align='center'><?php echo $j; ?></th>
                                            <th align='center'><?php echo "<a href=";
                                                                //景點鏈結顯示
                                                                if ($source == 0) {
                                                                    echo "https://www.instagram.com/p/";
                                                                }
                                                                if ($source == 1) {
                                                                    if (strpos($shortcode, "http") !== false) {
                                                                        echo ("");
                                                                    } else {
                                                                        echo $facebooklink;
                                                                    }
                                                                }
                                                                echo $shortcode . ">" . $view_name . "</a>"; ?></th>
                                            <th align='center'><?php echo date("m月d日", strtotime($itinerary_date . "+ " . $opt_day . " day")); ?></th>

                                        <?php } ?>
                                    <?php } else { ?> <td colspan="8" align="center" valign="center" style="font-size:24px;font-weight:bold;"> 很抱歉!目前暫時沒有規劃!</td> <?php } ?>
                                        </tr>
                            </tbody>
                            <table class="table">
                                <tr>
                                    <?php if ($public_status == 1) { ?>
                                        <div align="center">
                                            <a title="facebook 點選開啟新視窗" href="javascript: void(window.open(&#39;http://www.facebook.com/share.php?u=&#39;+encodeURIComponent(location.href)+&#39;&amp;t=&#39;+encodeURIComponent(document.title)));"> <img src="image/facebook.png" width="35" height="35"></a>
                                            <a title="twitter 點選開啟新視窗" href="javascript: void(window.open(&#39;http://twitter.com/home/?status=&#39;.concat(encodeURIComponent(document.title)) .concat(&#39; &#39;) .concat(encodeURIComponent(location.href))));"><img src="image/twitter.png" width="35" height="35"></a>
                                            <a title="plurk 點選開啟新視窗" href="javascript: void(window.open(&#39;http://www.plurk.com/?qualifier=shares&amp;status=&#39; .concat(encodeURIComponent(location.href)) .concat(&#39; &#39;) .concat(&#39;(&#39;) .concat(encodeURIComponent(document.title)) .concat(&#39;)&#39;)));"><img src="image/plurk.png" width="35" height="35"></a>
                                            <a title="line 點選開啟新視窗" href="javascript: void(window.open(&#39;http://line.me/R/msg/text/?&#39;.concat(encodeURIComponent(&#39;&#39;)).concat(encodeURIComponent(location.href)) ));"><img src="image/line.png" width="35" height="35"> </a>
                                        </div>
                                    <?php } ?>

                                </tr>
                                <tr>
                                    <?php
                                    //可修改內容
                                    if (isset($user_id)) {
                                        $check = "SELECT `user_id`,`itinerary_id` FROM `itinerary` WHERE `itinerary_id`= $id and `user_id` ='" . $_SESSION['user_id'] . "'";
                                        $result = mysqli_query($con, $check);
                                        $row = mysqli_fetch_assoc($result);
                                        $check1 = "SELECT itinerary.`user_id`,itinerary.`itinerary_id` FROM `itinerary`,`share` WHERE `share`.`itinerary_id`= $id and`share`.`user_id` ='" . $_SESSION['user_id'] . "' and `itinerary`.`itinerary_id`=`share`.`itinerary_id`";
                                        $result1 = mysqli_query($con, $check1);
                                        $row1 = mysqli_fetch_assoc($result1);
                                        $r1id = $row['itinerary_id'];
                                        $r2id = $row1['itinerary_id'];

                                        if (!empty($user_id)) { ?>
                                            <td>
                                                <input class='btn btn-info btn-block btn-sm' type='button' value='返回' onclick="location.href='membercentre/manageitinerary.php'" />
                                            </td>
                                        <?php }
                                        if (!empty($row1)) { ?>
                                            <td>
                                                <input class='btn btn-info btn-block btn-sm' type='button' value='共筆行程' onclick="location.href='membercentre/shareitinerary.php'" />
                                            </td>
                                        <?php }
                                        if (!empty($row) || !empty($row1)) { ?>
                                            <td>
                                                <input class='btn btn-info btn-block btn-sm' type='button' value='編輯行程' onclick="location.href='membercentre/modifyitinerary.php?id= <?php if (!empty($r1id)) {
                                                                                                                                                                                            echo intval($r1id);
                                                                                                                                                                                        }
                                                                                                                                                                                        if (!empty($r2id)) {
                                                                                                                                                                                            echo intval($r2id);
                                                                                                                                                                                        }
                                                                                                                                                                                        if (!empty($row1)) echo "&share=1";
                                                                                                                                                                                    } ?>'" />
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input class='btn btn-danger btn-block btn-sm ' type='button' value='行程規劃' onclick="location.href='<?php echo $googlemapurl . $url; ?>'" />
                                        </td>
                                </tr>
                            </table>
                        </table>
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