<?php
session_start();
include '../dbconnect.php';
include '../function.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");
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
//呈現景點
if ($_GET['repeat'] != true) {
    $sql   = "SELECT `view_id`,`view_name`, `shortcode`, `timestamp`, `tag_area`,`status`  FROM `sight`";
    //附加搜尋
    //附加暫存區
    if ($_GET['mode'] == 1) {
        if (isset($_GET['tag'])) {
            $sql  .= " where `tag_area`='" . $_GET['tag'] . "' ";
            if($_GET['source']=="FaceBook")
            {$sql .=" and source=1";}
            else
            {$sql .=" and source=0";}
            $sql .="and status is null or status !=1";
        } else 
        $sql  .= " WHERE ";
        if($_GET['source']=="FaceBook")
        {$sql .=" source=1 and ";}
        else
        {$sql .=" source=0 and ";}
        $sql .="status is null or status !=1";
    } else {

        //搜尋景點(無法搜尋)
        if (isset($_GET['search'])) {
            $name = strip_tags($_GET['search']);
            $sql .= " where `view_name` like '%$name%' and status =1 ";
        } else {
            $sql  .= " WHERE status =1";
        }
        if (isset($_GET['tag'])) {
            $sql  .= " and `tag_area`='" . $_GET['tag'] . "'";
        }
    }
    //搜尋來源設定
    if($_GET['source']=="FaceBook")
    {$sql .=" and source=1";}
    else
    {$sql .=" and source=0";}
    $sql .= " group by `view_name` having count(1)";
}
//附加重複景點
else {
    $sql = "SELECT `view_id`, `view_name`, `shortcode`, `timestamp`, `tag_area`,`status` FROM `sight` where";
        //搜尋來源設定
        if($_GET['source']=="FaceBook")
        {$sql .=" source=1 and";}
        else
        {$sql .=" source=0 and";}
    $sql .=" `view_name` in (SELECT `view_name` FROM `sight`"; 
            //搜尋來源設定
            if($_GET['source']=="FaceBook")
            {$sql .=" where source=1";}
            else
            {$sql .="where source=0";}
    $sql .=" group by `view_name` HAVING count(`view_name`)>1)";
    if (isset($_GET['tag'])) {
        $sql  .= " and `tag_area`='" . $_GET['tag'] . "'";
    }
    if($_GET['source']=="FaceBook")
    {$sql .=" and source=1";}
    else
    {$sql .=" and source=0";}
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
//計算重複警點數
$repeatsql = "SELECT * FROM `sight` where ";
    //搜尋來源設定
    if($_GET['source']=="FaceBook")
    {$repeatsql .=" source=1";}
    else
    {$repeatsql .=" source=0";}
$repeatsql .=" and `view_name` in (SELECT `view_name` FROM `sight` ";
    //搜尋來源設定
    if($_GET['source']=="FaceBook")
    {$repeatsql .=" where source=1";}
    else
    {$repeatsql .=" where source=0";}
$repeatsql .=" group by `view_name` HAVING count(`view_name`)>1)";
$repeatquery = mysqli_query($con, $repeatsql);
$repeattotal_records = mysqli_num_rows($repeatquery);
if ($repeattotal_records > 0) {
    $repeatmessage = "<b style='color:red;'>注意:目前有" . $repeattotal_records . "個景點重複，部分條目可能無法顯示，請點選「<a href='?repeat=true";
    if($_GET['source']=="FaceBook")
    {$repeatmessage .=  "&source=FaceBook'>重複景點</a>」進行更改</b>";}
    else
    {{$repeatmessage .=  "'>重複景點</a>」進行更改</b>";}}
}
//回復FB標題
if($_GET['source']=="FaceBook")
{$facebookname="FB";
$facebooklink="&source=FaceBook";}
//刪除景點
$delsql = "DELETE FROM`sight` WHERE `view_id` = " . $_GET['delete'];
if (isset($_GET['delete'])) {
    if (mysqli_query($con, $delsql))
        if (header("Location:managesight.php")) {
            echo "<script> alert('刪除成功'); </script>";
        } else {
            echo "<script> alert('刪除失敗'); </script>";
        }
}
$confirmsql = "UPDATE `sight` SET `status` = '1' WHERE `view_id` = " . $_GET['confirm'];
if (isset($_GET['confirm'])) {
    if (mysqli_query($con, $confirmsql))
        header("Location:managesight.php?mode=1.$facebooklink"); 
}
//頁面模式選擇
if (!empty($_GET["mode"])) {
    $echomode = "mode=1".$facebooklink."&page=";
} {
    if (!empty($_GET["search"])) {
        $echomode = "search=" . $_GET["search"] .$facebooklink. "&page=";
    } {
        if (!empty($_GET["repeat"])) {
            $echomode = "repeat=true".$facebooklink."&page=";
        } else {
            $echomode = $facebooklink."page=";
        }
    }
}
?>


<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理景點 | 管理後台</title>
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
                        <li class="nav-link p-0"> <a class="nav-link" href="index.php"><img src="../image/home.png" alt="目錄" height="25" width="25"></a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="../index.php"><img src="../image/return.png" alt="返回使用者介面" height="25" width="25"></a> </li>
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
                        <h4 class="text-center card-title"><b><?php if (isset($_GET['search'])) {
                                                                    echo $facebookname."關鍵字:" . $_GET['search'];
                                                                } else if ($_GET['mode'] == 1) {if($_GET['source']=="FaceBook") echo "FB景點暫存區"; else echo "IG景點暫存區";}
                                                                else if ($_GET['repeat'] == true) {
                                                                    echo $facebookname."重複名稱景點";
                                                                } else {
                                                                    echo $facebookname."景點管理";
                                                                } ?></b></h4>
                        <table class="table">
                            <tr>
                                <td><input style="white-space:nowrap" class="btn btn-secondary btn-block btn-sm" type="button" value="新增景點" onclick="location.href='addsight.php'" /></td>
                                <?php if ($_GET['mode'] == 1) { ?> <td><input style="white-space:nowrap" class="btn btn-info btn-block btn-sm" type="button" value="切換景點管理" onclick="location.href='managesight.php<?php echo "?" .$facebooklink; ?>'" /></td> <?php } else { ?>
                                    <td>
                                        <nobr><input style="white-space:nowrap" class="btn btn-info btn-block btn-sm" type="button" value="切換暫存區" onclick="location.href='managesight.php?mode=1<?php echo $facebooklink; ?>'" />
                                    </td>
                                    </nobr><?php } ?>
                                <?php if ($_GET['repeat'] == true) { ?> <td><input style="white-space:nowrap" class="btn btn-info btn-block btn-sm" type="button" value="切換景點管理" onclick="location.href='managesight.php<?php echo "?" .$facebooklink; ?>'" /></td> <?php } else { ?>
                                    <td><input style="white-space:nowrap" class="btn btn-info btn-block btn-sm" type="button" value="尋找重複名稱" onclick="location.href='managesight.php?repeat=true<?php echo "?" .$facebooklink; ?>'" /></td> <?php } ?>
                                    <?php if($facebookswitch==1){if ($_GET['source'] == "FaceBook") { ?><td><input style="white-space:nowrap" class="btn btn-primary btn-block btn-sm" type="button" value="切換IG資料庫" onclick="location.href='?source=Instagram'" /></td> <?php } else { ?>
                                    <td><input style="white-space:nowrap" class="btn btn-primary btn-block btn-sm" type="button" value="切換FB資料庫" onclick="location.href='?source=FaceBook'" /></td> <?php } }?>
                                <td>
                                    <form class="" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form">
                                <td Width="300"><input type="text" name="search" class="form-control" required /></td>
                                <td><button style="white-space:nowrap" class="btn btn-primary btn-block btn-sm" type="submit">搜尋景點</button></td>
                                </form>
                                </td>
                            </tr>
                        </table>
                        <span class="text-danger"><?php if (!isset($_GET['repeat'])) {
                                                        if (isset($repeatmessage)) {
                                                            echo $repeatmessage;
                                                        }
                                                    } ?></span>
                        <table class="table">
                            <thead>
                                <tr align="center" valign="center">
                                    <td>
                                        <nobr>項次</nobr>
                                    </td>
                                    <td>
                                        <nobr>景點編號</nobr>
                                    </td>
                                    <td>
                                        <nobr>景點名稱</nobr>
                                    </td>
                                    <td>
                                        <nobr>貼文代碼</nobr>
                                    </td>
                                    <td>
                                        <nobr>發文時間</nobr>
                                    </td>
                                    <td>
                                        <nobr>標籤地點</nobr>
                                    </td>
                                    <?php if ($_GET['mode'] == 1 || $_GET['repeat'] == true) {
                                        $on = 1; ?> <td>
                                            <nobr>發佈</nobr>
                                        </td> <?php } ?>
                                    <td>
                                        <nobr>修改</nobr>
                                    </td>
                                    <td>
                                        <nobr>刪除</nobr>
                                    </td>
                                    <?php if ($_GET['repeat'] == true) { ?><td>
                                            <nobr>備註</nobr>
                                        </td> <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['page'])) {
                                    $s = ($_GET['page'] - 1) * $records_per_page + 1;
                                } else {
                                    $s = 1;
                                }
                                $j = 1;
                                while ($row = mysqli_fetch_row($query) and $j <= $records_per_page) {
                                    $view_id      = $row[0];
                                    $view_name    = $row[1];
                                    $shortcode     = $row[2];
                                    $timestamp    = $row[3];
                                    $tag_area     = $row[4];
                                    $status     = $row[5];
                                    $a = "<b style='color:red;'>" . $_GET['search'] . "</b>";
                                    //提示重複景點無效無效
                                    if ($_GET['repeat'] == true) {
                                        $checksql = "SELECT `view_id` FROM `sight` where view_name='" . $view_name . "' group by `view_name` having count(1)";
                                        $checkresult = mysqli_query($con, $checksql);
                                        $checkrow = mysqli_fetch_assoc($checkresult);
                                        $checkid = $checkrow['view_id'];
                                    }
                                ?>
                                    <tr align="center" valign="center">
                                        <th><?php echo $s; ?></th>
                                        <th><?php echo $view_id; ?></th>
                                        <th><?php echo "<a href=https://www.instagram.com/p/" . $shortcode . ">" . str_ireplace($_GET['search'], $a, $view_name)  . "</a>"; ?></th>
                                        <th><?php echo $shortcode; ?></th>
                                        <th><?php if (isset($timestamp)) {
                                                echo  date("Y-m-d H:i:s", $timestamp);
                                            } else {
                                                echo "";
                                            } ?></th>
                                        <th><?php echo "<a href=?tag=" . $tag_area . ">" . $tag_area . "</a>";  ?></th>
                                        <?php if (isset($on)) { ?>
                                            <th>
                                                <?php if ($status == null) echo "<a href=?mode=1".$facebooklink."&confirm=" . intval($view_id) . ">✔️</a>";  ?>
                                            </th>
                                        <?php } ?>
                                        <th><?php echo "<a href=modifysights.php?view_id=" . intval($view_id) . "> 📝</a>" ?></th>
                                        <th><?php echo "<a href=?delete=" . intval($view_id) . "> ❌</a>";  ?></th>
                                        <?php if ($_GET['repeat'] == true) { ?>
                                            <td>
                                                <?php if ($view_id != $checkid) {
                                                    echo "<b style='color:red;'><nobr>景點重複<br>無法顯示</nobr></b>";
                                                } ?>
                                            </td>
                                        <?php } ?><th>
                                        <?php $j++;
                                        $s++;
                                    } ?>
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
                                        echo "<li class='page-item'><a class='page-link' href='managesight.php?$echomode" . ($page - 1) . "'>上一頁</a> </li> ";
                                        for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                            if ($i == $page)
                                                echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                            else
                                                if ($i <= 0) {
                                            } else
                                                echo "<li class='page-item'><a class='page-link' href='managesight.php?$echomode$i'>$i</a></li> ";
                                        }
                                    }
                                    for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                        if ($i == $page)
                                            echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                        else
                                            echo "<li class='page-item'><a class='page-link' href='managesight.php?$echomode$i'>$i</a></li> ";
                                    }
                                    if ($page < $total_pages) {
                                        echo "<li class='page-item'><a class='page-link' href='managesight.php?$echomode" . ($page + 1) . "'>下一頁</a></li>";
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