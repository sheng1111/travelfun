<?php
session_start();
include_once '../dbconnect.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");
//驗證登入狀態
if (isset($_SESSION['user_id'])) { {
    }
} else {
    header("Location: ../login.php");
}
if (isset($_GET['share'])) {
    $share = strip_tags($_GET['share']);
}
if (isset($_POST['share'])) {
    $share = strip_tags($_POST['share']);
}
if (isset($_GET['id'])) {
    $id = strip_tags(intval($_GET['id']));
}
if (isset($_POST['id'])) {
    $id = strip_tags(intval($_POST['id']));
}
//共享者可修改內容
if (isset($_GET['share']) || isset($_POST['share'])) {
    $check = "SELECT itinerary.`user_id` FROM `itinerary`,`share` WHERE `share`.`itinerary_id`= $id and`share`.`user_id` ='" . $_SESSION['user_id'] . "' and `itinerary`.`itinerary_id`=`share`.`itinerary_id`";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row)) {
    } else {
        header("Location: ../index.php");
    }
} else {
    $check = "SELECT `user_id` FROM `itinerary` WHERE `itinerary_id`= $id and `user_id` ='" . $_SESSION['user_id'] . "'";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    if (!empty($row)) {
    } else {
        header("Location: ../index.php");
    }
}
//修改行程
if (isset($_POST['submit'])) {
    $id = strip_tags($_POST['id']);
    $itinerary_name = strip_tags($_POST['itinerary_name']);
    $public_status = strip_tags($_POST['public_status']);
    $itinerary_date = strip_tags($_POST['itinerary_date']);
    $itinerary_days = strip_tags($_POST['itinerary_days']);
    $sqlUpdate = "UPDATE itinerary SET
    itinerary_name='" . $itinerary_name . "',
    public_status='" . $public_status . "',
    itinerary_date='" . $itinerary_date . "',
    itinerary_days='" . $itinerary_days . "'
    WHERE `itinerary_id` = '" . $id . "'";
    $row1 = mysqli_query($con, $sqlUpdate);
    if (!empty($row1)) {
        echo "<script> alert('修改成功!');parent.location.href='edititinerary.php?id=" . $id;
        if ($_POST['share'] == 1) {
            echo "&share=1";
        }
        echo "'; </script>";
    } else {
        echo "<script> alert('修改失敗!');parent.location.href='edititinerary.php?id=" . $id;
        if ($_POST['share'] == 1) {
            echo "&share=1";
        }
        echo "'; </script>";
    }
}
//新增共筆作者
if (isset($_GET['submit_addfriend'])) {
    $id = strip_tags($_GET['id']);
    $friend_id = strip_tags($_GET['addid']);
    $check = "SELECT `user_id` FROM `share` WHERE `itinerary_id`='" . $id . "' and `user_id` ='" . $friend_id . "'";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    $databaseid = $row["user_id"];
    if ($databaseid == $friend_id) { {
            echo "<script> alert('這個共筆作者已經新增過了!');parent.location.href='edititinerary.php?id=" . $id;
            if (isset($_GET['share'])) {
                echo "&share=1";
            }
            echo "'; </script>";
        }
    } else {
        $addsql = "INSERT INTO `share`(`itinerary_id`, `user_id`) VALUES ('" . $id . "', '" . $friend_id . "')";
        if (mysqli_query($con, $addsql)) {
            echo "<script> alert('新增共筆作者成功!');parent.location.href='edititinerary.php?id=" . $id;
            if (isset($_GET['share'])) {
                echo "&share=1";
            }
            echo "'; </script>";
        } else {
            echo "<script> alert('新增共筆作者失敗!');parent.location.href='edititinerary.php?id=" . $id;
            if (isset($_GET['share'])) {
                echo "&share=1";
            } {
                echo "'; </script>";
            }
            echo "'; </script>";
        }
    }
}
//刪除共筆作者
if (isset($_GET['delid'])) {
    $share_id = strip_tags($_GET['delid']);
    $delsql = "DELETE FROM`share` WHERE `share_id` = " . $share_id;
    if (mysqli_query($con, $delsql)) {
        echo "<script> alert('刪除共筆作者成功!');parent.location.href='edititinerary.php?id=" . $id;
        if (isset($_GET['share'])) {
            echo "&share=1";
        }
        echo "'; </script>";
    } else {
        echo "<script> alert('刪除共筆作者失敗!');parent.location.href='edititinerary.php?id=" . $id;
        if (isset($_GET['share'])) {
            echo "&share=1";
        }
        echo "'; </script>";
    }
}
//讀取行程名稱
$result = mysqli_query($con, "SELECT `itinerary_name`,`public_status`,`itinerary_date`,`itinerary_days`  FROM itinerary WHERE itinerary_id=" . $id);
$row = mysqli_fetch_assoc($result);
$itinerary_name = $row["itinerary_name"];
$public_status = $row["public_status"];
$itinerary_days = $row["itinerary_days"];
$itinerary_date = $row["itinerary_date"];

