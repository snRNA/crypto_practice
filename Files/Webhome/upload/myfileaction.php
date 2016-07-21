<?php
/**
 * Created by PhpStorm.
 * User: cuc
 * Date: 15-7-21
 * Time: 下午2:00
 */
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/not_login_jump.php";
include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
include $Connect_Lib;

$RequestFileName = $_GET['file'];
$user_name = $_SESSION['username'];
$user_id = $_SESSION['userid'];
$Saveas = $_GET['saveas'];

$result = mysql_query("SELECT * FROM file");
while ($row = mysql_fetch_array($result)) {
    if ($row['savefilename'] === $RequestFileName) {
        if (($row['ownername'] === $user_name) && ($row['ownerid'] === $user_id)) {
            $action = $_GET['action'];
            if ($action === 'save') {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=$Saveas");
                $fileContent = mdecrypt($upload_folder . $row['savefilename'], $row['iv'], $row['size']);
                echo $fileContent;
                exit();
            } elseif ($action === 'del') {
                $fileid = $row['fid'];
                mysql_query("DELETE FROM `users`.`file` WHERE `fid`='$fileid'");
                unlink($upload_folder . $row['savefilename']);
                $RequestStatus = 'del';
            }
        } else {
            $RequestStatus = 'NotFileOwner';
        }
    }
};
if ($RequestStatus == 'del') {
    echo "删除成功！";
} else{
    http_response_code (400);
}

    /*if ($RequestStatus == 'NotFileOwner') {
    echo "这不是你的文件！";
} else {
    echo "无效的请求。";
}
    */