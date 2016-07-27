<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/25/16
 * Time: 4:06 PM
 */

include ("../public_lib/common_func.php");
include ("../public_lib/connect.php");

session_start();



if (isset($_SESSION['uid'])&&isset($_SESSION['username']))
{
    // decrypt and download for logining user

}
else
{
    // download cipher and sign  and trans the key
    //echo "<script type='text/javascript'>alert('Anonymous user only can download cncrypted files')</script>";
    downloadNoLogin("326d07a343a96956109e65faecde6fea3a7d2ad9",$connect);

}






function checkReferer($referer)
{
    if(strpos($referer, 'snrna.gov') === false){
        alertMsg("Refused download from other sites!","../");
    }


}

function downloadNoLogin($filename,$connect)
{
    $sql = "SELECT * FROM file where filename = '$filename'";
    $result = mysqli_query($connect,$sql);
    if(!$result)
    {
        echo (mysqli_error($connect));
        //alertMsg("select data error!","../");
    }
    //var_dump($result);
    $row = mysqli_fetch_array($result);
    //var_dump($row["fid"]);
    downloadFile("../file/test123456"."/".$row["filename"]);
    //downloadFile("../file/test123456"."/".substr($row["filename"],0,10).".sign");
    echo (1);
}

function downloadLogin($filename,$connect)
{

}

function downloadFile($filename)
{

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}