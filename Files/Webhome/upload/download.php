<?php
/**
 * Created by PhpStorm.
 * User: cuc
 * Date: 15-7-20
 * Time: 下午6:06
 */
include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";

$reference = $_SERVER['HTTP_REFERER'];
if (strpos($reference,'summertime.gov') == false) {
    echo "不允许外链下载！";
    header("Location: /others/400.html");
}

$FileName = $_GET['file'];
$Saveas = $_GET['saveas'];
$FileContent = file_get_contents($upload_folder . $FileName);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=[encrypted]$Saveas");
echo $FileContent;

?>