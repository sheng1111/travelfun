<?php
session_start();
include_once '../dbconnect.php';
mysqli_query($con, "SET NAMES UTF8");
date_default_timezone_set("Asia/Taipei");
if (isset($_GET['share'])) {
    $share = strip_tags($_GET['share']);
}
if (isset($_POST['share'])) {
    $share = strip_tags($_POST['share']);
}
if (isset($_GET['id'])) {
    $id = strip_tags(intval($_GET['id']));
}
if (isset($_POST['id'])) {
    $id = strip_tags(intval($_POST['id']));
}
//(附加功能)將資料庫重複景點改為不發佈
if(isset($_GET["reset"])){
    $countsql = "SELECT `view_id`, `view_name` FROM `sight` where";
    //搜尋來源設定
    if ($_GET['source'] == "FaceBook") {
        $countsql .= " source=1 and";
    } else {
        $countsql .= " source=0 and";
    }
    $countsql .= " `view_name` in (SELECT `view_name` FROM `sight`";
    //搜尋來源設定
    if ($_GET['source'] == "FaceBook") {
        $countsql .= " where status=1 and source=1";
    } else {
        $countsql .= "where status=1 and source=0";
    }
    $countsql .= " group by `view_name` HAVING count(`view_name`)>1)";
    if ($_GET['source'] == "FaceBook") {
        $countsql .= " and source=1";
    } else {
        $countsql .= " and source=0";
    }
    echo $countsql."<br>";
    $countquery = mysqli_query($con, $countsql);
    $totalcount = mysqli_num_rows($countquery);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($countquery)) {
        
        $searchsql="SELECT * FROM `sight` WHERE `view_name`='".$rowout['view_name']."' ORDER BY `sight`.`view_id` ASC limit 1";
        $searchquery = mysqli_query($con, $searchsql);
        $out = mysqli_fetch_assoc($searchquery);
        echo $s."/".$totalcount.":".$searchsql."<br>";
        echo $s."/".$totalcount.":".$out['view_id']."<br>";
        if($out['view_id']!=$rowout['view_id'])
        {$resetsql="UPDATE `sight` SET `status`= null WHERE `view_id`='".$rowout['view_id']."'";
        echo $s."/".$totalcount.":".$resetsql."<br>";}
        $s++;
    }
    
}
 //(附加功能)將資料庫重複景點刪除
