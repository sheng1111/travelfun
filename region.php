<?php
  include_once 'dbconnect.php';
  //require_once("connMysql.php");
  session_start();
  if (!empty($_GET["sights_name"])){
    $mode_id=$_GET[ 'searchmode' ];
    $name=$_GET["sights_name"];
    switch ($mode_id){
        case 0:
        $sql = "SELECT sights.sights_id, sights.sights_name, photo.photo_file, count(photo.sights_id)";
        $sql .= " FROM sights, photo";
        $sql .= " WHERE sights.sights_name='$name' and sights.sights_id=photo.sights_id";
        $sql .= " GROUP BY sights.sights_id";
        $result = mysqli_query($con,$sql);
        break;
        case 1:
        $sql = "SELECT sights.sights_id, sights.sights_name, photo.photo_file, count(photo.sights_id)";
        $sql .= " FROM sights, photo";
        $sql .= " WHERE sights.sights_name like '%$name%' and sights.sights_id=photo.sights_id";
        $sql .= " GROUP BY sights.sights_id";
        $result = mysqli_query($con,$sql);
        break;
    }
}
   if (!empty($_GET["region_id"])){
    $result = mysqli_query( $con, "SELECT * FROM region WHERE `region_id` = '" . $_GET["region_id"] . "'");
    $row = mysqli_fetch_assoc( $result );
    $name=$row[ "region_name" ];
    $id=$_GET["region_id"];
    $sql = "SELECT region.region_name,sights.sights_id, sights.sights_name, photo.photo_file, count(photo.sights_id)";
    $sql .= " FROM sights, photo , region , sights_region";
    $sql .= " WHERE sights_region.region_id=region.region_id and sights.sights_id=photo.sights_id";
    $sql .= " GROUP BY sights.sights_id";
    $result = mysqli_query($con,$sql);
    }
  if(empty($_GET["sights_name"])&empty($_GET["region_id"])){
  $sql = "SELECT sights.sights_id, sights.sights_name, photo.photo_file, count(photo.sights_id)";
  $sql .= " FROM sights, photo";
  $sql .= " WHERE sights.sights_id=photo.sights_id";
  $sql .= " GROUP BY sights.sights_id";
  $result = mysqli_query($con,$sql);}
  //指定每頁顯示幾筆記錄
  $records_per_page = 4;
  //取得要顯示第幾頁的記錄
  if (isset($_GET["page"]))
    $page = $_GET["page"];
  else
    $page = 1;
  //取得記錄數
  $total_records = mysqli_num_rows($result);
  //計算總頁數
  $total_pages = ceil($total_records/$records_per_page);
  //計算本頁第一筆記錄的序號
  $started_record = $records_per_page*($page-1);
  //將記錄指標移至本頁第一筆記錄的序號
  if ($total_records!=0)
    mysqli_data_seek($result, $started_record);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travel Fun">
    <meta name="keywords" content="Travel">
    <title><?php if (isset($name)) echo $name; else echo "景點選擇"; ?>｜TravelFun</title>
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
                <a class="navbar-brand" href="index.php" ><strong>Travel Fun</strong></a>
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
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false"><img src="image/login.png" alt="login" height="25" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default"aria-labelledby="navbarDropdownMenuLink-333">
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
    <form class="p-5 col-md-6 offset-md-3" role="form" name="form">
		<h4 class="text-center card-title"><b><?php if (isset($name)) echo $name; else echo "景點總覽"; ?></b></h4>
		<hr class="">
    <div class="form-group"><label for="name"> 景點總數：<?php echo $total_records;?></td></label>

  <tr><td height="4" colspan="2"><hr></td></tr>
  <tr>
    <td colspan="2" align="center" valign="middle">
    <?php
      //顯示記錄
      $j = 1;
      echo "<table width='0' border='2'><tr>";
      while($row=mysqli_fetch_assoc($result) and $j<=$records_per_page) {
        echo "<td align='center' valign='bottom' width='200'>";
        echo "<a href='./sights.php?sights_id=".$row["sights_id"]."'>";
        echo "<img src='./thumbnail/".$row["photo_file"]."'></a><br>";
        echo $row["sights_name"]."<br>";
        echo "<font size='2' color='#904E0E'>共".$row["count(photo.sights_id)"]."張</font>";
        echo "</td>";
        $j++;
      }
      echo "</tr></table>";
    ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">
    <ul class="pagination">
    <li class="page-item">
    <?php
      //產生導覽列
      echo "<p align='center'>";
      if($page>1)
        echo "<li class='page-item'><a class='page-link' href='region.php?page=".($page-1)."'>上一頁</a> </li> ";
      for($i=1; $i<=$total_pages; $i++) {
        if($i==$page)
          echo "<li class='page-item'><a class='page-link' >$i</a></li> ";
        else
          echo "<li class='page-item'><a class='page-link' href='region.php?page=$i'>$i</a></li> ";
      }
      if($page<$total_pages)
        echo "<li class='page-item'><a class='page-link' href='region.php?page=".($page+1)."'>下一頁</a></li>";
      echo "</p>";
    ?>
        </li>
      </ul>
    </td>
  </tr>
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