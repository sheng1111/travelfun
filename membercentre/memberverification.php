<?php
session_start();
include_once '../dbconnect.php';
include '../function.php';
$key=$_GET['key'];
if (isset($key)) {
    $key=strip_tags($key);
    $sql = "SELECT * FROM user WHERE user_key = '" . $key. "'";
    $row = mysqli_fetch_assoc(mysqli_query($con, $sql));
    if(!empty($row)){
        if(empty($row["Authority"])||$row["Authority"]=0)
        {
            $random = random_string(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $sqlUpdate = "UPDATE user SET
                    Authority=1 ,
                    user_key='" . $random . "'
                    WHERE user_key = '" . $key. "'";
            $row1 = mysqli_query($con, $sqlUpdate);
            $_SESSION['user_id'] = $row["user_id"];
            $_SESSION['user_name'] = $row["user_name"];
                if (!empty($row1)) {
                    echo "<script> alert('認證成功!');parent.location.href='../index.php'; </script>";
                } else {
                    echo "<script> alert('認證失敗!');parent.location.href='../index.php'; </script>";
                }
        }
        else {echo "<script> alert('您已經是正式會員囉!');parent.location.href='../index.php'; </script>";}
        }
        else
        {echo "<script> alert('連結已失效!');parent.location.href='../index.php'; </script>";}
}
else
{header("Location: ../index.php");}
