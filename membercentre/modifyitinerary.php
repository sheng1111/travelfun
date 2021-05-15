<?php
session_start();
include_once '../dbconnect.php';
date_default_timezone_set("Asia/Taipei");
mysqli_query($con, "SET NAMES UTF8");
//驗證登入狀態及有無景點ID
if (isset($_SESSION['user_id'])) {
} else {
    header("Location: ../login.php");
}

$id = strip_tags(intval($_GET['id']));
$_SESSION['day1'] = $_GET['day'];
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

//讀取行程名稱
$sql1 = "SELECT `itinerary_name`,`public_status`,`itinerary_date`,`itinerary_days`,`user_id`";
$sql1 .= " FROM itinerary";
$sql1 .= " WHERE itinerary_id=" . $id;
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($result1);
$itinerary_name = $row1["itinerary_name"];
$public_status = $row1["public_status"];
$itinerary_date = $row1["itinerary_date"];
$itinerary_days = $row1["itinerary_days"];
//設定day變數
$day = $_GET['day'];
if ($day <= 0 || $day == null) {
    $day = 1;
}
if ($day >= $itinerary_days) {
    $day = $itinerary_days;
}
//讀取行程內的景點順序
$sql   = "SELECT sequence.view_id , sight.view_name, sequence.opt_day, sequence.sequence,sight.shortcode,sight.source FROM `sequence`,sight WHERE `itinerary_id`=$id and sequence.view_id=sight.view_id ";
if ($_GET['seeall'] == false) {
    $sql  .= "and opt_day='" . $day . "'";
}
$sql  .= "ORDER BY `sequence`.`opt_day`,`sequence`.`sequence`  ASC";
$query = mysqli_query($con, $sql);
$total_records1 = mysqli_num_rows($query);
//讀取共筆作者
$sql = "SELECT share.share_id,share.user_id,user.user_name ";
$sql .= " FROM share , user";
$sql .= " WHERE itinerary_id= '" . $id . "' and";
$sql .= " share.user_id = user.user_id";
$result0 = mysqli_query($con, $sql);
$total_records0 = mysqli_num_rows($result0);

//讀取收藏景點
$sql2 = "SELECT favorites.view_id,sight.view_name";
$sql2 .= " FROM favorites ,sight";
$sql2 .= " WHERE user_id= '" . $_SESSION['user_id'] . "' and";
$sql2 .= " favorites.view_id=sight.view_id";
$result2 = mysqli_query($con, $sql2);
$total_records = mysqli_num_rows($result2);

