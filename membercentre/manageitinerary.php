<?php
session_start();
include_once '../dbconnect.php';
date_default_timezone_set("Asia/Taipei");
mysqli_query($con, "SET NAMES UTF8");
$user_id = $_SESSION['user_id'];
if (isset($_SESSION['user_id'])) {
} else {
    header("Location: ../login.php");
}
//刪除行程
if (isset($_GET['delete'])) {
    $del = strip_tags($_GET['delete']);
    $delsql = "DELETE FROM`sequence` WHERE `itinerary_id` = " . $del;
    $delsql1 = "DELETE FROM`share` WHERE `itinerary_id` = " . $del;
    $delsql2 = "DELETE FROM`itinerary` WHERE `itinerary_id` = " . $del;
    if (mysqli_query($con, $delsql)) {
        if (mysqli_query($con, $delsql1)) {
            if (mysqli_query($con, $delsql2)) {
                header("Location: modifyitinerary.php?id=" . $id . "");
            } else {
                echo "<script> alert('刪除失敗!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
            }
        } else {
            "<script> alert('刪除失敗!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
        }
    } else { {
            "<script> alert('發生異常!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
        }
    }
}
//顯示景點
$sql = "SELECT `itinerary_id`, `itinerary_name`, `public_status`, `itinerary_date`, `itinerary_days`";
$sql .= "FROM `itinerary` WHERE user_id = '$user_id'";
$sql .= " ORDER BY `itinerary`.`itinerary_date` ASC";
$result = mysqli_query($con, $sql);
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
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理行程 | TravelFun</title>
    <link rel="icon" href="../image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mdb.min.css">
    <link rel='stylesheet' href='https://rawgit.com/adrotec/knockout-file-bindings/master/knockout-file-bindings.css'>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="../css/result.css">
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
        <div class="container2">
            <h1>管理行程</h1>
            <label for="name"> 行程總數：<?php echo $total_records; ?></label>
            <table>
                <td><input class="btn btn-secondary btn-block btn-sm" type="button" value="新增行程" onclick="location.href='additinerary.php'" /></td>
                <td><input class="btn btn-info btn-block btn-sm" type="button" value="管理收藏" onclick="location.href='manageFavorites.php'" /></td>
                <td><input class="btn btn-info btn-block btn-sm" type="button" value="共筆行程" onclick="location.href='shareitinerary.php'" /></td>
            </table>
            <p>
                <hr>
            <div id="left">
                <?php //顯示記錄
                $j = 1;
                echo $sql1;
                while ($row = mysqli_fetch_assoc($result)  and $j <= $records_per_page) {;
                    $itinerary_id = $row["itinerary_id"];
                    $itinerary_date = $row["itinerary_date"];
                    $itinerary_days = $row["itinerary_days"];
                    $totalday = $itinerary_days - 1;
                    echo "<div >";
                    echo "<h4><a href='modifyitinerary.php?id=" . $itinerary_id . "' style='text-decoration:none; color:black;'>" . $row["itinerary_name"] . "</a>";
                    echo "<a href=?delete=" . intval($itinerary_id) . "> <font size='3'>❌</a></font></h4>";
                    echo "<p>   <font color='#A6A6A6' size='1'>";
                    echo "出遊日期:" . date("Y年m月d日", strtotime($itinerary_date)) . "~" . date("Y年m月d日", strtotime($itinerary_date . "+ " . $totalday . " day")) . "(共" . $itinerary_days . "天)</a> ";;
                    echo  "</a></p> </font>";
                    echo "</div>";
                    echo "<hr>";
                    $j++;
                }
                ?>
            </div>
            <td colspan="2" align="center" valign="top">
                <ul class="pagination">
                    <li class="page-item">
                        <?php
                        //產生導覽列
                        echo "<p align='center'>";
                        if ($total_pages > 1)
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='manageitinerary.php?page=" . ($page - 1) . "'>上一頁</a> </li> ";
                                for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                                if ($i <= 0) {
                                    } else
                                        echo "<li class='page-item'><a class='page-link' href='manageitinerary.php?page=$i'>$i</a></li> ";
                                }
                            }
                        for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                            if ($i == $page)
                                echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                            else
                                echo "<li class='page-item'><a class='page-link' href='manageitinerary.php?page=$i'>$i</a></li> ";
                        }
                        if ($page < $total_pages) {
                            echo "<li class='page-item'><a class='page-link' href='manageitinerary.php?page=" . ($page + 1) . "'>下一頁</a></li>";
                            echo "</p>";
                        }

                        ?>

                    </li>
                </ul>
            </td>
        </div>
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