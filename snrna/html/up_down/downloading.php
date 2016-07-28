<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/25/16
 * Time: 4:06 PM
 */

include ("../public_lib/common_func.php");
include ("../public_lib/connect.php");
include ("file_crypt.php");

session_start();


if (isset($_GET['code'])) {
    $code = get_input($_GET['code']);
    $link = get_input($_GET['link']);
}elseif (isset($_POST['code'])&&isset($_POST['link']))
{
    $code = get_input($_POST['code']);
    $link =get_input($_POST['link']);
//    var_dump("00");
//    var_dump($code);
//    var_dump($link);
}
else{
    alertMsg("lack share code!","../Login,html");
}
//var_dump($link);

//checkReferer($_SERVER['HTTP_REFERER']);

//var_dump("0");

if (isset($_SESSION['uid'])&&isset($_SESSION['username']))
{
    $uid = $_SESSION['uid'];
    $username = $_SESSION['username'];
    $sql = "select * from download where down_link = '$link' and down_key = '$code'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);
    $time = $row['create_time'];
    $frequency = $row['down_frequency'];
    if(check_time($time)&&check_frequency($frequency))
    {
        $frequency +=1;
        var_dump($frequency);
        $sql = "update download set down_frequency ='$frequency' where down_link ='$link'";
        mysqli_query($connect,$sql);
        $flag =true;

    }


    $ownerid = $row['ownerid'];
    if($ownerid!=$uid && !$flag)
    {
        echo "The key is expired!</br>";
        echo "<a href='javascript:history.back(-1)'>return</a>";
        exit;
    }

    $file = $row['filename'];
    $dst = $row['filename'];

    $sql = "select * from user where uid = '$ownerid'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);

    $key = substr($row['password'],0,32);
    $dir = $row['uniq_id'];

    $data = file_get_contents("../file/".$dir."/".$dst);


    $sign = file_get_contents("../file/".$dir."/".substr($dst,0,10).".sign");

    $pubkey = file_get_contents("../Key/public.key");

    $sql = "select * from file where filename = '$dst'";

    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);

    $iv = $row['iv'];
    $ownerid = $row['ownerid'];
    $padding =$row['padding'];

    $origin = "../file/".$dir."/".$dst.".origin";

    $file = fopen($origin,"w");
    fclose($file);


    fileDecrypt("../file/".$dir."/".$dst,$origin,$iv,$key,$padding);

    $test = sha1_file($origin);


    if (openssl_verify($test,$sign,$pubkey,"sha512WithRSAEncryption"))
    {
        downloadFile($origin);
        unlink($origin);
    }
    else{
        echo "Verify Failed";
        echo "<a href='javascript:history.back(-1)'>return</a>";
        exit;

    }
}
else
{

//    var_dump("1");
//    var_dump($link);
//    var_dump($code);
    $sql = "select * from download where down_key = '$code' and down_link = '$link'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);
    var_dump($row);
    $time = $row['create_time'];
    $frequency = $row['down_frequency'];
    //var_dump(check_time($time));
    //var_dump(check_frequency($frequency));
    if(check_time($time)&&check_frequency($frequency))
    {
//        var_dump($time);
//        var_dump($frequency);
        $frequency +=1;
        $sql = "update download set down_frequency ='$frequency' where down_link ='$link'";
        mysqli_query($connect,$sql);
        $flag =true;
    }


    $ownerid = $row['ownerid'];
    if(!$flag)
    {
        echo "The key is expired!</br>";
        echo "<a href='javascript:history.back(-1)'>return</a>";
        exit;
    }

    $file = $row['filename'];
    $dst = $row['filename'];

    $sql = "select * from user where uid = '$ownerid'";
    $result = mysqli_query($connect,$sql);
    $row = mysqli_fetch_array($result);

    $key = substr($row['password'],0,32);
    $dir = $row['uniq_id'];


    downloadFile("../file/".$dir."/".$dst);

}






function checkReferer($referer)
{
    if(strpos($referer, 'snrna.gov') === false){
        alertMsg("Refused download from other sites!","../");
        exit;
    }


}

function downloadFile($filename)
{
    ob_end_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}


function check_time($time,$maxtime=86400)
{
//    echo (date("U"));
//    echo ($time);
    if(date("U")-$time>=$maxtime)
    {
        return false;

    }else
    {
        return true;
    }
}

function check_frequency($frequency,$maxfre=3)
{
    if($frequency+1>$maxfre)
    {
        return false;
    }else
    {
        return true;
    }
}

function get_input($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;

}