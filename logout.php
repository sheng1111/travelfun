<?php
session_start();

if(isset($_SESSION['id'])) {
	session_destroy();
	unset($_SESSION['id']);
	unset($_SESSION['name']);
	unset($_SESSION['mid']);
	unset($_SESSION['m_name']);
	header("Location: index.php");
} else {
	header("Location: index.php");
}
?>