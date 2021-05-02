<?php
session_start();
include_once 'dbconnect.php';
include 'function.php';
if (isset($_POST['submit'])) {
    $kind =  $_POST['choose'];
    $kind1 =  $_POST['choose1'];
    $sourcekind= $_POST['source'];
    $word = $_POST['keyword'];
    if($facebookswitch!=1){
    //(舊功能)尋找景點關鍵字
    $kind=1;//預設選項為關鍵字
    switch($kind){
     case 1 :
        $check = "SELECT * FROM `sight` WHERE view_name like '%$word%'";
                    $chresult = mysqli_query($con, $check);
                    $row2 = mysqli_fetch_assoc($chresult);
                    $checkrow = $row2["view_id"];
                    if (empty($checkrow)) {
                        $error = true;
                        $messageerror = "查無景點!";
                    }
                    if (!$error) {
                        header("Location:result.php?keyword=$word");
                    }
                    break;
                case 2:
                    $check = "SELECT * FROM `sight` WHERE tag_area like '%$word%'";
                    $chresult = mysqli_query($con, $check);
                    $row2 = mysqli_fetch_assoc($chresult);
                    $checkrow = $row2["view_id"];
                    if (empty($checkrow)) {
                        $error = true;
                        $messageerror = "查無景點!";
                    }
                    if (!$error) {
                        header("Location:result.php?tagname=$word");
                    }

                    break;
                }
            }
    else{
    //當$facebookswitch=1時
    switch($sourcekind){
     case "FaceBook":
        $sourcesql=" and source=1";
        $check = "SELECT * FROM `sight` WHERE status=1 ".$sourcesql." and view_name like '%$word%'";
        $chresult = mysqli_query($con, $check);
        $row2 = mysqli_fetch_assoc($chresult);
        $checkrow = $row2["view_id"];
        if (empty($checkrow)) {
            $error = true;
            $messageerror = "查無景點!";
        }
        if (!$error) {
            header("Location:result.php?keyword=$word&source=FaceBook");
        }
        break;
     case "instagram":
        $sourcesql=" and source=0";
        $check = "SELECT * FROM `sight` WHERE status=1 ".$sourcesql." and view_name like '%$word%'";
        $chresult = mysqli_query($con, $check);
        $row2 = mysqli_fetch_assoc($chresult);
        $checkrow = $row2["view_id"];
        if (empty($checkrow)) {
            $error = true;
            $messageerror = "查無景點!";
        }
        if (!$error) {
            header("Location:result.php?keyword=$word&source=instagram");
        }
        break;
     case "All":
        $check = "SELECT * FROM `sight` WHERE status=1 and view_name like '%$word%'";
        $chresult = mysqli_query($con, $check);
        $row2 = mysqli_fetch_assoc($chresult);
        $checkrow = $row2["view_id"];
        if (empty($checkrow)) {
            $error = true;
            $messageerror = "查無景點!";
        }
        if (!$error) {
            header("Location:result.php?keyword=$word&source=All");
        }
        break;   
    }
}
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>搜尋景點｜TravelFun</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="icon" href="image/favicon.png" type="image/ico" />
    <link rel="stylesheet" href="css/style.css">
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
            <div class="container">
                <form class="p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="searchform">
                    <h4 class="text-center card-title"><b>搜尋</b></h4>
                    <div class="form-group">
                        <label for="name"> 關鍵字</label>
                        <input type="text" name="keyword" class="form-control mb-4" required>
                    <?php if($facebookswitch==1) { ?>
                        <label for="name"> 搜尋來源:</label>
                            <input type="radio" name="source" value=instagram>IG
                            <input type="radio" name="source" value=FaceBook>FB
                            <input type="radio" name="source" value=All required>全部
                        <br>
                    </div>
                    <?php } ?>
                    <span class="text-danger"><?php if (isset($messageerror)) echo $messageerror; ?></span>
                    <center><button class="btn btn-info btn-block my-4" type="submit" name="submit">搜尋</button></center>
                </form>
            </div>
        </div>
    </main>

	<footer class="page-footer font-small unique-color fixed-bottom">
        <div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
    </footer>

    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>