<?php
$conn = @mysql_connect('localhost', 'userdata', 'P92hX67pZuuXKKxNGCq7');
if (!$conn) {
    log("连接数据库失败：" . mysql_error());
}
mysql_select_db("users", $conn);
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
?>