<?php
session_start();

if(isset($_SESSION['user_id'])) {
	session_destroy();
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['Authority']);
	setcookie("user_key", "", time() - 3600);
	header("Location: index.php");
} else {
	header("Location: index.php");
}
?>