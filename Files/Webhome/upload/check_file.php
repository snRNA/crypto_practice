<html>
<head>
    <meta charset='UTF-8'>
    <link rel="stylesheet" type="text/css" href="/FormFieldSet.css">
</head>

<body>
<fieldset>
    <legend>提示信息</legend>
    <?php
    session_start();

    if (isset($_GET["method"])) {
        $method = $_GET["method"];
    } else {
        exit("GET WRONG!");
    }

    if (isset($_SESSION["fid"])) {
        $id = $_SESSION["fid"];
        //unset($_SESSION["fid"]);
    } else {
        exit("SESSION WRONG!");
    }

    if ($method == 1 || $method == 2) {
        $tempFile = $_FILES["file"]["tmp_name"];
        $file_hash_md5 = md5_file($tempFile);
        $file_hash_sha1 = sha1_file($tempFile);
        include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
        include $Connect_Lib;
        $result = mysql_query("SELECT * FROM file where fid='$id' limit 1");

        if (!$result) {
            exit("WRONG!");
        }

        $row = mysql_fetch_array($result);

        //明文校验
        if ($method == 1) {
            if ($file_hash_md5 == $row['MD5'] && $file_hash_sha1 == $row['SHA1']) {
                exit("明文校验结果：文件与" . $row['filename'] . "为同一文件！ 点击此处 <a href='javascript:history.back(-1);'>返回</a>");
            } else {
                exit("明文校验结果：文件与" . $row['filename'] . "不相同！ 点击此处 <a href='javascript:history.back(-1);'>返回</a>");
            }
        }
        //密文校验
        if ($method == 2) {
            $id = $row['ownerid'];
            $result = mysql_query("SELECT pubkey FROM user where uid='$id' limit 1");
            $user = mysql_fetch_array($result);
                if (openssl_verify($file_hash_md5, base64_decode($row['MD5S']), $user['pubkey'], "sha256WithRSAEncryption") && openssl_verify($file_hash_sha1, base64_decode($row['SHA1S']), $user['pubkey'], "sha256WithRSAEncryption")) {
                exit("密文校验结果：文件与" . $row['filename'] . "为同一文件！ 点击此处 <a href='javascript:history.back(-1);'>返回</a>");
            } else {
                exit("密文校验结果：文件与" . $row['filename'] . "不相同！ 点击此处 <a href='javascript:history.back(-1);'>返回</a>");
            }
        }
    }
    ?>

</fieldset>
</body>
</html>