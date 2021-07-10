<?php
session_start();
include 'dbconnect.php';
include 'function.php';
date_default_timezone_set("Asia/Taipei");
mysqli_query($con1, "SET NAMES UTF8");
$countswitch = 1;
//resultlink
if ($facebookswitch == 1) {
    if ($_GET["source"] == "instagram") {
        $link1 = "&source=instagram";
    }
    if ($_GET["source"] == "FaceBook") {
        $link1 = "&source=FaceBook";
    }
    if ($_GET["source"] == "All") {
        $link1 = "&source=All";
    }
} else {
}
//導覽列變數
if ($facebookswitch == 1) {
    if ($_GET["source"] == "instagram") {
        $link = "?source=instagram&page=";
    }
    if ($_GET["source"] == "FaceBook") {
        $link = "?source=FaceBook&page=";
    }
    if ($_GET["source"] == "All") {
        $link = "?source=All&page=";
    }
} else {
    $link = "?page=";
}
//來源變數設定
$sourcemode = $_GET["source"];
//來源名稱標示
if ($facebookswitch == 1) {
    if ($sourcemode == "FaceBook") {
        $sourcename = "(FaceBook)";
    }
    if ($sourcemode == "instagram") {
        $sourcename = "(instagram)";
    }
    if ($sourcemode == "All") {
        $sourcename = "(全部)";
    }
}
//顯示分類
$sql = "SELECT `tag_area` ,count(tag_area),`view_name` FROM sight";
$sql .= " WHERE tag_area!='' ";
if ($facebookswitch == 1) {
    if ($_GET["source"] == "instagram") {
        $sql .= " and source=0 ";
    }
    if ($_GET["source"] == "FaceBook") {
        $sql .= " and source=1 ";
    }
    if ($_GET["source"] == "All") {
    }
} else {
    $sql .= " and source=0 ";
}
$sql .= " GROUP BY tag_area";
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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>分類總覽｜TravelFun</title>
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
            <h1 <?php if ($countswitch == 0) { ?> align="center" <?php } ?>>分類總覽 <?php echo $sourcename; ?></h1>
            <?php if ($countswitch == 1 && !empty($_GET["source"])) { ?><label for="name"> 分類總數：<?php echo $total_records;   ?></label> <?php } ?>
            <p>
            <div id="left" <?php if ($countswitch == 0) { ?> align="center" <?php } ?>>
                <?php //顯示記錄
                if ($facebookswitch == 1 && empty($_GET["source"])) {
                    if (empty($_GET["source"])) { ?>
                        <div>
                            <h4><a href='tag.php?source=instagram' style='text-decoration:none; color:black;'>Instagram</a></h4>
                        </div>
                        <hr>
                        <div>
                            <h4><a href='tag.php?source=FaceBook' style='text-decoration:none; color:black;'>FaceBook</a></h4>
                        </div>
                        <hr>
                        <div>
                            <h4><a href='tag.php?source=All' style='text-decoration:none; color:black;'>全部</a></h4>
                        </div>
                        <hr>
                <?php }
                } else {
                    $j = 1;
                    while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                        $countsql = "SELECT * FROM sight ";
                        $countsql .= " WHERE ";
                        $countsql .= "  status=1 and";
                        $countsql .= " tag_area='" . $row["tag_area"] . "'";
                        
                        if ($facebookswitch == 1) {
                            if ($_GET["source"] == "instagram") {
                                $countsql .= " and source=0 ";
                            }
                            if ($_GET["source"] == "FaceBook") {
                                $countsql .= " and source=1 ";
                            }
                            if ($_GET["source"] == "All") {
                            }
                        } else {
                            $countsql .= " and source=0 ";
                        }
                        $countsql .= " group by `view_name` having count(1)";
                        $countresult = mysqli_query($con, $countsql);
                        $countrow = mysqli_fetch_assoc($countresult);
                        $counttotal = mysqli_num_rows($countresult);
                        switch ($row["tag_area"]) {
                            case "keelung":
                            case "Keelung": //1
                                $tagname = "基隆";
                                break;
                            case "taipei":
                            case "Taipei": //2
                                $tagname = "台北";
                                break;
                            case "Taoyuan":
                            case "taoyuan": //3
                                $tagname = "桃園";
                                break;
                            case "Yilan":
                            case "yilan": //4
                                $tagname = "宜蘭";
                                break;
                            case "Hsinchu":
                            case "hsinchu": //5
                                $tagname = "新竹";
                                break;
                            case "Miaoli":
                            case "miaoli": //6
                                $tagname = "苗栗";
                                break;
                            case "Taichung":
                            case "taichung": //7
                                $tagname = "台中";
                                break;
                            case "Changhua":
                            case "changhua": //8
                                $tagname = "彰化";
                                break;
                            case "Yunlin":
                            case "yunlin": //9
                                $tagname = "雲林";
                                break;
                            case "Nantou":
                            case "nantou": //10
                                $tagname = "南投";
                                break;
                            case "Chiayi":
                            case "chiayi": //11
                                $tagname = "嘉義";
                                break;
                            case "Tainan":
                            case "tainan": //12
                                $tagname = "台南";
                                break;
                            case "Kaohsiung":
                            case "kaohsiung": //13
                                $tagname = "高雄";
                                break;
                            case "Pingtung":
                            case "pingtung": //14
                                $tagname = "屏東";
                                break;
                            case "Hualien":
                            case "hualien": //15
                                $tagname = "花蓮";
                                break;
                            case "Taitung":
                            case "taitung": //16
                                $tagname = "台東";
                                break;
                            case "Penghu":
                            case "penghu": //17
                                $tagname = "澎湖";
                                break;
                            case "Kinmen":
                            case "kinmen": //18
                                $tagname = "金門";
                                break;
                            case "mazu":
                            case "Mazu": //19
                                $tagname = "馬祖";
                                break;
                            default:
                                $tagname = $row["tag_area"];
                                break;
                        }

                        echo "<div>";
                        echo "<h4><a href='result.php?tagname=" . $row["tag_area"] . "$link1' style='text-decoration:none; color:black;'>" . $tagname . "</a></h4>";
                        if ($countswitch == 1) {
                            echo "景點總數:" . $counttotal . "個 </a> ";
                        }
                        echo  "</p> </font>";
                        echo "</div>";
                        echo "<hr>";
                        $j++;
                    }
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
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='tag.php$link" . ($page - 1) . "'>上一頁</a> </li> ";
                                for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                                if ($i <= 0) {
                                    } else
                                        echo "<li class='page-item'><a class='page-link' href='tag.php$link$i'>$i</a></li> ";
                                }
                            }
                            for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                if ($i == $page)
                                    echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                else
                                    echo "<li class='page-item'><a class='page-link' href='tag.php$link$i'>$i</a></li> ";
                            }
                            if ($page < $total_pages) {
                                echo "<li class='page-item'><a class='page-link' href='tag.php$link" . ($page + 1) . "'>下一頁</a></li>";
                                echo "</p>";
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