//調整景點順序
if (isset($_GET['sequence'])) {
    if (!empty($_GET['share'])) {
        $share = "&share=" . $_GET['share'];
    } else {
        $share = "";
    }
    if (!empty($_SESSION['day1'])) {
        $day2 = "&day=" . $_SESSION['day1'];
    } else {
        $day2 = "";
    }
    $sequence = strip_tags($_GET['sequence']);
    $view_id = strip_tags($_GET['view_id']);
    $sqlUpdate = "UPDATE `sequence` SET
    `sequence`='" . $sequence . "'
    WHERE `itinerary_id` = '" . $id . "' and
     view_id='" . $view_id . "'";
    $row1 = mysqli_query($con, $sqlUpdate);
    if (!empty($row1)) {
        header("Location: modifyitinerary.php?id=" . $id . $share . $day2 . "");
    } else {
        echo "<script> alert('調整失敗!');parent.location.href='modifyitinerary.php?id=" . $id . $share . $day2 . "'; </script>";
    }
}
//調整景點出遊日期
if (isset($_GET['opt_day'])) {
    if (!empty($_GET['share'])) {
        $share = "&share=" . $_GET['share'];
    } else {
        $share = "";
    }
    if (!empty($_SESSION['day1'])) {
        $day2 = "&day=" . $_SESSION['day1'];
    } else {
        $day2 = "";
    }
    $opt_day = strip_tags($_GET['opt_day']);
    $view_id = strip_tags($_GET['view_id']);
    $sqlUpdate = "UPDATE `sequence` SET
    `opt_day`='" . $opt_day . "',
    `sequence`=1
    WHERE `itinerary_id` = '" . $id . "' and
     view_id='" . $view_id . "'";
    $row1 = mysqli_query($con, $sqlUpdate);
    if (!empty($row1)) {
        header("Location: modifyitinerary.php?id=" . $id . $share . $day2 . "");
    } else {
        echo "<script> alert('調整失敗!');parent.location.href='modifyitinerary.php?id=" . $id . $share . $day2 . "'; </script>";
    }
}
//刪除行程
if (isset($_GET['delete'])) {
    if (!empty($_GET['share'])) {
        $share = "&share=" . $_GET['share'];
    } else {
        $share = "";
    }
    $del = strip_tags($_GET['delete']);
    $delsql = "DELETE FROM`sequence` WHERE `itinerary_id` = " . $del;
    $delsql1 = "DELETE FROM`share` WHERE `itinerary_id` = " . $del;
    $delsql2 = "DELETE FROM`itinerary` WHERE `itinerary_id` = " . $del;
    if (mysqli_query($con, $delsql)) {
        if (mysqli_query($con, $delsql1)) {
            if (mysqli_query($con, $delsql2)) {
                header("Location: manageitinerary.php");
            } else {
                echo "<script> alert('刪除失敗!');parent.location.href='modifyitinerary.php?id=" . $id . $share . "'; </script>";
            }
        } else {
            "<script> alert('刪除失敗!');parent.location.href='modifyitinerary.php?id=" . $id . $share . "'; </script>";
        }
    } else { {
            "<script> alert('發生異常!');parent.location.href='modifyitinerary.php?id=" . $id . $share . "'; </script>";
        }
    }
}
//新增景點
if (isset($_GET['add'])) {
    $id = strip_tags($_GET['id']);
    $add = strip_tags($_GET['favorite_id']);
    $addtodel = $_GET['addtodel'];
    $addsql = "INSERT INTO `sequence`(`itinerary_id`, `view_id`, `opt_day`, `sequence` ) VALUES
    ('" . $id . "', '" . $add . "', 1 , 1 )";
    $del1sql = "DELETE FROM `favorites` WHERE `user_id`= '$user_id'  and `view_id` = " . $add;
    if (mysqli_query($con, $addsql)) {
        if ($addtodel == 1) {
            if (mysqli_query($con, $del1sql)) {
                echo "<script> alert('成功新增景點並刪除收藏!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
            }
        } else {
            header("Location: modifyitinerary.php?id=" . $id . "");
        }
    } else {
        echo "<script> alert('這個景點已經新增過了!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
    }
}

