<?php
session_start();

if (isset($_GET["fid"])) {
    $id = $_SESSION["fid"] = $_GET["fid"];
}

include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
include $Connect_Lib;

$result = mysql_query("SELECT * FROM file where fid='$id' limit 1");

$row = mysql_fetch_array($result);

?>

<html>
<head>
    <meta charset='UTF-8'>
    <title>
        文件校验
    </title>
</head>
<body>
<center>
    <fieldset style="width: 800px;margin: 0 auto">
        <legend>文件校验</legend>
        <label>原文件：<?php echo $row['filename']; ?></label>
        <br/>

        <form action="check_file.php?method=1" method="post" enctype="multipart/form-data">
            <label for="file">明文校验：</label>
            <input type="file" name="file" id="file"/>
            <input type="submit" value="确定"/>
        </form>
        <br/>

        <form action="check_file.php?method=2" method="post" enctype="multipart/form-data">
            <label for="file">密文校验：</label>
            <input type="file" name="file" id="file"/>
            <input type="submit" value="确定"/>
        </form>
        <br/>
        <a href="javascript:history.back(-1);">返回</a>
    </fieldset>
</center>
</body>
</html>