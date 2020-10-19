<?php
session_start();
include_once 'dbconnect.php';
//include_once 'verification.php';
$sql = "SELECT region_id,region_name";
$sql .= " FROM region";
$result = mysqli_query($con, $sql);
//取得記錄數
$total_records = mysqli_num_rows($result);
if (isset($_POST['submit'])) {
    $word = $_POST['keyword'];
    if (empty($word)) {
        $id = $_POST['region_id'];
        header("Location:region.php?region_id=$id");}     
     else {
        $searchmode = $_POST['searchmode'];
        header("Location:region.php?sights_name=$word&searchmode=$searchmode");
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
    <title>搜尋｜TravelFun</title>
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
                        <li class="nav-item p-0"> <a class="nav-link disabled" href="index.php">首頁</a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="#"><img src="image/itinerary.png" alt="itineray" height="25" width="25"></a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="#"><img src="image/search.png" alt="search" height="25" width="25"></a> </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="image/login.png" alt="login" height="25" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <a class="dropdown-item" href="update.php">修改個資</a>
                                    <a class="dropdown-item" href="logout.php">登出</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="login.php">登入</a>
                                    <a class="dropdown-item" href="register.php">註冊</a>
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
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label>
                            <button type="button" name="choosemode" onclick="javascript:location.href='search.php'" class="btn btn-info btn-lg">關鍵字搜尋 <i class="fas fa-magic ml-1"></i></button>
                        </label>
                        <label>
                            <button type="button" name="choosemode" onclick="javascript:location.href='search.php?choosemode=area'" class="btn btn-info btn-lg">地區搜尋 <i class="fas fa-magic ml-1"></i></button>.
                        </label>
                    </div>
                    <?php if (isset($_GET['choosemode'])) { ?>

                        <div class="form-group"><label for="name"> 地區搜尋</label>
                            <select name="region_id">
                                <option value="" selected=selected disabled="true" required class="form-control">請選擇地區</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($result) and $j <= $total_records) {
                                    echo "<option value='" . $row["region_id"] . "'> " . $row["region_name"];
                                    $j++;
                                }
                                ?>
                            </select>
                        </div>

                    <?php } else { ?>
                        <div class="form-group"><label for="name"> 關鍵字</label>
                            <input type="text" name="keyword" class="form-control mb-4" /></div>
                        <div class="form-group">
                            <th>搜尋準度</th>
                            <td>
                                <label class="lb"><input type="radio" class="pr" value='0' name="searchmode" checked="checked" />精準</label>
                                <label class="lb"><input type="radio" class="pr" value='1' name="searchmode" />概略</label>
                            </td>
                        </div>
                    <?php } ?>
                    <?php echo $mode_id; ?>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>