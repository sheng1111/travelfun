<?php
session_start();
include_once 'dbconnect.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");
//關於我
//顯示個人資料
//可以在這裡加別人好友
//顯示好友清單(自己可以維護好友)
/*-----------------------------*/
//初始化
//未給ID「且」未登入值直接跳轉首頁
//預設id為自己
if (!isset($_GET['id'])) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
    } else {
        header("Location: index.php");
    }
} else {
    $id = strip_tags($_GET['id']);
}

//顯示個人資料(好友數)
//自己不顯示加好友按鈕
//顯示好友數、行程數(連公開行程)、大頭貼、名稱、電子郵件(顯示?or功能)
//好友狀態判別
//若已加過顯示信息,自己不可加
$sql = "SELECT * FROM `user` WHERE user_id='" . $id . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['user_name'];
$email = $row['user_email'];
//$photo=$row['photo'];
$introduction = $row['introduction'];
//$Authority=$row['Authority'];
//顯示行程數
$countitinerarysql = "SELECT count(`itinerary_id`) as 行程數  FROM `itinerary` WHERE `user_id`='$id'";
$countitineraryresult = mysqli_query($con, $countitinerarysql);
$countitineraryrow = mysqli_fetch_assoc($countitineraryresult);
$countitinerary = $countitineraryrow['行程數'];
//顯示隱藏行程數
$hideitinerarysql = "SELECT count(`itinerary_id`) as 隱藏行程  FROM `itinerary` WHERE `user_id`='$id' and public_status=2";
$hideitineraryresult = mysqli_query($con, $hideitinerarysql);
$hideitineraryrow = mysqli_fetch_assoc($hideitineraryresult);
$hide = $hideitineraryrow['隱藏行程'];
//判別好友狀態
if (isset($_GET['id'])) {
    $checksql = "select * from friend where `friend_id` in (SELECT `friend_id` FROM `friend` WHERE `oneself`='" . $_SESSION['user_id'] . "' or `others`='" . $_SESSION['user_id'] . "') and `oneself`='" . $_GET['id'] . "' or `others`='" . $_GET['id'] . "'";
    $checkresult = mysqli_query($con, $checksql);
    $checkrow = mysqli_fetch_assoc($checkresult);
    $friendid = $checkrow['friend_id'];
    $status = $checkrow['status'];
    $others = $checkrow['others'];
}
//每頁顯示10筆資料(項次跨頁壘加)
//自己可維護好友
//顯示待審核名單(限自己)
if (isset($_GET['Approved']) && isset($_SESSION['user_id'])) {
    $sql2 = "SELECT * FROM `friend` WHERE status is null  and friend_id in (select friend_id from friend where  `others`='$id' ) ORDER BY `friend`.`friend_id` ASC";
} else
//顯示好友
{
    $sql2 = "SELECT * FROM `friend` WHERE status = 1 and friend_id in (select friend_id from friend where `oneself` = '$id' or `others`='$id' )  ORDER BY `friend`.`friend_id` ASC";
}
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);
//指定每頁顯示幾筆記錄
$records_per_page = 10;
//取得要顯示第幾頁的記錄
if (isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = 1;
//取得記錄數
$total_records = mysqli_num_rows($result2);
//計算總頁數
$total_pages = ceil($total_records / $records_per_page);
//計算本頁第一筆記錄的序號
$started_record = $records_per_page * ($page - 1);
//將記錄指標移至本頁第一筆記錄的序號
if ($total_records != 0)
    mysqli_data_seek($result2, $started_record);
//名稱回應
if (isset($_GET["page"])) {
    $pagelink = "&page=" . $_GET["page"];
}
if ($id != $_SESSION['user_id']) {
    $link = "id=" . $id . $pagelink;
} else {
    $link = "page=";
}
//鏈結設定
//好友顯示及尋找用戶有分頁
//待審核名單不分頁(顯示全部資料)
if (isset($_GET['Approved'])) {
    $place = "待審核名單";
} else if (isset($_GET['search'])) {
    $place = "搜尋會員:" . $_GET['search'];
} else {
    $place = "好友名單";
}
//核准成為好友
if (isset($_GET['Approved_id'])) {
    $approvid = strip_tags($_GET['Approved_id']);
    $statussql = "UPDATE `friend` SET `status`=1 WHERE `friend_id`=" . $approvid . " and others='" . $_SESSION['user_id'] . "'";
    if (mysqli_query($con, $statussql)) {
        header("Location:about.php?Approved=true");
    } else {
        echo "<script> alert('核准失敗!');parent.location.href='about.php?Approved=false'; </script>";
    }
}
//新增好友
if (isset($_GET['addfriend'])) {
    $searchid = $_GET['search'];
    $_SESSION['nowid'] = $_GET['addfriend'];
    $nowid = $_SESSION['nowid'];
    $addid = strip_tags($_GET['addfriend']);
    $checkfriendsql = "select * from friend where `friend_id` in (SELECT `friend_id` FROM `friend` WHERE `oneself`='" . $_SESSION['user_id'] . "' or `others`='" . $_SESSION['user_id'] . "') and `oneself`='" . $addid . "' or `others`='" . $addid . "'";
    $checkfriendresult = mysqli_query($con, $checkfriendsql);
    $checkfriendrow = mysqli_fetch_assoc($checkfriendresult);
    if (empty($checkfriendrow)) {
        $addfriendsql = "INSERT INTO `friend`(`oneself`, `others`) VALUES ('" . $_SESSION['user_id'] . "','" . $addid . "')";
        if (mysqli_query($con, $addfriendsql)) {
            header("Location:about.php?id=" . $nowid);
        } else {
            echo "<script> alert('查無對方帳號!');parent.location.href='about.php?id=" . $nowid . "'; </script>";
        }
    } else {
        echo "<script> alert('你已經與他(她)成為好友囉!');parent.location.href='about.php?id=" . $nowid . "'; </script>";
    }
}
//刪除好友
if (isset($_GET['del'])) {
    $delid = strip_tags($_GET['del']);
    $delfriendsql = "DELETE FROM`friend` WHERE `friend_id` = " . $delid . " and oneself='" . $_SESSION['user_id'] . "' or others='" . $_SESSION['user_id'] . "'"; //刪除好友
    mysqli_query($con, $delfriendsql);
    if(isset($_GET['Approved'])){$Approvedurl="Approved=true";}
    if(isset($_GET['Approved'])&&isset($_GET['id'])){$and="&";}
    if(isset($_GET['id'])){$idurl="id=".$id;}
        header("Location:about.php?$Approvedurl$and$idurl");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>關於我<?php if (isset($name)) {
                    echo "-" . $name;
                } ?>｜TravelFun</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="icon" href="image/favicon.png" type="image/ico" />
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
                                <a class="dropdown-item" href="about.php">🚩景點</a>
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
                <?php if (!isset($_GET['search'])) { ?>
                    <h3 class='text-center card-title'><b><?php echo $name; ?></b></h3>
                    <center>
                        <?php if (isset($_GET['id']) && $_GET['id'] != $_SESSION['user_id']) {
                            if (empty($checkrow)) { ?>
                                <input class="btn btn-info btn-sm" type="button" value="成為好友" onclick="location.href='about.php?id=<?php echo $_GET['id']; ?>&addfriend=<?php echo $_GET['id']; ?>'" />
                            <?php } else if ($status == 1) { ?>
                                <input class="btn btn-danger btn-sm" type="button" value="刪除好友" onclick="location.href='about.php?id=<?php echo $_GET['id']; ?>&del=<?php echo $friendid; ?>'" />
                            <?php } else { ?>
                                <input class="btn btn-info btn-sm" type="button" value="<?php if ($others == $_SESSION['user_id']) {
                                                                                            echo "批准";
                                                                                        } else {
                                                                                            echo "等待";
                                                                                        } ?>成為好友" onclick="location.href='about.php?id=<?php echo $_GET['id']; ?> <?php if ($others == $_SESSION['user_id']) {
                                                                                                                                                                        echo "&Approved_id=" . $friendid;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "&del=" . $friendid;
                                                                                                                                                                    } ?>'" />
                        <?php }
                        } ?>
                        <?php
                        if ($id == $_SESSION['user_id'] && !isset($_GET['search'])) {
                            if (!isset($_GET['Approved'])) { ?>
                                <button class="btn btn-primary btn-sm" type="button" name="Approved" onclick="location.href='about.php?Approved=true'">待審核好友</button>
                            <?php } else { ?>
                                <button class="btn btn-primary btn-sm" type="button" name="Approved" onclick="location.href='about.php'">查看好友名單</button>
                        <?php }
                        } ?>
                        <?php if ($id != $_SESSION['user_id']) { ?>
                            <button class="btn btn-info btn-sm" type="button" onclick="location.href='itineraries.php?id=<?php echo $id; ?>'">查看他的行程</button>
                        <?php } ?>
                    </center>
                    <hr>
                    電子郵件:<?php echo " <a href='mailto:" . $email . "'><font color='black'>" . $email . "</font></a>"; ?> <br>
                    個人簡介:<?php echo $introduction.$addfriendsql; ?> <br>
                    <hr>
                <?php } ?>
                <h4 class='text-center card-title'><b><?php echo $place; ?></b></h4>
                <center>好友數:<?php echo $total_records; ?><p>
                        <center>
                            <table class='table'>
                                <thead>
                                    <tr align='center' valign='center'>
                                        <td>項次</td>
                                        <td>
                                            <nobr>姓名</nobr>
                                        </td>
                                        <?php if (isset($_GET['Approved']) && $id == $_SESSION['user_id']) { ?>
                                            <td>
                                                <nobr>批准</nobr>
                                            </td>
                                        <?php }
                                        if ($id == $_SESSION['user_id']) { ?>
                                            <td>
                                                <nobr>刪除</nobr>
                                            </td>
                                        <?php } ?>
                                </thead>
                                <tbody>
                                    <?php
                                    $j = 1;
                                    while ($row2 = mysqli_fetch_assoc($result2) and $j <= $records_per_page) {
                                        $friend_id = $row2['friend_id'];
                                        $oneself = $row2['oneself'];
                                        $other = $row2['others'];
                                        if ($oneself == $id) {
                                            $out_id = $other;
                                        } else {
                                            $out_id = $oneself;
                                        }
                                        $selectsql = "select * from user where user_id='" . $out_id . "'";
                                        $selectresult = mysqli_query($con, $selectsql);
                                        $selectrow = mysqli_fetch_assoc($selectresult);
                                        $out_name = $selectrow['user_name'];
                                        $j++;
                                    ?>
                                        <tr align="center" valign="center">
                                            <th><?php echo $j - 1; ?></th>
                                            <th><a href=?id=<?php echo $out_id; ?>><?php echo $out_name ?></a></th>
                                            <?php if ($id == $_SESSION['user_id'] && isset($_GET['Approved'])) { ?>
                                                <th><a href=?Approved_id=<?php echo $friend_id; ?>>✔</a></th>
                                            <?php } ?>
                                            <?php if ($id == $_SESSION['user_id']) {
                                                    if(isset($_GET['Approved'])){$Approvedurl="Approved=true&";}
                                                    if(isset($_GET['id'])){$idurl="id=".$id."&";} ?>
                                            
                                                <th><a href=?<?php echo $Approvedurl.$idurl; ?>del=<?php echo $friend_id; ?>>❌</a></th>
                                            <?php } ?>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                            <ul class="pagination">
                                <li class="page-item">
                                    <?php
                                    //產生導覽列
                                    echo "<p align='center'>";
                                    if ($total_pages > 1) {
                                        if ($page > 1) {
                                            echo "<li class='page-item'><a class='page-link' href='about.php?$link" . ($page - 1) . "'>上一頁</a> </li> ";
                                            for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                                if ($i == $page)
                                                    echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                                else
                                                if ($i <= 0) {
                                                } else
                                                    echo "<li class='page-item'><a class='page-link' href='about.php?$link$i'>$i</a></li> ";
                                            }
                                        }
                                        for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                            if ($i == $page)
                                                echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                            else
                                                echo "<li class='page-item'><a class='page-link' href='about.php?$link$i'>$i</a></li> ";
                                        }
                                        if ($page < $total_pages) {
                                            echo "<li class='page-item'><a class='page-link' href='about.php?$link" . ($page + 1) . "'>下一頁</a></li>";
                                            echo "</p>";
                                        }
                                    }
                                    ?>
                                </li>
                            </ul>
                            </td>

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