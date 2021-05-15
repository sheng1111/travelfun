<?php
session_start();
include_once 'dbconnect.php';
include 'function.php';
mysqli_query($con, "SET NAMES UTF8");
//驗證登入狀態
if (isset($_SESSION['user_id']) && $addressmodifyswitch == 1) {
} else {
    header("Location: ../login.php");
}
if (isset($_GET['id'])) {
    $id = strip_tags(intval($_GET['id']));
}
if (isset($_POST['id'])) {
    $id = strip_tags(intval($_POST['id']));
}
$sql = "SELECT `view_name` FROM sight where view_id=" . $id;
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$view_name = $row["view_name"];
$addresssql = "SELECT `address` FROM note where view_id=" . $id;
$addressresult = mysqli_query($con, $addresssql);
$addressrow = mysqli_fetch_assoc($addressresult);
$address = $addressrow["address"];
if (isset($_POST['delete'])) {
    $id = strip_tags($_POST['id']);
    $sql = "DELETE FROM `note` WHERE view_id=" . $id;
    if (mysqli_query($con, $sql)) {
        echo "<script> alert('刪除成功!');parent.location.href='result.php'; </script>";
    } else {
        echo "<script> alert('刪除失敗!'); </script>";
    }
}
if (isset($_POST['submit'])) {
    $id = strip_tags($_POST['id']);
    $address = strip_tags($_POST['address']);

    if (empty($addressrow)) {
        $sql = " INSERT INTO `note`(`view_id`, `address`) VALUES ('" . $id . "', '" . $address . "')";
    } else {
        $sql = "UPDATE note SET address='" . $address . "' WHERE `view_id` = '" . $id . "'";
    }
    if (mysqli_query($con, $sql)) {
        echo "<script> alert('更新成功!');parent.location.href='result.php'; </script>";
    } else {
        echo "<script> alert('更新失敗!'); </script>";
    }
}

?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title><?php echo $view_name . "-"; ?>地址變更｜TravelFun</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="icon" href="image/favicon.png" type="image/ico" />

</head>
<main>
    <div class="py-md-5">
        <div class="container">
            <form class="text-center p-5 col-md-6 offset-md-3" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                <div class="form-group">景點名稱:<?php echo $view_name; ?></div>
                <div class="form-group">
                    <input type="text" name="address" class="form-control mb-4" placeholder="請輸入地址" value="<?PHP echo $address; ?>" />
                </div>
                <center><button class="btn btn-info  my-4" type="submit" name="submit">送出</button>
                    <button class="btn btn-danger  my-4" type="submit" name="delete">刪除</button>
                </center>
        </div>
    </div>
    </form>

</main>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="js/index.js"></script>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>