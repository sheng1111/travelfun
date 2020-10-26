<?php

include_once 'dbconnect.php';
include 'sendmail.php';

if (isset($_POST['forgot_password'])) {
    $sql = "SELECT * FROM user WHERE user_id = '" . $_POST["user_id"] . "' and user_email = '" . $_POST["user_email"] . "'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sql));
    if (!empty($row)) {
        $user_id = $row["user_id"];
        $user_name = $row["user_name"];
        $user_email = $row["user_email"];
        $user_password = $row["user_password"];

        //寄信
        sendmail($user_name, $user_email, $user_password);

    } else {
        $errormsg = "輸入的帳號和信箱不符!!!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>忘記密碼｜TravelFun</title>
    <link rel="icon" href="image/favicon.png" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="css/platform_style.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mdb.min.css">

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
                        <?php if (isset($_SESSION['admin_id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['user_name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-item p-0"> <a class="nav-link disabled" href="index.php">忘記密碼</a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="login-box">
        <h2>忘記密碼</h2>
        <form method="post">
            <div class="user-box">
                <input type="text" name="user_id" required="請輸入帳號">
                <label>帳號</label>
            </div>
            <div class="user-box">
                <input type="email" name="user_email" required="請輸入信箱">
                <label>信箱</label>
            </div>
            <center><button class="btn btn-info btn-block my-4" type="submit" name="forgot_password">忘記密碼</button></center>
            <?php if (isset($errormsg)) echo $errormsg; ?>
        </form>
    </div>

    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>