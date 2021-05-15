<?php
if(isset($_GET['tag']))
{
    $tag=$_GET['tag'];
    switch($tag)
    {
        case "Keelung"://1
            shell_exec('crawler_exe\keelung.exe');
        break;
        case "Taipei"://2
            shell_exec('crawler_exe\taipei.exe');
        break;
        case "Taoyuan"://3
            shell_exec('crawler_exe\taoyuan.exe');
        break;
        case "Yilan"://4
            shell_exec('crawler_exe\yilan.exe');
        break;
        case "Hsinchu"://5
            shell_exec('crawler_exe\hsinchu.exe');
        break;
        case "Miaoli"://6
            shell_exec('crawler_exe\miaoli.exe');
        break;
        case "Taichung"://7
            shell_exec('crawler_exe\taichung.exe');
        break;
        case "Changhua"://8
            shell_exec('crawler_exe\changhua.exe');
        break;
        case "Yunlin"://9
            shell_exec('crawler_exe\yunlin.exe');
        break;
        case "Nantou"://10
            shell_exec('crawler_exe\nantou.exe');
        break;
        case "Chiayi"://11
            shell_exec('crawler_exe\chiayi.exe');
        break;
        case "Tainan"://12
            shell_exec('crawler_exe\tainan.exe');
        break;
        case "Kaohsiung"://13
            shell_exec('crawler_exe\kaohsiung.exe');
        break;
        case "Pingtung"://14
            shell_exec('crawler_exe\pingtung.exe');
        break;
        case "Hualien"://15
            shell_exec('crawler_exe\hualien.exe');
        break;
        case "Taitung"://16
            shell_exec('crawler_exe\taitung.exe');
        break;
        case "Penghu"://17
            shell_exec('crawler_exe\penghu.exe');
        break;
        case "Kinmen"://18
            shell_exec('crawler_exe\kinmen.exe');
        break;
        case "Mazu"://19
            shell_exec('crawler_exe\mazu.exe');
        break;
    }
}
