<?php
session_start();
include_once 'dbconnect.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");

if (isset($_GET['id'])) {
    $id = strip_tags(intval($_GET['id']));
}
if (isset($_GET['key'])) {
    $getkey = strip_tags($_GET['key']);
}
//驗證登入狀態
if (isset($_SESSION['user_id'])) { {
}
} else {
header("Location: login.php?itinerary_id=$id&key=$getkey");
}
$result = mysqli_query($con, "SELECT `itinerary_name`,`public_status`,`itinerary_date`,`itinerary_days`,`user_id`  FROM itinerary WHERE itinerary_id=" . $id);
$row = mysqli_fetch_assoc($result);
$itinerary_name = $row["itinerary_name"];
$public_status = $row["public_status"];
$itinerary_days = $row["itinerary_days"];
$itinerary_date = $row["itinerary_date"];
$user_id = $row["user_id"];
//金鑰產生
$garbled=md5(base64_encode('d>-2Q:cZ').'Pe7"4K*R');
$itinerarycode=md5(base64_encode($id)."|X,bWzgE?$<x");
$authorcode=md5(base64_encode($user_id)."v^}ns|hv@Ra|");
$garbled2=md5(base64_encode('V5xh37MBsV4hHzHt98Nfvnddz8b7NTq8ehFue8GRZneWDk5ZWnUnGgnruAUyqfvuC69yekQWqUDZEe7AUZzuH5WSDXWsz76krZd6t3xBX9U46VeTY639wRKRQpTq5PS9').'Pe7"4K*Racxx3');
$key0=$garbled.$itinerarycode.$authorcode.$garbled2;
$key=hash('sha256', $key0);
//判斷是否一致
if(isset($_GET['key'])&&isset($_GET['id']))
{
    if($getkey==$key)
    {
    $friend_id = $_SESSION['user_id'];
    $check = "SELECT `user_id` FROM `share` WHERE `itinerary_id`='" . $id . "' and `user_id` ='" . $friend_id . "'";
    $result = mysqli_query($con, $check);
    $row = mysqli_fetch_assoc($result);
    $databaseid = $row["user_id"];
    if(empty($row))
    {   if($friend_id==$user_id)
        {$databaseid=$friend_id;}
    }
    if ($databaseid == $friend_id) { 
            echo "<script> alert('你已經是作者或這個共筆作者已經新增過了!');parent.location.href='itinerary.php?id=".$id."';</script>";
    } else {
        $addsql = "INSERT INTO `share`(`itinerary_id`, `user_id`) VALUES ('" . $id . "', '" . $friend_id . "')";
        if (mysqli_query($con, $addsql)) {
            //新增好友
            $checkfriendsql = "select * from friend where `friend_id` in (SELECT `friend_id` FROM `friend` WHERE `oneself`='" . $_SESSION['user_id'] . "' or `others`='" . $_SESSION['user_id'] . "') and `oneself`='" . $user_id . "' or `others`='" . $user_id . "'";
            $checkfriendresult = mysqli_query($con, $checkfriendsql);
            $checkfriendrow = mysqli_fetch_assoc($checkfriendresult);
            if (empty($checkfriendrow)) {
                $addfriendsql = "INSERT INTO `friend`(`oneself`, `others`,`status`) VALUES ('" . $_SESSION['user_id'] . "','" . $user_id . "',1)";
                if (mysqli_query($con, $addfriendsql)) {
                    echo "<script> alert('新增共筆作者成功並成為好友喔!');parent.location.href='itinerary.php?id=".$id."';</script>";
                } 
            } else {
                echo "<script> alert('新增共筆作者成功!');parent.location.href='itinerary.php?id=".$id."';</script>";
            }

        } else {
            echo "<script> alert('新增共筆作者失敗!');parent.location.href='itinerary.php?id=".$id."';</script>";
        }
    }
    }
    else
    {echo "<script> alert('金鑰錯誤!');parent.location.href='index.php';</script>";}
}
?>