<?php
//顯示所有公開行程的檢索頁面
session_start();
include 'dbconnect.php';

//定義時間,使用者變數
date_default_timezone_set("Asia/Taipei");
$user_id = $_SESSION['user_id'];
mysqli_query($con, "SET NAMES UTF8");
//接收搜尋頁面的資料
if (!empty($_GET["keyword"])) {
    $name = $_GET["keyword"];
}
if (!empty($_GET["id"])) {
    $id = strip_tags($_GET["id"]);
    $sql2 = "SELECT * FROM `user` WHERE user_id='" . $id . "'";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $user_name = $row2['user_name'];
}
//運用條件搜尋相關資料
if (!empty($_GET["id"])) {
    $sql = "SELECT `itinerary`.`itinerary_id`, `itinerary`.`itinerary_name`, `itinerary`.`public_status`, `itinerary`.`itinerary_date`, `itinerary_days`, `itinerary`.`user_id` ,`user`.`user_name` ";
    $sql .= " FROM `itinerary`,`user`";
    $sql .= " WHERE itinerary.user_id='" . $id . "' and ";
    $sql .= " `itinerary`.`user_id`= `user`.`user_id` and ";
    $sql .= " `public_status`=1";
    $result = mysqli_query($con, $sql);
} else if (!empty($_GET["keyword"])) {
    $sql = "SELECT `itinerary`.`itinerary_id`, `itinerary`.`itinerary_name`, `itinerary`.`public_status`, `itinerary`.`itinerary_date`, `itinerary_days`, `itinerary`.`user_id` ,`user`.`user_name` ";
    $sql .= " FROM `itinerary`,`user`";
    $sql .= " WHERE itinerary_name like '%$name%' and ";
    $sql .= " `itinerary`.`user_id`= `user`.`user_id` and ";
    $sql .= " `public_status`=1";
    $result = mysqli_query($con, $sql);
} else {
    $sql = "SELECT `itinerary`.`itinerary_id`, `itinerary`.`itinerary_name`, `itinerary`.`public_status`, `itinerary`.`itinerary_date`, `itinerary_days`, `itinerary`.`user_id` ,`user`.`user_name` ";
    $sql .= " FROM `itinerary`,`user`";
    $sql .= " WHERE `itinerary`.`user_id`= `user`.`user_id` and ";
    $sql .= " `public_status`=1";
    $result = mysqli_query($con, $sql);
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
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title><?php if (isset($_GET['id'])) {
                echo $user_name . "的公開行程";
            } else if (isset($name)) {
                echo $name;
            } else echo "行程總覽"; ?>｜TravelFun</title>
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
        <div class="container2">
            <h1><?php if (isset($_GET['id'])) {
                    echo $user_name . "的公開行程";
                } else if (isset($name)) {
                    if (!empty($_GET["keyword"])) {
                        echo "關鍵字:" . $name;
                    }
                } else echo "行程總覽"; ?></h1>
            <label for="name"> 行程總數:<?php echo $total_records . "個"; ?></label>
            <p>
            <div id="left">
                <span class="text-danger"><?php if (isset($id_error)) echo $id_error; ?></span>
                <?php //顯示記錄
                $j = 1;
                while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                    $a = "<b style='color:red;'>" . $name . "</b>";
                    $itinerary_date = $row["itinerary_date"];
                    $itinerary_days = $row["itinerary_days"];
                    $totalday = $itinerary_days - 1;
                    echo "<div >";
                    echo "<h4><a href='itinerary.php?id=" . intval($row["itinerary_id"]) . "' style='text-decoration:none; color:black;'>" . str_ireplace($name, $a, $row["itinerary_name"]) . "</a>";
                    echo "<p>   <font color='#A6A6A6' size='1'>";
                    echo  "出遊日期:" . date("Y年m月d日", strtotime($itinerary_date)) . "~" . date("Y年m月d日", strtotime($itinerary_date . "+ " . $totalday . " day")) . "(共" . $itinerary_days . "天) " . " &emsp;";
                    echo "發文者:<a href='about.php?id=" . $row["user_id"] . "' style='text-decoration:none; color:#A6A6A6;'>" . $row["user_name"] . "&emsp; </a> ";
                    echo  "</p> </font>";
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
                        if ($total_pages > 1) {
                            if (!empty($name)) {
                                if ($page > 1) {
                                    echo "<li class='page-item'><a class='page-link' href='itineraries.php?keyword=" . $name . "&page=" . ($page - 1) . "'>上一頁</a> </li> ";
                                    for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                        if ($i == $page)
                                            echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                        else
                                                    if ($i <= 0) {
                                        } else
                                            echo "<li class='page-item'><a class='page-link' href='itineraries.php?keyword=" . $name . "&page=$i'>$i</a></li> ";
                                    }
                                }
                                for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                        echo "<li class='page-item'><a class='page-link' href='itineraries.php?keyword=" . $name . "&page=$i'>$i</a></li> ";
                                }
                                if ($page < $total_pages) {
                                    echo "<li class='page-item'><a class='page-link' href='itineraries.php?keyword=" . $name . "&page=" . ($page + 1) . "'>下一頁</a></li>";
                                    echo "</p>";
                                }
                            } else {
                                if ($page > 1) {
                                    echo "<li class='page-item'><a class='page-link' href='itineraries.php?page=" . ($page - 1) . "'>上一頁</a> </li> ";
                                    for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                        if ($i == $page)
                                            echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                        else
                                                if ($i <= 0) {
                                        } else
                                            echo "<li class='page-item'><a class='page-link' href='itineraries.php?page=$i'>$i</a></li> ";
                                    }
                                }
                                for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                        echo "<li class='page-item'><a class='page-link' href='itineraries.php?page=$i'>$i</a></li> ";
                                }
                                if ($page < $total_pages) {
                                    echo "<li class='page-item'><a class='page-link' href='itineraries.php?page=" . ($page + 1) . "'>下一頁</a></li>";
                                    echo "</p>";
                                }
                            }
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

    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>