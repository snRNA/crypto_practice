<html>
<head>
    <meta charset='UTF-8'>
    <title>
        我的信息
    </title>
    <link rel="stylesheet" type="text/css" href="/FileTables.css">
</head>
<body>
<div style="margin: 0px auto;width: 600px">
    <fieldset style="margin: 0px auto;width: 600px">
        <legend>用户信息</legend>
        <?php
        session_start();

        //检测是否登录，若没登录则转向登录界面
        if (!isset($_SESSION['userid'])) {
            header("Location:login.html");
            exit();
        }

        //包含数据库连接文件
        include('conn.php');
        $userid = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $user_query = mysql_query("select * from user where uid=$userid limit 1");
        $row = mysql_fetch_array($user_query);
        echo '用户ID：', $userid, '<br />';
        echo '用户名：', $username, '<br />';
        echo '邮箱：', $row['email'], '<br/>';
        echo '注册日期：', $row['regdate'], '<br/>';
        echo '<div id="suggestions">
                <a href="../upload">进入文件中继站</a>
                <a href="../upload/upload.php">上传文件</a>
                <a href="login.php?action=logout">退出</a>
        </div>'
        ?>
    </fieldset>
</div>
</body>
