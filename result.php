<?php
session_start();
include 'dbconnect.php';
include 'function.php';
//定義時間,使用者變數
date_default_timezone_set("Asia/Taipei");
mysqli_query($con, "SET NAMES UTF8");
$user_id = $_SESSION['user_id'];
//收藏景點功能
if (isset($_GET['addfavorite'])) {
    if (isset($_GET["page"])) {
        $pageget = "?page=" . $_GET["page"];
    } else {
        $pageget = "";
    }
    $view_id = $_GET['addfavorite'];
    $check = "SELECT `view_id` FROM `favorites` WHERE `user_id` ='" . $user_id . "' and view_id = $view_id";
    $chresult = mysqli_query($con, $check);
    $row2 = mysqli_fetch_assoc($chresult);
    $databaseid = $row2["view_id"];
    if ($databaseid == $view_id) {
        $error = true;
        $id_error = "這個景點已經在收藏名單了!";
    }
    if (!$error) {
        $addsql = "INSERT INTO `favorites`(`user_id`, `view_id`) VALUES
    ('" . $user_id . "', '" . $view_id . "')";
        mysqli_query($con, $addsql);
        header("Location: result.php" . $pageget . "");
    }
}
//接收搜尋頁面的資料(SQL語法變數設定)
if (!empty($_GET["tagname"])) {
    $name = $_GET["tagname"];
    $tagname = $_GET["tagname"];
    switch ($_GET["tagname"]) {
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
} else if (!empty($_GET["keyword"])) {
    $name = $_GET["keyword"];
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
//鏈結變數設定
if (isset($_GET["source"])) {
    $sourcelink = "&source=" . $_GET["source"];
}
if (isset($_GET["tagname"])) {
    $link = "tagname=" . $_GET["tagname"] . $sourcelink . "&page=";
} else {
    if (isset($_GET["keyword"])) {
        $link = "keyword=" . $_GET["keyword"] . $sourcelink . "&page=";
    } else {
        $link = "page=" . $sourcelink;
    }
}
//運用條件搜尋相關資料
if (!empty($_GET["tagname"])) {
    $sql = "SELECT `view_id`,`view_name`, `shortcode`, `timestamp`, `tag_area`,`source`";
    $sql .= " FROM sight";
    $sql .= " WHERE tag_area='" . $_GET["tagname"] . "' and ";
    if ($facebookswitch == 1) {
        if ($sourcemode == "FaceBook") {
            $sql .= " source=1 and ";
        }
        if ($sourcemode == "instagram") {
            $sql .= " source=0 and ";
        }
        if ($sourcemode == "All") {
            $sql .= "";
        }
    } else {
        $sql .= " source=0 and";
    }
    $sql .= " status=1";
    $sql .= " group by `view_name` having count(1)";
    $result = mysqli_query($con, $sql);
} else if (!empty($_GET["keyword"])) {
    $sql = "SELECT `view_id`,`view_name`, `shortcode`, `timestamp`, `tag_area`,`source`";
    $sql .= " FROM sight";
    $sql .= " WHERE view_name like '%$name%' and ";
    if ($facebookswitch == 1) {
        if ($sourcemode == "FaceBook") {
            $sql .= " source=1 and ";
        }
        if ($sourcemode == "instagram") {
            $sql .= " source=0 and ";
        }
        if ($sourcemode == "All") {
            $sql .= "";
        }
    } else {
        $sql .= " source=0 and";
    }
    $sql .= " status=1";
    $sql .= " group by `view_name` having count(1)";
    $result = mysqli_query($con, $sql);
} else {
    $sql = "SELECT `view_id`,`view_name`, `shortcode`, `timestamp`, `tag_area`,`source`";
    $sql .= " FROM sight";
    $sql .= " WHERE status=1";
    if ($facebookswitch == 1) {
        if ($sourcemode == "FaceBook") {
            $sql .= " and source=1  ";
        }
        if ($sourcemode == "instagram") {
            $sql .= " and source=0  ";
        }
        if ($sourcemode == "All") {
            $sql .= "";
        }
    } else {
        $sql .= " and source=0";
    }
    $sql .= " group by `view_name` having count(1)";
    $result = mysqli_query($con, $sql);
}
//取得要顯示第幾頁的記錄
if (isset($_GET["page"]))
    $page = $_GET["page"];
else
    $page = 1;
//取得記錄數
$total_records = mysqli_num_rows($result);
//指定每頁顯示幾筆記錄
if (isset($_GET["address"])) {
    $records_per_page = $total_records;
} else {
    $records_per_page = 10;
}
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
    <title><?php if (isset($name)) {
                if (!empty($_GET["tagname"])) {
                    echo "TAG:" . $tagname . $sourcename;
                } else if (!empty($_GET["keyword"])) {
                    echo "關鍵字:" . $name . $sourcename;
                }
            } else
            if (isset($_GET["address"])) {
                echo "地址模式";
            } else echo "景點選擇" . $sourcename; ?>｜TravelFun</title>
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
            <h1><?php
                if (isset($name)) {
                    if (!empty($_GET["tagname"])) {
                        echo "TAG:" . $tagname . $sourcename;
                    } else if (!empty($_GET["keyword"])) {
                        echo "關鍵字:" . $name . $sourcename;
                    }
                } else {
                    if (isset($_GET["address"])) {
                        echo "地址模式";
                    } else echo "景點總覽" . $sourcename;
                } ?></h1>
            <?php if (isset($_GET["address"])) {
            } else { ?>
                <label for="name"> 景點總數：<?php echo $total_records . "(第" . $page . "頁/共" . $total_pages . "頁)"; ?></label>
            <?php } ?>
            <p>
            <div id="left">
                <span class="text-danger"><?php if (isset($id_error)) echo $id_error; ?></span>
                <?php //顯示記錄
                $j = 1;
                while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                    //確認是否有輸入過地址
                    $checkaddresssql = "SELECT * FROM `note` where view_id=" . $row["view_id"];
                    $checkaddressresult = mysqli_query($con, $checkaddresssql);
                    $checkaddressrow = mysqli_fetch_assoc($checkaddressresult);
                    $address = $checkaddressrow['address'];
                    if (isset($_GET["address"])) {
                        if (empty($checkaddressrow)) {
                            $open = true;
                        }
                    }

                    //確認是否為收藏景點
                    $checksql = "SELECT * FROM `favorites` where user_id='" . $user_id . "' and view_id=" . $row["view_id"];
                    $checkresult = mysqli_query($con, $checksql);
                    $checkrow = mysqli_fetch_assoc($checkresult);
                    if (!empty($_GET["keyword"])) {
                        $a = "<b style='color:red;'>" . $name . "</b>";
                    } else {
                        $a = $name;
                    }
                    echo "<div >";
                    echo "<h4><a href='";
                    //景點鏈結顯示
                    if ($row["source"] == 0) {
                        echo "https://www.instagram.com/p/";
                    }
                    if ($row["source"] == 1) {
                        if (strpos($row["shortcode"], "http") !== false) {
                            echo ("");
                        } else {
                            echo $facebooklink;
                        }
                    }
                    echo $row["shortcode"] . "' style='text-decoration:none; color:black;'>" . str_ireplace($name, $a, $row["view_name"]) . "</a>";
                    if (isset($_SESSION['user_id']))
                        if (!empty($_GET["tagname"])) {
                            $ad = "tagname=$name&";
                        } else if (!empty($_GET["keyword"])) {
                            $ad = "keyword=$name&";
                        }
                    if ($page != 1) {
                        $ad1 = "page=$page&";
                    }
                    if (isset($_SESSION['user_id'])) {
                        if (isset($_GET["page"])) {
                            $pageurl = "&page=" . $page;
                        } else {
                            $pageurl = "";
                        }
                        if (empty($checkrow)) {
                            echo "<a href='?" . $ad1 . $ad . "addfavorite=" . $row["view_id"] . $pageurl . "'><font size='3'>🧡</font></a>";
                        }
                    }
                    if ($googlemapswitch == 1) {
                        if (empty($checkaddressrow)) {
                            echo "<a href='https://www.google.com.tw/maps/place/" . $row["view_name"] . "'><img src='image/map.png' width='20' height='20' border='0' title='" . $row["view_name"] . "'></a>";
                        } else {
                            echo "<a href='https://www.google.com.tw/maps/place/" . $address . "'><img src='image/map.png' width='20' height='20' border='0' title='" . $row["view_name"] . "'></a>";
                        }
                    }
                    if (isset($_SESSION['user_id']) && $addressmodifyswitch == 1) {
                        if (empty($checkaddressrow)) { ?>
                            <input style="white-space:nowrap" class="btn btn-primary btn-sm" type="button" value="新增地址" onclick="location.href='insertaddress.php?id=<?php echo $row["view_id"]; ?>'" /></h4>
                        <?php }
                        if (!empty($checkaddressrow)) { ?>
                            <input style="white-space:nowrap" class="btn btn-warning btn-sm" type="button" value="修改地址" onclick="location.href='insertaddress.php?id=<?php echo $row["view_id"]; ?>'" /></h4>
                <?php }
                    }
                    echo "<p>   <font color='#A6A6A6' size='1'>";
                    if (isset($row["timestamp"])) {
                        echo  "發佈時間:" . date("Y-m-d H:i:s", $row["timestamp"]) . " &emsp;";
                    } else {
                        echo " &emsp; ";
                    }
                    echo "TAG:<a href='";
                    if ($row["source"] == 0) {
                        echo "https://www.instagram.com/explore/tags/";
                    }
                    if ($row["source"] == 1) {
                        echo "https://www.facebook.com/hashtag/";
                    }
                    echo  $row["tag_area"] . "' style='text-decoration:none; color:#A6A6A6;'>" . $tagname . "&emsp; </a> ";
                    if ($facebookswitch == 1) {
                        echo "來源:";
                        if ($row["source"] == 0) {
                            echo "Instagram";
                        }
                        if ($row["source"] == 1) {
                            echo "FaceBook";
                        }
                    }
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
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='result.php?$link" . ($page - 1) . "'>上一頁</a> </li> ";
                                for ($i = ($page - 2); $i <= min($total_pages, $page - 1); $i++) {
                                    if ($i == $page)
                                        echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                    else
                                                if ($i <= 0) {
                                    } else
                                        echo "<li class='page-item'><a class='page-link' href='result.php?$link$i'>$i</a></li> ";
                                }
                            }
                            for ($i = $page; $i <= min($total_pages, $page + 9); $i++) {
                                if ($i == $page)
                                    echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
                                else
                                    echo "<li class='page-item'><a class='page-link' href='result.php?$link$i'>$i</a></li> ";
                            }
                            if ($page < $total_pages) {
                                echo "<li class='page-item'><a class='page-link' href='result.php?$link" . ($page + 1) . "'>下一頁</a></li>";
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