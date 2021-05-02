<?php
session_start();
include_once 'dbconnect.php';
include 'sendmail.php';
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
if(!isset($_GET['id']))
{   if(isset($_SESSION['user_id']))
    {$id=$_SESSION['user_id'];}
    else
    {header("Location: index.php");}}
$id=strip_tags($_GET['id']);
//顯示個人資料(好友數)
//自己不顯示加好友按鈕
//顯示好友數、行程數(連公開行程)、大頭貼、名稱、電子郵件(顯示?or功能)
$sql = "SELECT * FROM `user` WHERE user_id='".$id."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$name=$row['user_name'];
$email=$row['user_email'];
$photo=$row['photo'];
$introduction=$row['introduction'];
$Authority=$row['Authority'];
//顯示行程數
$sql = "SELECT count(`itinerary_id`) FROM `itinerary` WHERE `user_id`='$id'";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($result1);
$countitinerary=$row1[0];

//搜尋好友名單及數量
//每頁顯示10筆資料(項次跨頁壘加)
//自己可維護好友
$sql2 = "SELECT * FROM `friend` WHERE `oneself` = 'sheng' or `others`='$id'  and status = 1 ";
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

//顯示待審核名單(限自己)
if($_GET['Approved']==false && $id=$_SESSION['user_id']){
    
}

//搜尋用戶功能(限登入使用)
if(isset($_GET['search']) && $_SESSION['user_id']){
    echo "<script> alert('調整失敗!'); </script>";
}
//好友狀態判別
//若已加過顯示信息,自己不可加
if(isset($_SESSION['user_id'])){
    
}
//寄信功能(限自己)
if(isset($_GET['send']) && $id=$_SESSION['user_id']){
   $sendid=strip_tags($_GET['send']);

}
//刪除好友(限自己)
if(isset($_GET['del']) && $id=$_SESSION['user_id']){
    $delid=strip_tags($_GET['del']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>關於我<?php if (isset($name)) {echo "-".$name;} ?>｜TravelFun</title>
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
    <div class="py-md-5">
            <div class="container2">
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
