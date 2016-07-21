<?php
include $_SERVER['DOCUMENT_ROOT'] . "/not_login_jump.php";
?>

<html>
<head>
    <meta charset='UTF-8'>
    <title>
        文件上传
    </title>
    <style>
        #upload {
            text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/InputForm.css">
</head>
<body>
<fieldset style="width: 400px;margin: 0 auto">
    <legend>文件上传</legend>
    <div id="upload">
        <form action="upload_result.php" method="post" enctype="multipart/form-data">
            <label for="file">文件名：</label>
            <input type="file" name="file" id="file"/>
            <br/>
            <input type="submit" name="submit" value="上传"/>
            <br/>
            <a href="../accounts/my.php">返回</a>
        </form>
    </div>
</fieldset>


</body>
</html>