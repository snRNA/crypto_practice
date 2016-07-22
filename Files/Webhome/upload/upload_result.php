<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件中继站</title>
</head>
<body>
<div style="text-align: center;">
    <?php
    include "upload_do.php";
    if ($upload__result == "success") {
        echo "上传完毕。 ";
        echo "<a href='upload.php'>继续上传</a> ";
    } elseif ($upload__result == "fail") {
        echo '<br><br>抱歉！添加数据失败：', mysql_error(), '<br/>';
    } elseif ($upload__result == "Same file already exists.") {
        echo '相同的文件已存在。';
        echo '点击此处<a href="javascript:history.back(-1);">返回</a>';
    } elseif ($upload__result == "Type Error") {
        echo "仅允许上传office文档、常见图片类型!";
    }
    ?>
    <a href='../accounts/my.php'>用户中心</a>
</div>
</body>
</html>