<?php
//管理會員功能
session_start();
include '../dbconnect.php';
include '../function.php';
include '../sendmail.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");
$id = strip_tags($_GET['id']);
//卸除會員SESSION
unset($_SESSION['do']);
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

//呈現會員資料
$sql   = "SELECT `user_id`,`user_name`, `user_email`, `Authority` FROM `user`";
//搜尋使用者
if (isset($_GET['search_id'])) {
    $id = strip_tags($_GET['search_id']);
    $sql .= " where user_id like '%$id%' or user_name like '%$id%'";
}
//選擇呈現順序
if (isset($_GET['sequence'])) {
    if ($_GET['sequence'] == 1) {
        $sql .= " ORDER BY `Authority` ASC";
    }
    if ($_GET['sequence'] == 2) {
        $sql .= " ORDER BY `Authority` desc";
    }
}
$query = mysqli_query($con, $sql);
//指定每頁顯示幾筆記錄
$records_per_page = 10;
//取得要顯示第幾頁的記錄
if (isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = 1;
//取得記錄數
$total_records = mysqli_num_rows($query);
//計算總頁數
$total_pages = ceil($total_records / $records_per_page);
//計算本頁第一筆記錄的序號
$started_record = $records_per_page * ($page - 1);
//將記錄指標移至本頁第一筆記錄的序號
if ($total_records != 0)
    mysqli_data_seek($query, $started_record);
//頁面模式選擇
if ($_GET['sequence'] == 1) {
    $echomode = "sequence=1&page=";
} {
    if (!empty($_GET["search"])) {
        $echomode = "search=" . $_GET['search_id'] . "&page=";
    } {
        if ($_GET['sequence'] == 2) {
            $echomode = "sequence=2page=";
        } else {
            $echomode = "page=";
        }
    }
}
//寄信給使用者忘記密碼
if (isset($_GET['send'])) {
    $id = strip_tags($_GET['send']);
    $sql1 = "SELECT * FROM user where user_id='" . $id . "'";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $useremail = $row1["user_email"];
    $username = $row1["user_name"];
    $random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $sqlUpdate = "UPDATE user SET Authority=0,user_key='" . $random . "' where `user_id`='" . $id . "'";
    if (mysqli_query($con, $sqlUpdate)) {
        $title = "TravelFun會員密碼重設信件";
        $content = '<span style="color:red">** 本郵件由系統自動發送，請勿直接回覆 **</span> <p>' . $username . '，您好! <br>'
            . "請點選下方修改密碼按鈕或連結完成密碼修改:<br>"
            . "<a href='127.0.0.1:8000/travelfun/membercentre/forgot_password.php?key=" . $random . "' style='text-decoration:none; color:black;'> 修改密碼 </a><p>"
            . "如按鈕點擊無效，請直接點選連結: 127.0.0.1:8000/travelfun/membercentre/forgot_password.php?key=" . $random
            . "<p><span style='color:#878787'>--</span>"
            . '<br><span style="color:#878787">Best Regard</span><br>"
        <span style="color:#878787">TravelFun團隊</span>';
        $result = "<script> alert('成功寄出信件');parent.location.href='managemember.php'; </script>";
        if (sendmail($username, $useremail, $title, $content, $result)) {
            echo "<script> alert('寄信成功!');parent.location.href='managemember.php'; </script>";
        } else {
            echo "<script> alert('寄信失敗!');parent.location.href='managemember.php'; </script>";
        }
    } else {
        echo "<script> alert('發生異常!');parent.location.href='managemember.php'; </script>";
    }
}

//刪除使用者
if (isset($_GET['delete'])) {
    $del = strip_tags($_GET['delete']);
    //先刪除行程
    $selectsql   = "SELECT * FROM `itinerary` where user_id='" . $del . "'";
    $selquery = mysqli_query($con, $selectsql);
    // fetch multiple row using while loop.
    while ($row1 = mysqli_fetch_assoc($selquery)) {
        $delsql = "DELETE FROM`sequence` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        $delsql1 = "DELETE FROM`share` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        $delsql2 = "DELETE FROM`itinerary` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        mysqli_query($con, $delsql);
        mysqli_query($con, $delsql1);
        mysqli_query($con, $delsql2);
    }
    //單獨刪除項目
    $del3sql = "DELETE FROM`favorites` WHERE `user_id` = '" . $del . "'"; //刪除收藏
    $del4sql = "DELETE FROM`friend` WHERE `oneself` = '" . $del . "' or `others` ='" . $del . "'"; //刪除好友
    $del5sql = "DELETE FROM`user` WHERE `user_id` = '" . $del . "'"; //刪除使用者
    mysqli_query($con, $del3sql);
    mysqli_query($con, $del4sql);
    mysqli_query($con, $del5sql);
    header("Location:managemember.php");
}
?>

<script language="javascript">
    function del(id, name) {
        var msg = "您真的確定要刪除嗎？\n\n請確認！";
        if (confirm(msg) == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理會員 | 管理後台</title>
    <link rel="icon" href="../image/favicon.png" type="image/ico" />
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
                <div class="row">
                    <div class="text-center p-5 col-lg-10 offset-lg-1">
                        <fieldset></fieldset>
                        <h4 class="text-center card-title"><b>會員管理</b></h4>
                        <table class="table">
                            <tr>
                                <td><input class="btn btn-secondary btn-block btn-sm" type="button" value="新增會員" onclick="location.href='addmember.php'" /></td>
                                <td>
                                    <?php if ($_GET['sequence'] == 1 || $_GET['sequence'] == null) { ?>
                                        <input class="btn btn-secondary btn-block btn-sm" type="button" value="位階(低)優先" onclick="location.href='managemember.php?<?php if (!empty($_GET['search_id'])) {
                                                                                                                                                                        echo "search_id=" . $id . "&";
                                                                                                                                                                    } ?>sequence=2'" />
                                    <?php }
                                    if ($_GET['sequence'] == 2) { ?>
                                        <input class="btn btn-secondary btn-block btn-sm" type="button" value="位階(高)優先" onclick="location.href='managemember.php?<?php if (!empty($_GET['search_id'])) {
                                                                                                                                                                        echo "search_id=" . $id . "&";
                                                                                                                                                                    } ?>sequence=1'" />
                                    <?php } ?>
                                </td>
                                <form class="" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form">
                                    <td Width="300"><input type="text" name="search_id" class="form-control" required /></td>
                                    <td><button class="btn btn-primary btn-block btn-sm" type="submit" name="search" value=true>搜尋會員</button></td>
                                </form>
                                <td></td>
                            </tr>
                        </table>
                        <table class="table">
                            <thead>
                                <tr align="center" valign="center">
                                    <td>項次</td>
                                    <td>
                                        <nobr>會員帳號</nobr>
                                    </td>
                                    <td>
                                        <nobr>會員名稱</nobr>
                                    </td>
                                    <td>
                                        <nobr>電子信箱</nobr>
                                    </td>
                                    <td>
                                        <nobr>身分</nobr>
                                    </td>
                                    <td>
                                        <nobr>密碼修改</nobr>
                                    </td>
                                    <td>
                                        <nobr>修改</nobr>
                                    </td>
                                    <td>
                                        <nobr>刪除</nobr>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $j = 0; //計數
                                while ($row = mysqli_fetch_row($query) and $j <= $records_per_page) {
                                    $a = "<b style='color:red;'>" . $id . "</b>";
                                    $j = $j + 1;
                                    $user_id      = $row[0];
                                    $user_name    = $row[1];
                                    $user_email     = $row[2];
                                    $Authority    = $row[3];
                                ?>
                                    <tr align="center" valign="center">
                                        <th><?php echo $j; ?></th>
                                        <th><?php echo str_replace($id, $a, $user_id); ?></th>
                                        <th><?php echo str_replace($id, $a, $user_name); ?></th>
                                        <th><?php echo $user_email; ?></th>
                                        <th><?php
                                            if ($Authority == 2) {
                                                echo "管理員";
                                            } else {
                                                if ($Authority == 1) {
                                                    echo "一般會員";
                                                } else {
                                                    if ($Authority == 0 || $Authority = null) {
                                                        echo  "未驗證會員";
                                                    }
                                                }
                                            }
                                            ?></th>
                                        <th><?php if ($user_name != $_SESSION['user_id']) {
                                                echo "<a href=?send=" . $user_id . ">✉️ </a>";
                                            }  ?></th>
                                        <th><?php if ($user_name != $_SESSION['user_id']) {
                                                echo "<a href=modifymember.php?id=" . $user_id . "> 📝</a>";
                                            } ?></th>
                                        <th><?php if ($user_name != $_SESSION['user_id']) {
                                                echo "<a href=?delete=" . $user_id . "> ❌</a>";
                                            }  ?></th>
                                    <?php } ?>
                                    </tr>
                            </tbody>
                        </table>
                        <ul class="pagination">
                            <li class="page-item">
                                <?php
                                //產生導覽列
                                echo "<p align='center'>";
                                if ($total_pages > 1) {
                                    if ($page > 1) {
                                        echo "<li class='page-item'><a class='page-link' href='managemember.php?$echomode" . ($page - 1) . "'>上一頁</a> </li> ";
                                        for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                            if ($i == $page)
                                                echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                            else
                                                if ($i <= 0) {
                                            } else
                                                echo "<li class='page-item'><a class='page-link' href='managemember.php?$echomode$i'>$i</a></li> ";
                                        }
                                    }
                                    for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                        if ($i == $page)
                                            echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                        else
                                            echo "<li class='page-item'><a class='page-link' href='managemember.php?$echomode$i'>$i</a></li> ";
                                    }
                                    if ($page < $total_pages) {
                                        echo "<li class='page-item'><a class='page-link' href='managemember.php?$echomode" . ($page + 1) . "'>下一頁</a></li>";
                                        echo "</p>";
                                    }
                                }
                                ?>

                            </li>
                        </ul>
                    </div>
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
</body>

</html>