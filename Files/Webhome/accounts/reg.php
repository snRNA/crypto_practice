<head>
    <meta charset='UTF-8'>
    <link rel="stylesheet" type="text/css" href="/FormFieldSet.css">
</head>
<?php
if (!isset($_POST['submit'])) {
    echo('非法访问!');
    header("Location:reg.html");
}
$username = test_input($_POST['username']);
$password = test_input($_POST['password']);
$email = test_input($_POST['email']);

//注册信息判断
if (!preg_match('/^[\x{4E00}-\x{9FFF}\w\-\_\.]+$/u', $username)) {
    exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
}
if (strlen($password) < 6 || strlen($password) > 36) {
    exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
    if (!preg_match('/^[\w\-\_\.\+\=]+$/', $password)) {
        exit('错误：密码中存在非法字符。<a href="javascript:history.back(-1);">返回</a>');
    }
} else if (!testpassword($password)) {
    exit('错误：密码中必须要有字母，数字和特殊字符。<a href="javascript:history.back(-1);">返回</a>');
}
if (!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $email)) {
    exit('错误：电子邮箱格式错误。<a href="javascript:history.back(-1);">返回</a>');
}
?>

<body>

<fieldset>
    <legend>提示信息</legend>
    <?php
    //包含数据库连接文件
    include('conn.php');
    //检测用户名是否已经存在
    $check_query = mysql_query("select uid from user where username='$username' limit 1");
    if (mysql_fetch_array($check_query)) {
        echo '错误：用户名', $username, ' 已存在。<a href="javascript:history.back(-1);">返回</a>';
        exit;
    }

    //对密码进行加盐hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    //生成公私钥对

    $config = array(
        "digest_alg" => "sha256",
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $res = openssl_pkey_new($config);

    // Extract the private key from $res to $privKey
    openssl_pkey_export($res, $privKey);

    // Extract the public key from $res to $pubKey
    $pubKey = openssl_pkey_get_details($res);
    $pubKey = $pubKey["key"];
    //写入数据
    $sql = "INSERT INTO user(username,password,email,regdate,pubkey,prikey)VALUES('$username','$password','$email',
CURRENT_TIME(),'$pubKey','$privKey')";

    if (mysql_query($sql, $conn)) {
        exit('用户注册成功！点击此处<a href="login.html">登录</a>');
    } else {
        echo '抱歉！添加数据失败：', mysql_error(), '<br/>';
        echo '点击此处<a href="javascript:history.back(-1);">返回</a> 重试';
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function testpassword($password)
    {
        return (preg_match('/[0-9]/', $password) && preg_match('/[a-z]/i', $password) && preg_match('/[\-\_\.\+\=]/', $password));
    }

    ?>
</fieldset>
</body>
