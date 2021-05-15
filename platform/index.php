<?php
session_start();
include_once '../dbconnect.php';
//使用者登入情況下可自動賦予管理權限
if (isset($_SESSION['user_id'])) {
	$sql = "SELECT Authority FROM user WHERE user_id = '" . $_SESSION["user_id"] . "'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	if (!empty($row)) {
		$_SESSION['Authority'] = $row['Authority'];
		//顯示主功能頁面
	} else {
		header("Location:../index.php");
	}
} else {
	header("Location: ../login.php");
}
?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Travel Fun">
	<meta name="keywords" content="Travel">
	<title>目錄 | 管理後台</title>
	<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/mdb.min.css">
	<link rel="stylesheet" href="../css/platform_index.css">
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
						<li class="nav-link p-0"> <a class="nav-link" href="../logout.php"><img src="../image/logout.png" alt="登出" height="25" width="25"></a> </li>
					</ul>
				</div>
			</div>
		</nav>
	</header>

	<main>
		<div class="dashboard display-animation width" style="margin: 0 auto;">
			<br /><br /><br /><br /><br />

			<a class="tile tile-lg tile-cs ripple-effect bottom-small" onclick="location.href='managemember.php';">
				<span class="content-wrapper">
					<span class="tile-content">
						<span class="tile-img"><i class="fa fa-user fa-5x v-alignment"></i></span>
						<span class="tile-holder tile-holder-sm">
							<span class="title">使用者</span>
						</span>
					</span>
				</span>
			</a>

			<a class="tile tile-lg tile-sqr tile-math ripple-effect tile-small right-small" onclick="location.href='../index.php';">
				<span class="content-wrapper">
					<span class="tile-content">
						<span class="tile-img tile-img-bg"><i class="fa fa-undo fa-5x v-alignment-q"></i></span>
						<span class="tile-holder tile-holder-sm">
							<span class="title">返回</span>
						</span>
					</span>
				</span>
			</a>

			<a class="tile tile-lg tile-sqr tile-eng ripple-effect tile-small small-left" onclick="location.href='managesight.php';">
				<span class="content-wrapper">
					<span class="tile-content">
						<span class="tile-img tile-img-bg"><i class="fa fa-map-signs fa-5x v-alignment-q"></i></span>
						<span class="tile-holder tile-holder-sm">
							<span class="title">景點</span>
						</span>
					</span>
				</span>
			</a>

			<a class=" tile tile-lg tile-physics ripple-effect top-small" onclick="$('#exampleModal').modal('show')">
				<span class="content-wrapper">
					<span class="tile-content">
						<span class="tile-img"><i class="fa fa-rocket fa-5x v-alignment"></i></span>
						<span class="tile-holder tile-holder-sm">
							<span class="title">執行程式</span>
						</span>
					</span>
				</span>
			</a>
		</div>
	</main>


	<footer class="page-footer font-small unique-color fixed-bottom">
		<div class="footer-copyright text-center py-3">© 2020 Copyright: Travel Fun</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js'></script>
	<script type="text/javascript" src="../js/platform_style.js"></script>
</body>

<!-- 執行程式(地點選擇) -->
<div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<center>
					<h5 class="modal-title" id="exampleModalLabel">地點</h5>
				</center>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<center>
					<h5><a href='run.php?tag=Keelung'>基隆</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Taipei'>台北</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Taoyuan'>桃園</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Yilan'>宜蘭</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Hsinchu'>新竹</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Miaoli'>苗栗</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Taichung'>台中</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Changhua'>彰化</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Yunlin'>雲林</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Nantou'>南投</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Chiayi'>嘉義</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Tainan'>台南</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Kaohsiung'>高雄</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Pingtung'>屏東</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Hualien'>花蓮</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Taitung'>台東</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Penghu'>澎湖</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Kinmen'>金門</a></h5>
				</center>
				<hr>
				<center>
					<h5><a href='run.php?tag=Mazu'>馬祖</a></h5>
				</center>
			</div>
			<!--<div class="modal-footer">
	  	<center><button type="button" class="btn btn-primary btn-rounded">關閉</button><center>
      </div>-->
		</div>
	</div>
</div>

</html>