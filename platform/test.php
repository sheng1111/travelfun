<?php
session_start();
include '../dbconnect.php';
include '../function.php';
if (isset($_GET['delete'])) {
    
    $del = strip_tags($_GET['delete']);
    //先刪除行程
    $selectsql   = "SELECT * FROM `itinerary` where user_id='" . $del. "'";
    $selquery = mysqli_query($con, $selectsql);
    echo "del:".$del."<br>";
    echo "selectsql:".$selectsql."<br>";
    // fetch multiple row using while loop.
    while ($row1 = mysqli_fetch_assoc($selquery)) {
        $delsql = "DELETE FROM`sequence` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        $delsql1 = "DELETE FROM`share` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        $delsql2 = "DELETE FROM`itinerary` WHERE `itinerary_id` = " . $row1['itinerary_id'];
        echo "delsql:".$delsql."<br>";
        echo "delsql1:".$delsql1."<br>";
        echo "delsql2:".$delsql2."<br>";
    }
    $del3sql = "DELETE FROM`favorites` WHERE `user_id` = " . $del; //刪除收藏
    $del4sql = "DELETE FROM`friend` WHERE `oneself` = " . $del . " or `others` =" . $_GET['delete']; //刪除好友
    $del5sql = "DELETE FROM`user` WHERE `user_id` = " . $del; //刪除使用者
    echo "del3sql:".$del3sql."<br>";
    echo "del4sql:".$del4sql."<br>";
    echo "del5sql:".$del5sql."<br>";
}
?>