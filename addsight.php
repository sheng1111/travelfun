<?php
session_start();
if(isset($_SESSION['mid'])!="") {
	header("Location: index.php");
}
include_once 'dbconnect.php';
  if(isset( $_POST[ 'submit' ] )) {
    $sql = "INSERT INTO sights(sights_name, sights_tel, sights_address, sights_hashtag, sights_intro)VALUES('".$_POST["sights_name"]."', '".$_POST["sights_tel"]."', '".$_POST["sights_address"]."', '".$_POST["sights_hashtag"]."', '".$_POST["sights_intro"]."')";
    $result = mysqli_query( $con, $check );
	$row = mysqli_fetch_assoc( $result );
    mysql_query($sql);
    if($_FILES["up_photo"]!="")	{
      $sights_id = mysql_insert_id();
      for($i=0; $i<count($_FILES["up_photo"]); $i++) {
        if($_FILES["up_photo"]["tmp_name"][$i]!="") {
          $src_file = $_FILES["up_photo"]["tmp_name"][$i];
          $desc = uniqid();
          $src_ext = strtolower(strrchr($_FILES["up_photo"]["name"][$i], "."));
          $desc_file_name = $desc.$src_ext;
          $thumbnail_desc_file_name = "./thumbnail/$desc_file_name";
          resize_photo($src_file, $src_ext, $thumbnail_desc_file_name, 200);
          if(move_uploaded_file($_FILES["up_photo"]["tmp_name"][$i], "photos/".$desc_file_name)) {
            $sql = "INSERT INTO photo(album_id, photo_file)";
            $sql .= " VALUES('$album_id', '$desc_file_name')";
            mysql_query($sql);
          } else {
            echo "檔案上傳失敗!";
          }
        }
      }
    }
    header("location:index.php");
  }
  function resize_photo($src_file, $src_ext, $dest_name, $max_size) {
    switch ($src_ext)	{
      case ".jpg":
        $src = imagecreatefromjpeg($src_file);
        break;
      case ".png":
        $src = imagecreatefrompng($src_file);
        break;
      case ".gif":
        $src = imagecreatefromgif($src_file);
        break;
    }
    $src_w = imagesx($src);
    $src_h = imagesy($src);
    if($src_w > $src_h) {
      $thumb_w = $max_size;
      $thumb_h = intval($src_h / $src_w * $thumb_w);
    } else {
      $thumb_h = $max_size;
      $thumb_w = intval($src_w / $src_h * $thumb_h);
    }
    $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
    imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
    imagejpeg($thumb, $dest_name, 100);
    imagedestroy($src);
    imagedestroy($thumb); 
  }
?>
<html>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title>新增景點｜TravelFun</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
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
                <a class="navbar-brand" href="index.php" ><strong>Travel Fun</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-brand">Hi, <?php echo $_SESSION['name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-item p-0"> <a class="nav-link" href="index.php">首頁</a> </li>
                        <li class="nav-link p-0"> <a class="nav-link" href="#"><img src="image/itinerary.png" alt="itineray" height="25" width="25"></a> </li><!--尚未完成 -->
                        <li class="nav-link p-0"> <a class="nav-link" href="#"><img src="image/search.png" alt="search" height="25" width="25"></a> </li><!--尚未完成 -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"><img src="image/login.png" alt="login" height="25" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default"aria-labelledby="navbarDropdownMenuLink-333">
                                <?php if (isset($_SESSION['id'])) { ?>
                                    <a class="dropdown-item" href="update.php">修改個資</a>
                                    <a class="dropdown-item" href="logout.php">登出</a>
							        <a class="dropdown-item" href="index.php">切換為管理者</a>
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
    <?PHP echo $sql; ?>
    <main>
      <div class="py-md-5">
            <div class="container">
                <form class="text-center p-5 col-md-6 offset-md-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                    <h4 class="text-center card-title"><b>新增景點</b></h4>
					<hr class="">
            <div class="form-group"><label for="name">景點名稱</label>
            <input type="text" name="sights_name"  class="form-control mb-4" /></div>
            <div class="form-group"><label for="name">景點電話</label>
            <input type="text" name="sights_tel"  class="form-control mb-4" /></div>
            <div class="form-group"><label for="name">景點地址</label>
            <input type="text" name="sights_address"  class="form-control mb-4" /></div>
            <div class="form-group"><label for="name">景點hashtag</label>
            <input type="text" name="sights_hashtag"  class="form-control mb-4" /></div>
            <div class="form-group"><label for="name">景點說明</label>
            <td colspan="3"><textarea name="sights_intro" cols="60" rows="6" class="form-control mb-4"></textarea></td>
          </tr>
        </table>
        <hr>
        <center>
          上傳相片 ：<input name="up_photo[]" type="file" class="form-control mb-4"><br>
        </center>
        <p align="center">
          <input type="submit" name="Submit" value="新增景點">
          <input type="button" name="button" value="回上一頁" onClick="window.history.back();">
        </p>
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