//刪除景點
if (isset($_GET['del'])) {
    $id = strip_tags($_GET['id']);
    $del = strip_tags($_GET['del']);
    $delsql = "DELETE FROM`sequence` WHERE `view_id` = " . $del;
    if (mysqli_query($con, $delsql)) { {
            header("Location: modifyitinerary.php?id=" . $id . "");
        }
    } else {
        echo "<script> alert('刪除失敗!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>編輯行程-<?php echo $itinerary_name;  ?> | TravelFun</title>
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
        <div class="py-md-5">
            <div class="container2">
                <div class="row">
                    <div class="text-center p-5 col-lg-10 offset-lg-1">
                        <fieldset></fieldset>
                        <h4 class="text-center card-title"><b><?php echo $itinerary_name;
                                                                if ($_GET['seeall'] == false) {
                                                                    echo "(第" . $day . "天,共" . $itinerary_days . "天)";
                                                                } else echo "(全程,共" . $itinerary_days . "天)"; ?></b></h4>
                        <hr>
                        <td colspan="2" align="center" valign="top">
                            <?php
                            //echo $check;
                            $totalday = $itinerary_days - 1;
                            echo "<B>起始日期：</B>" . date("Y年m月d日", strtotime($itinerary_date)) . "</p>";
                            echo "<B>終止日期：</B>" . date("Y年m月d日", strtotime($itinerary_date . "+ " . $totalday . " day")) . "</p>";
                            echo "<B>公開狀態：</B>";
                            if ($public_status == 1) {
                                echo "公開";
                            } elseif ($public_status == 2) {
                                echo "不公開";
                            }
                            echo "</p>";
                            echo "<B>共筆作者：</B>";
                            if (isset($total_records0)) {
                                echo $total_records0 . " 人";
                            } else {
                                echo "0 人";
                            }
                            echo "</p>";
                            ?>
                        </td>
                        <table class="table">
                            <tr>
                                <form class="" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" name="form">
                                    <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                                    <td colspan="2">
                                        <select name="favorite_id">
                                            <option value="" selected=selected disabled="true" required class="form-control">新增景點</option>
                                            <?php
                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                echo "<option value='" . $row2["view_id"] . "'> " . $row2["view_name"];
                                                $j++;
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="checkbox" class="form-check-input" id="exampleCheck1" name="addtodel" value="1">
                                        <label class="form-check-label" for="exampleCheck1">新增後刪除收藏</label>
                                    </td>
                                    <td><button class="btn btn-secondary btn-block btn-sm" type="submit" name="add">新增景點</button></td>
                                </form>
                            </tr>
                            <tr>
                                <td><input class="btn btn-info btn-block btn-sm" type="button" value="返回" onclick="location.href='manageitinerary.php'" /></td>
                                <td><input class="btn btn-info btn-block btn-sm" type="button" value="管理收藏" onclick="location.href='manageFavorites.php'" /></td>
                                <td><input class="btn btn-secondary btn-block btn-sm" type="button" value="編輯行程" onclick="location.href='edititinerary.php?id=<?php {
                                                                                                                                                                    echo $id;
                                                                                                                                                                }
                                                                                                                                                                if (isset($_GET['share'])) {
                                                                                                                                                                    echo "&share=1";
                                                                                                                                                                }  ?> '" /></td>
                                <?php if (isset($_GET['share'])) {
                                } else { ?>
                                    <td><input class="btn btn-danger btn-block btn-sm" type="button" value="刪除行程" onclick="location.href='modifyitinerary.php?id=1&delete=<?php echo $id; ?>'" /></td>
                                <?php } ?>
                            </tr>
                        </table>
                        <table class="table">
                            <thead>
                                <tr align="center" valign="center">
                                    <td align='center'>項次</td>
                                    <td align='center'>景點名稱</td>
                                    <td align='center'>出遊日期</td>
                                    <?php if ($_GET['seeall'] == false) { ?>
                                        <td colspan="2" align='center'>順序調整</td>
                                        <td colspan="2" align='center'>天數調整</td>
                                        <td align='center'>刪除</td>
                                    <?php } else {
                                    } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $j = 0; //計數
                                if ($total_records1 != 0) {
                                    while ($row2 = mysqli_fetch_row($query)) {
                                        $j = $j + 1;
                                        $view_id      = $row2[0];
                                        $view_name    = $row2[1];
                                        $opt_day      = $row2[2] - 1;
                                        $sequence     = $row2[3];
                                        $shortcode    = $row2[4];
                                        $source       = $row2[5];
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
                                            <?php if ($_GET['seeall'] == false) { ?>
                                                <th align='center'><?php if ($j != 1) {
                                                                        echo  "<a href=?id=" . intval($id) . "&view_id=" . $view_id . "&sequence=" . ($sequence - 1);
                                                                        if (isset($_GET['share'])) {
                                                                            echo "&share=1";
                                                                        }
                                                                        echo ">🔺</a> ";
                                                                    } ?> </th>
                                                <th align='center'><?php if ($j != $total_records1) {
                                                                        echo  "<a href=?id=" . $id . "&view_id=" . $view_id . "&sequence=" . ($sequence + 1);
                                                                        if (isset($_GET['share'])) {
                                                                            echo "&share=1";
                                                                        }
                                                                        echo ">🔻</a>";
                                                                    } ?></th>
                                                <th align='center'><?php if ($opt_day + 1 != 1) {
                                                                        echo "<a href=?id=" . $id . "&view_id=" . $view_id . "&opt_day=" . ($opt_day + 1 - 1);
                                                                        if (isset($_GET['share'])) {
                                                                            echo "&share=1";
                                                                        }
                                                                        echo ">🔼</a>";
                                                                    } ?> </th>
                                                <th align='center'><?php if ($opt_day + 1 != $itinerary_days) {
                                                                        echo "<a href=?id=" . $id . "&view_id=" . $view_id . "&opt_day=" . ($opt_day + 1 + 1);
                                                                        if (isset($_GET['share'])) {
                                                                            echo "&share=1";
                                                                        }
                                                                        echo ">🔽</a>";
                                                                    } ?></th>
                                                <th align='center'><?php echo "<a href=?id=" . $id . "&del=" . intval($view_id);
                                                                    if (isset($_GET['share'])) {
                                                                        echo "&share=1";
                                                                    }
                                                                    echo "> ❌</a>";  ?></th>
                                            <?php } else {
                                            } ?>
                                        <?php } ?>
                                    <?php } else { ?> <td colspan="8" align="center" valign="center" style="font-size:24px;font-weight:bold;"> 很抱歉!目前暫時沒有規劃!</td> <?php } ?>
                                        </tr>
                            </tbody>
                            <table class="table">
                                <tr>
                                    <?php if ($_GET['seeall'] == false) { ?>
                                        <td> <input class='btn btn-success btn-block btn-sm' type='<?php if (isset($_GET['day'])) {
                                                                                                        if ($_GET['day'] == 1) {
                                                                                                            echo "hidden";
                                                                                                        } else {
                                                                                                            echo "button";
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo "hidden";
                                                                                                    } ?>' value='前一天' onclick='location.href="modifyitinerary.php?id=<?php echo $id; ?><?php if (isset($_GET['share'])) {
                                                                                                                                                                                            echo "&share=1";
                                                                                                                                                                                        } ?>&day=<?php echo ($day - 1); ?>"' /></td>
                                        <td> <input class='btn btn-warning btn-block btn-sm' type='<?php if ($_GET['day'] >= $itinerary_days) {
                                                                                                        echo "hidden";
                                                                                                    } else {
                                                                                                        echo "button";
                                                                                                    } ?>' value='下一天' onclick='location.href="modifyitinerary.php?id=<?php echo $id; ?><?php if (isset($_GET['share'])) {
                                                                                                                                                                                            echo "&share=1";
                                                                                                                                                                                        } ?>&day=<?php echo ($day + 1); ?>"' /></td>
                                        <td> <input class="btn btn-info btn-block btn-sm" type="<?php if ($_GET['seeall'] == true) {
                                                                                                    echo "hidden";
                                                                                                } else {
                                                                                                    echo "button";
                                                                                                } ?>" value="查看全部" onclick="location.href='modifyitinerary.php?id=<?php echo $id; ?><?php if (isset($_GET['share'])) {
                                                                                                                                                                                        echo "&share=1";
                                                                                                                                                                                    } ?>&seeall=true'" /></td>
                                    <?php } ?>
                                    <td> <input class="btn btn-info btn-block btn-sm" type="<?php if ($_GET['seeall'] == false) {
                                                                                                echo "hidden";
                                                                                            } else {
                                                                                                echo "button";
                                                                                            } ?>" value="查看各天" onclick="location.href='modifyitinerary.php?id=<?php echo $id; ?><?php if (isset($_GET['share'])) {
                                                                                                                                                                                    echo "&share=1";
                                                                                                                                                                                } ?>&day=1'" /></td>
                                    <td>
                                        <input class="btn btn-info btn-block btn-sm" type="button" value="行程輸出" onclick="location.href='../itinerary.php?id=<?php echo $id; ?>'" />
                                    </td>
                                </tr>
                            </table>
                        </table>
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