//讀取共筆作者
$sql = "SELECT share.share_id,share.user_id,user.user_name ";
$sql .= " FROM share , user";
$sql .= " WHERE itinerary_id= '" . $id . "' and";
$sql .= " share.user_id = user.user_id";
$result2 = mysqli_query($con, $sql);
$total_records = mysqli_num_rows($result2);
//讀取好友
$sql2 = "SELECT friend.others,user.user_name ";
$sql2 .= " FROM friend , user";
$sql2 .= " WHERE friend.oneself= '" . $_SESSION['user_id'] . "' and friend.status=1 and";
$sql2 .= " friend.others = user.user_id";
$result3 = mysqli_query($con, $sql2);
$total_records2 = mysqli_num_rows($result3);
//讀取好友(反向)
$sql3 = "SELECT friend.oneself,user.user_name ";
$sql3 .= " FROM friend , user";
$sql3 .= " WHERE friend.others= '" . $_SESSION['user_id'] . "' and friend.status=1 and";
$sql3 .= " friend.oneself = user.user_id";
$result4 = mysqli_query($con, $sql3);
$total_records2 = mysqli_num_rows($result4);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>編輯行程-<?php echo $itinerary_name;  ?> | TravelFun</title>
    <link rel="icon" href="../image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mdb.min.css">
    <link rel='stylesheet' href='https://rawgit.com/adrotec/knockout-file-bindings/master/knockout-file-bindings.css'>>
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
            <form class="p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                <h4 class="text-center "><b>修改行程資訊(<?php echo $itinerary_name;  ?>)</b></h4>
                <hr class="">
                <?php if (isset($_GET['share'])) { ?>
                    <input type="hidden" name="share" value=1>
                <?php } else {
                } ?>
                <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                <div class="form-group"><label for="name"> ☀行程名稱</label>
                    <input type="text" name="itinerary_name" value="<?PHP echo $itinerary_name; ?>" class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀起始日期</label>
                    <input type="date" name="itinerary_date" value="<?PHP echo $itinerary_date; ?>" class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀行程天數</label>
                    <input type="number" name="itinerary_days" min=1 max=999 value="<?PHP echo $itinerary_days; ?>" class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀公開狀態</label>
                    <select name="public_status">
                        <option value="" disabled="disabled">請選擇狀況</option>
                        <option value="1" <?php if (!(strcmp("1", $public_status))) {
                                                echo "selected=\"selected\"";
                                            } ?>>公開
                        <option value="2" <?php if (!(strcmp("2", $public_status))) {
                                                echo "selected=\"selected\"";
                                            } ?>>不公開
                    </select>
                    <center>
                        <button class="btn btn-info btn-primary " type="button" onclick="location.href='modifyitinerary.php?id=<?php echo $id;
                                                                                                                                if (isset($_GET['share'])) {
                                                                                                                                    echo "&share=1";
                                                                                                                                } ?>'">回上一頁</button>
                        <button class="btn btn-info btn-primary " type="submit" name="submit">修改行程資訊</button>
                    </center>
                    <br>
            </form>
            <h4 class="text-center card-title"><b>共筆作者</b></h4>
            <label for="name"> 共筆人數：<?php if (isset($total_records)) {
                                        echo $total_records . " 人";
                                    } else {
                                        echo "0 人";
                                    }   ?></label>
            <form class="" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form">
                <?php if (isset($_GET['share'])) { ?>
                    <input type="hidden" name="share" value=1>
                <?php } else {
                } ?>
                <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                <div class="form-group">
                    <select name="addid" style="font-size:18px;">
                        <option value="" selected=selected disabled="true" required class="form-control">請選擇好友</option>
                        <?php
                        while ($row3 = mysqli_fetch_assoc($result3)) {
                            echo "<option value='" . $row3["others"] . "'> " . $row3["user_name"];
                        }
                        while ($row4 = mysqli_fetch_assoc($result4)) {
                            echo "<option value='" . $row4["oneself"] . "'> " . $row4["user_name"];
                        }
                        ?>
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit" name="submit_addfriend">新增共筆作者</button>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <td>項次</td>
                        <td>姓名</td>
                        <td>刪除</td>
                    </tr>
                </thead>
                <tbody>
                    <?php //顯示記錄
                    $j = 1;
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        echo "<tr>";
                        echo "<th>" . $j . "</th>";
                        echo "<th>" . $row2["user_name"] . "</th>";
                        echo "<th><a href=?id=" . $id;
                        if (isset($_GET['share'])) {
                            echo "&share=1";
                        } else {
                        }
                        echo "&delid=" . intval($row2["share_id"]) . "> <font size='3'>❌</a></font></th>";
                        echo "</tr>";
                        $j++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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