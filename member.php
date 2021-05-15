<?php
session_start();
include_once 'dbconnect.php';
//驗證登入狀態
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$search = $_GET['search'];
if (isset($_GET['search']) && isset($_SESSION['user_id'])) {
    $search = strip_tags($_GET['search']);
    //呈現會員資料
    $sql   = "SELECT * FROM `user`";
    $sql  .= " where user_id like '%" . $search . "%' or user_name like '%" . $search . "%'";
}
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
if (empty($row)) {
    echo "<script> alert('查無會員!');parent.location.href='search.php'; </script>";
}
//指定每頁顯示幾筆記錄
$records_per_page = 10;
//取得要顯示第幾頁的記錄
if (isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = 1;
//取得記錄數
$total_records = mysqli_num_rows($result);
//計算總頁數
$total_pages = ceil($total_records / $records_per_page);
//計算本頁第一筆記錄的序號
$started_record = $records_per_page * ($page - 1);
//將記錄指標移至本頁第一筆記錄的序號
if ($total_records != 0)
    mysqli_data_seek($result, $started_record);
$pagelink = "&page=";
if (isset($_GET['search'])) {
    $link = "search=" . $_GET['search'] . $pagelink;
}
//核准成為好友
if (isset($_GET['Approved_id'])) {
    $approvid = strip_tags($_GET['Approved_id']);
    $statussql = "UPDATE `friend` SET `status`=1 WHERE `friend_id`=" . $approvid . " and others='" . $_SESSION['user_id'] . "'";
    if (mysqli_query($con, $statussql)) {
        header("Location:member.php?search=" . $search . "");
    } else {
        echo "<script> alert('核准失敗!');parent.location.href='member.php?search=" . $search . "'; </script>";
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
            header("Location:member.php?search=" . $nowid);
        } else {
            echo "<script> alert('查無對方帳號!');parent.location.href='member.php?search=" . $nowid . "'; </script>";
        }
    } else {
        echo "<script> alert('你已經與他(她)成為好友囉!');parent.location.href='member.php?search=" . $nowid . "'; </script>";
    }
}
//刪除好友
if (isset($_GET['del'])) {
    $delid = strip_tags($_GET['del']);
    $delfriendsql = "DELETE FROM`friend` WHERE `friend_id` = " . $delid . " and oneself='" . $_SESSION['user_id'] . "' or others='" . $_SESSION['user_id'] . "'"; //刪除好友
    mysqli_query($con, $delfriendsql);
    header("Location:member.php?search=" . $_GET['search']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>搜尋會員-<?php echo $_GET['search']; ?> ｜TravelFun</title>
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
                <form class="p-5 col-md-6 offset-md-3">
                    <h4 class='text-center card-title'><b><?php echo "搜尋會員-" . $_GET['search']; ?></b></h4>
                    <table class="table">
                        <thead>
                            <tr align="center" valign="center">
                                <td>項次</td>
                                <td>
                                    <nobr>姓名</nobr>
                                </td>
                                <td>
                                    <nobr>狀態</nobr>
                                </td>
                        </thead>
                        <tbody>
                            <?php
                            $j = 1;
                            while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                                $user_id      = $row['user_id'];
                                $user_name    = $row['user_name'];
                                $check2sql = "select * from friend where `friend_id` in (SELECT `friend_id` FROM `friend` WHERE `oneself`='" . $_SESSION['user_id'] . "' or `others`='" . $_SESSION['user_id'] . "') and `oneself`='" . $user_id . "' or `others`='" . $user_id . "'";
                                $checkresult2 = mysqli_query($con, $check2sql);
                                $checkrow2 = mysqli_fetch_assoc($checkresult2);
                                $friend_id = $checkrow2['friend_id'];
                                $others = $checkrow2['others'];
                                $status = $checkrow2['status'];
                            ?>
                                <tr align="center" valign="center">
                                    <th><?php echo $j; ?></th>
                                    <th><?php echo "<a href='about?search=" . $user_id . "' color='#000000'>" . $user_name . "</a>"; ?></th>
                                    <th>
                                        <?php if (empty($checkrow2)) { ?>
                                            <input class="btn btn-info btn-sm" type="button" value="成為好友" onclick="location.href='member.php?search=<?php echo $_GET['search']; ?>&addfriend=<?php echo $user_id; ?>'" />
                                        <?php } else if ($status == 1) { ?>
                                            <input class="btn btn-danger btn-sm" type="button" value="刪除好友" onclick="location.href='member.php?search=<?php echo $_GET['search']; ?>&del=<?php echo $friend_id; ?>'" />
                                        <?php } else { ?>
                                            <input class="btn btn-info btn-sm" type="button" value="<?php if ($others == $_SESSION['user_id']) {
                                                                                                        echo "批准";
                                                                                                    } else {
                                                                                                        echo "等待";
                                                                                                    } ?>成為好友" onclick="location.href='member.php?search=<?php echo $_GET['search']; ?> <?php if ($others == $_SESSION['user_id']) {
                                                                                                                                                                                                                                                                echo "&Approved_id=" . $friend_id;
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo "&del=" . $friend_id;
                                                                                                                                                                                                                                                            } ?>'" />
                                        <?php } ?>
                                    </th>
                                </tr>
                            <?php $j = $j + 1;
                            } ?>
                        </tbody>
                    </table>
                    <ul class="pagination">
                        <li class="page-item">
                            <?php
                            //產生導覽列
                            echo "<p align='center'>";
                            if ($total_pages > 1) {
                                if ($page > 1) {
                                    echo "<li class='page-item'><a class='page-link' href='member.php?$link" . ($page - 1) . "'>上一頁</a> </li> ";
                                    for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                        if ($i == $page)
                                            echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                        else
                                                if ($i <= 0) {
                                        } else
                                            echo "<li class='page-item'><a class='page-link' href='member.php?$link$i'>$i</a></li> ";
                                    }
                                }
                                for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                        echo "<li class='page-item'><a class='page-link' href='member.php?$link$i'>$i</a></li> ";
                                }
                                if ($page < $total_pages) {
                                    echo "<li class='page-item'><a class='page-link' href='member.php?$link" . ($page + 1) . "'>下一頁</a></li>";
                                    echo "</p>";
                                }
                            }
                            ?>
                        </li>
                    </ul>
                    <center><input class="btn btn-info btn-sm" type="button" value="返回上頁" onclick="location.href='search.php'" /></center>
                </form>
            </div>
        </div>
    </main>

    <footer class="page-footer font-small unique-color fixed-bottom">
        <div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
    </footer>

    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>