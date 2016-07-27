<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/24/16
 * Time: 9:04 PM
 */

session_start();
include ('../public_lib/check_login.php');

?>

<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
      xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Upload Files</title>
</head>
<body>
<h1>Please select the file you want to upload</h1>
<form name="upload" method="post" action = "uploading.php" enctype="multipart/form-data">
    <label for="file">File name:</label>
    <input type="file" name="file" id="file"/>
    </br>
    <input type="submit" name="upload" value="upload"/>
    </br>
    <a href="../login.html">return</a>

</form>
</body>
</html>
