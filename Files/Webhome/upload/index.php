<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件中继站</title>
    <link rel="stylesheet" type="text/css" href="/FileTables.css">
</head>
<body
<!--style="margin:0px;padding:0px;overflow:hidden"-->
<center>
    <h1>文件中继站</h1>

    <div>
        <div class='main-table-div'>
            <?php
            include "listfiles.php";
            ?>
        </div>
        <?php
        if (isset($_SESSION['username'])) {
            echo "欢迎您，" . $_SESSION['username'];
            echo "
                <div id='suggestions'>
                    <a href='../accounts/my.php'>用户中心</a>
                    <a href='upload.php'>上传文件</a>
                    <a href='myfilelist.php'>我的文件</a>
                    <a href='../accounts/login.php?action=logout'>退出</a>
                </div>
            ";

        } else {
            echo "
                <div id='suggestions'>
                    <span><a href='../accounts/login.html'>登录</a></span>
                    <span><a href='../accounts/reg.html'>注册</a></span>
                </div>
            ";
        }
        ?>
    </div>
</center>
</body>
</html>