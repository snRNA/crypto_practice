<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/28/16
 * Time: 5:51 PM
 */


session_start();

include ("../public_lib/check_login.php");

echo"<html>
<head>
    <meta charset='UTF-8'>
    <title>
        上传与下载界面
    </title>
    <style type=\"text/css\">
        html {
            font-size: 12px;
        }

        fieldset {
            width: 580px;
            margin: 0 auto;
        }

        legend {
            font-weight: bold;
            font-size: 14px;
        }

        label {
            float: left;
            width: 70px;
            margin-left: 10px;
        }

        .left {
            margin-left: 80px;
        }

        .input {
            width: 150px;
        }

        span {
            color: #666666;
        }
    </style>

</head>

<body>
<fieldset>
    <legend>文件上传与下载</legend>
    <a>
        <a href='../up_down/upload.php'><input type=\"button\" value=\"上传\"> </br></a>
        <a href='../up_down/filelist.php'><input type=\"button\" value=\"下载\"> </br></a>
        <a href='logout.php' <input type=\"button\" value=\"退出\"> </br></a>
    </form>
</fieldset>
</body>

</html>"

?>