if(isset($_GET["repeat"])){
    $countsql0 = "SELECT `view_id`, `view_name` FROM `sight` where";
    //搜尋來源設定
    if ($_GET['source'] == "FaceBook") {
        $countsql0 .= " source=1 and";
    } else {
        $countsql0 .= " source=0 and";
    }
    $countsql0 .= " `view_name` in (SELECT `view_name` FROM `sight`";
    //搜尋來源設定
    if ($_GET['source'] == "FaceBook") {
        $countsql0 .= " where status is null and source=1";
    } else {
        $countsql0 .= "where status is null and source=0";
    }
    $countsql0 .= " group by `view_name` HAVING count(`view_name`)>1)";
    if ($_GET['source'] == "FaceBook") {
        $countsql0 .= " and source=1";
    } else {
        $countsql0 .= " and source=0";
    }
    $countquery = mysqli_query($con, $countsql0);
    $deltotal_records = mysqli_num_rows($countquery);
    if ($deltotal_records > 0) {
        $delmessage = "<b style='color:blue;'>注意:目前有" . $deltotal_records . "個景點無法發佈，請點選「<a href='?repeat=true";
        if ($_GET['source'] == "FaceBook") {
            $delmessage .=  "&source=FaceBook&resetdel=true'>自動刪除</a>」進行更改</b>";
        } else  {
                $delmessage .=  "&resetdel=true'>自動刪除</a>」進行更改</b>";
            }
        }
        echo $countsql0."<br>";
        echo $delmessage."<br>";
    if(isset($_GET["resetdel"])){
        $s=1;
        while ($rowout = mysqli_fetch_assoc($countquery)) {
            $resetsql="DELETE FROM `sight` WHERE `view_id`='".$rowout['view_id']."'";
            echo $s.":".$resetsql."<br>";
            $s++;
        }
        if (isset($_GET["mode"])) {
            $modeurl .= "mode=" . $_GET["mode"];
        }
        if (isset($_GET["repeat"])) {
            $repeaturl = "repeat=true";
            if (isset($_GET["page"])) {
                $repeaturl .= "&page=" . $_GET["page"];
            }
        }
        $resetsearchsql="SELECT * FROM `sight` ORDER BY `view_id` ASC";
        $resetsearchresult = mysqli_query($con, $resetsearchsql);
        $s=1;
        while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
        $resetsql="UPDATE `sight` SET `view_id`='".$s."' WHERE `view_id`='".$rowout['view_id']."'";
        echo $s.":".$resetsql."<br>";
        $s++;
        }
    }
} 
//(附加功能)將好友編號重置
if(isset($_GET["resetfriendid"])){
    $resetsearchsql="SELECT * FROM `friend` ORDER BY `friend_id` ASC";
    $resetsearchresult = mysqli_query($con, $resetsearchsql);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
    $resetsql="UPDATE `friend` SET `friend_id`='".$s."' WHERE `friend_id`='".$rowout['friend_id']."'";
    echo $resetsql."<br>";
    $s++;
    }
    
}
//(附加功能)將行程編號重置
if(isset($_GET["resetitineraryid"])){
    $resetsearchsql="SELECT * FROM `itinerary` ORDER BY `itinerary_id` ASC";
    $resetsearchresult = mysqli_query($con, $resetsearchsql);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
    $resetsql="UPDATE `itinerary` SET `itinerary_id`='".$s."' WHERE `itinerary_id`='".$rowout['itinerary_id']."'";
    echo $resetsql."<br>";
    $s++;
    }
    
}
//(附加功能)將順序編號重置
if(isset($_GET["resetsequenceid"])){
    $resetsearchsql="SELECT * FROM `sequence` ORDER BY `itinerary_id`,`opt_day`,`sequence` ASC";
    $resetsearchresult = mysqli_query($con, $resetsearchsql);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
    $resetsql="UPDATE `sequence` SET `sequence_id`='".$s."' WHERE `sequence_id`='".$rowout['sequence_id']."'";
    echo $resetsql."<br>";
    $s++;
    }
    
}
//(附加功能)將分享編號重置
if(isset($_GET["resetshareid"])){
    $resetsearchsql="SELECT * FROM `share` ORDER BY `share_id` ASC";
    $resetsearchresult = mysqli_query($con, $resetsearchsql);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
    $resetsql="UPDATE `share` SET `share_id`='".$s."' WHERE `share_id`='".$rowout['share_id']."'";
    echo $resetsql."<br>";
    $s++;
    }
    
}
//(附加功能)將景點編號重置
if(isset($_GET["resetviewid"])){
    $resetsearchsql="SELECT * FROM `sight` ORDER BY `view_id` ASC";
    $resetsearchresult = mysqli_query($con, $resetsearchsql);
    $s=1;
    while ($rowout = mysqli_fetch_assoc($resetsearchresult)) {
    $resetsql="UPDATE `sight` SET `view_id`='".$s."' WHERE `view_id`='".$rowout['view_id']."'";
    echo $resetsql."<br>";
    $s++;
    }
    
}
//鏈結產生網址
$garbled=md5(base64_encode('d>-2Q:cZ').'Pe7"4K*R');
$itinerarycode=md5(base64_encode($id)."|X,bWzgE?$<x");
$authorcode=md5(base64_encode($user_id)."v^}ns|hv@Ra|");
$garbled2=md5(base64_encode('V5xh37MBsV4hHzHt98Nfvnddz8b7NTq8ehFue8GRZneWDk5ZWnUnGgnruAUyqfvuC69yekQWqUDZEe7AUZzuH5WSDXWsz76krZd6t3xBX9U46VeTY639wRKRQpTq5PS9').'Pe7"4K*Racxx3');

$key0=$garbled.$itinerarycode.$authorcode.$garbled2;
$key=hash('sha256', $key0);
?>

<html>
亂碼:d>-2Q:cZ<br>
亂碼(base64):<?php echo base64_encode('d>-2Q:cZ');?><br>
亂碼(md5+base64):<?php echo md5(base64_encode('d>-2Q:cZ').'Pe7"4K*R');?><br>
行程:<?php echo $id;?><br>
行程(base64):<?php echo base64_encode($id);?><br>
行程(md5+base64):<?php echo md5(base64_encode($id)."|X,bWzgE?$<x");?><br>
發文者:<?php echo $user_id;?><br>
發文者(base64):<?php echo base64_encode($user_id);?><br>
發文者(md5+base64):<?php echo md5(base64_encode($user_id)."v^}ns|hv@Ra|");?><br>
金鑰:<?php echo $key;?><br>
test:<?php echo hash('sha512',base64_encode($key));?><br>
<input id="copyTarget" value="Some initial text"> <button id="copyButton">Copy</button><br><br>
<span id="copyTarget2">Some Other Text</span> <button id="copyButton2">Copy</button><br><br>
<input id="pasteTarget"> Click in this Field and hit Ctrl+V to see what is on clipboard<br><br>
<span id="msg"></span><br>



<script >
document.getElementById("copyButton").addEventListener("click", function() {
    copyToClipboardMsg(document.getElementById("copyTarget"), "msg");
});

document.getElementById("copyButton2").addEventListener("click", function() {
    copyToClipboardMsg(document.getElementById("copyTarget2"), "msg");
});

document.getElementById("pasteTarget").addEventListener("mousedown", function() {
    this.value = "";
});


function copyToClipboardMsg(elem, msgElem) {
	  var succeed = copyToClipboard(elem);
    var msg;
    if (!succeed) {
        msg = "Copy not supported or blocked.  Press Ctrl+c to copy."
    } else {
        msg = "Text copied to the clipboard."
    }
    if (typeof msgElem === "string") {
        msgElem = document.getElementById(msgElem);
    }
    msgElem.innerHTML = msg;
    setTimeout(function() {
        msgElem.innerHTML = "";
    }, 2000);
}

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
</script>
</html>

