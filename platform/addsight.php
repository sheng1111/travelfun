<?php
session_start();

include_once '../dbconnect.php';
if (isset($_POST['submit'])) {
    $sql = "INSERT INTO sights(sights_name, sights_tel, sights_address, sights_intro)VALUES('" . $_POST["sights_name"] . "', '" . $_POST["sights_tel"] . "', '" . $_POST["sights_address"] . "',  '" . $_POST["sights_intro"] . "')";
    mysqli_query($con, $sql);
    if ($_FILES["up_photo"] != "") {
        $sights_id = mysqli_insert_id($con);
        for ($i = 0; $i < count($_FILES["up_photo"]); $i++) {
            if ($_FILES["up_photo"]["tmp_name"][$i] != "") {
                $src_file = $_FILES["up_photo"]["tmp_name"][$i];
                $desc = uniqid();
                $src_ext = strtolower(strrchr($_FILES["up_photo"]["name"][$i], "."));
                $desc_file_name = $desc . $src_ext;
                $thumbnail_desc_file_name = "../thumbnail/$desc_file_name";
                resize_photo($src_file, $src_ext, $thumbnail_desc_file_name, 200);
                if (move_uploaded_file($_FILES["up_photo"]["tmp_name"][$i], "../photos/" . $desc_file_name)) {
                    $sql_photos = "INSERT INTO `photos` (sights_id, photos_files)";
                    $sql_photos .= "VALUES('$sights_id', '$desc_file_name')";
                    mysqli_query($con, $sql_photos);
                } else {
                    echo "檔案上傳失敗!";
                }
            }
        }
    }
    //header("location:index.php");
}
function resize_photo($src_file, $src_ext, $dest_name, $max_size)
{
    switch ($src_ext) {
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
    if ($src_w > $src_h) {
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

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增景點 | 管理後台</title>
    <link rel="icon" href="../image/favicon.png" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mdb.min.css">

    <link rel='stylesheet' href='https://rawgit.com/adrotec/knockout-file-bindings/master/knockout-file-bindings.css'>
    <link rel="stylesheet" href="../css/addsight.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top unique-color">
            <div class="container">
                <a class="navbar-brand" href="index.php"><strong>管理員介面</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['admin_id'])) { ?>
                            <li class="nav-item p-0"><a class="nav-link disabled">Hi, <?php echo $_SESSION['admin_name']; ?>!</a></li>
                        <?php } else  ?>
                        <li class="nav-item p-0"> <a class="nav-link disabled" href="index.php">首頁</a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="py-md-5">
            <div class="container">
                <form class="text-center p-5 col-md-6 offset-md-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <h4 class="text-center card-title"><b>新增景點</b></h4>
                    <hr class="">
                    <div class="form-group"><label for="name">☀景點名稱</label>
                        <input type="text" name="sights_name" class="form-control mb-4" /></div>
                    <div class="form-group"><label for="name">☀景點電話</label>
                        <input type="text" name="sights_tel" class="form-control mb-4" /></div>
                    <div class="form-group"><label for="name">☀景點地址</label>
                        <input type="text" name="sights_address" class="form-control mb-4" /></div>
                    <div class="form-group"><label for="name">☀景點hashtag</label>
                        <input type="text" name="sights_hashtag" class="form-control mb-4" /></div>
                    <div class="form-group"><label for="name">☀景點說明</label>
                        <td colspan="3"><textarea name="sights_intro" cols="60" rows="6" class="form-control mb-4"></textarea></td>
                        </tr>
                        </table>
                        <hr>
                        <!-- upload image -->
                        <div class="container2">
                            <h3>上傳照片</h3>
                            <div class="well" data-bind="fileDrag: multiFileData">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <!-- ko foreach: {data: multiFileData().dataURLArray, as: 'dataURL'} -->
                                        <img style="height: 100px; margin: 5px;" class="btn btn-info btn-block my-4" data-bind="attr: { src: dataURL }, visible: dataURL">
                                        <!-- /ko -->
                                        <div data-bind="ifnot: fileData().dataURL">
                                            <label class="drag-label">將照片拖到此處</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="up_photo[]" type="file" multiple data-bind="fileInput: multiFileData, customFileInput: {buttonClass: 'btn btn-success',fileNameClass: 'disabled form-control',onClear: onClear,}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- upload image -->

                        <p>
                            <input class="btn btn-info btn-block my-4" type="submit" name="submit" value="新增景點">
                            <input class="btn btn-info btn-block my-4" type="button" name="button" value="回上一頁" onClick="window.history.back();">
                        </p>
                </form>
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

    <script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js'></script>
    <script type="text/javascript" src="../js//knockout-file-bindings.js"></script>
    <script type="text/javascript" src="../js/addsight.js"></script>
</body>

</html>