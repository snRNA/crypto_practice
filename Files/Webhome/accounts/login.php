<head>
    <meta charset='UTF-8'>
    <link rel="stylesheet" type="text/css" href="/FormFieldSet.css">
</head>
<fieldset>
    <legend>提示信息</legend>

    <?php
    session_start();
    //注销登录
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "logout") {
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            echo '注销成功！点击此处 <a href="javascript:history.back(-1);">返回</a>';
            exit;
        }
    }

    //必须放在这里。否则会导致无法得到_Get['action']
    include $_SERVER['DOCUMENT_ROOT'] . "/not_post_jump.php";

    //登录
    if (!test_login()) {
        exit('用户名或密码错误！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
    }
    ?>

    <?php
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function test_login()
    {
        $username = test_input($_POST['username']);
        $pwd = test_input($_POST['password']);
        //包含数据库连接文件
        include('conn.php');
        //检测用户名及密码是否正确
        $result = mysql_query("select uid,password from user where username='$username' limit 1");
        if ($result) {
            $row = mysql_fetch_array($result);
            if (password_verify($pwd, $row['password'])) {
                //登录成功
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $row['uid'];
                echo $username, ' 欢迎你！进入 <a href="my.php">用户中心</a><br/>';
                echo '点击此处 <a href="login.php?action=logout">注销</a>！<br/>';
                exit;
            }
        }
        return false;
    }

    ?>
</fieldset>
</body>
