<?php
//往後只要使用include("function.php");
//加上 cut_content($a,$b);即可,不需每次撰寫.
//$a代表欲裁切內容.
//$b代表欲裁切字數(字元數)
//裁切字串
function cut_content($a,$b){
    $a = strip_tags($a); //去除HTML標籤
    $sub_content = mb_substr($a, 0, $b, 'UTF-8'); //擷取子字串
    echo $sub_content;  //顯示處理後的摘要文字
    //顯示 "......"
    if (strlen($a) > strlen($sub_content)) echo "...";
}


//產生key
function random_string($length, $characters) {
    if (!is_int($length) || $length < 0) {
        return false;
    }
    $characters_length = strlen($characters) - 1;
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, $characters_length)];
    }
    return $string;
}

?>