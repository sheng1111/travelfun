<?php
session_start();
include_once '../dbconnect.php';
date_default_timezone_set("Asia/Taipei");
//驗證登入狀態
if (isset($_SESSION['user_id'])) { {
    }
} else {
    header("Location: ../login.php");
}
$user_id = $_SESSION['user_id'];
$id = strip_tags($_GET['id']);
//修改行程
if (isset($_POST['submit'])) {
    $id = strip_tags($_POST['id']);
    $itinerary_name = strip_tags($_POST['itinerary_name']);
    $public_status = strip_tags($_POST['public_status']);
    $itinerary_date = strip_tags($_POST['itinerary_date']);
    $itinerary_days = strip_tags($_POST['itinerary_days']);
    $sql = "INSERT INTO `itinerary`( `itinerary_name`, `public_status`, `itinerary_date`, `itinerary_days`, `user_id`) ";
    $sql .= "VALUES ( '$itinerary_name',' $public_status', '$itinerary_date', '$itinerary_days','$user_id')";
    if (mysqli_query($con, $sql)) {
        $check = "SELECT `itinerary_id` FROM `itinerary` WHERE itinerary_name ='" . $itinerary_name . "'and public_status ='" . $public_status . "' and  itinerary_date ='" . $itinerary_date . "' and itinerary_days ='" . $itinerary_days . "' and user_id ='" . $user_id . "'";
        $result = mysqli_query($con, $check);
        $row3 = mysqli_fetch_assoc($result);
        $id = $row3["itinerary_id"];
        echo "<script> alert('新增成功!');parent.location.href='modifyitinerary.php?id=" . $id . "'; </script>";
    } else {
        echo "<script> alert('新增失敗!');parent.location.href='additinerary.php'; </script>";
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增行程 | TravelFun</title>
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
                <h4 class="text-center "><b>新增行程</b></h4>
                <hr class="">
                <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                <div class="form-group"><label for="name"> ☀行程名稱</label>
                    <input type="text" name="itinerary_name" class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀起始日期</label>
                    <input type="date" name="itinerary_date" class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀行程天數</label>
                    <input type="number" name="itinerary_days" min=1 max=999 class="form-control mb-4" required />
                </div>
                <div class="form-group"><label for="name">☀公開狀態</label>
                    <select name="public_status">
                        <option value="" disabled="disabled">請選擇狀況</option>
                        <option value="1">公開
                        <option value="2">不公開
                    </select>
                    <center>
                        <button class="btn btn-info btn-primary my-4" type="button" onclick="location.href='manageitinerary.php'">回上一頁</button>
                        <button class="btn btn-info btn-primary my-4" type="submit" name="submit">新增行程</button>
                    </center>
                    <br>
            </form>
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