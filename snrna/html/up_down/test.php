<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/27/16
 * Time: 1:42 PM
 */

include("../public_lib/connect.php");
include("../up_down/file_crypt.php");

// test sign verify

$dst = "ad0e41e78190a15595280c1e3883a77567c8c99b";
$data = file_get_contents("../file/test123456/".$dst);
//$data = sha1_file("file/test123456/".$dst);

$sign = file_get_contents("../file/test123456/".substr($dst,0,10).".sign");

$pubkey = file_get_contents("../Key/public.key");

$sql = "select * from file where filename = '$dst'";

$result = mysqli_query($connect,$sql);
$row = mysqli_fetch_array($result);

$iv = $row['iv'];
$ownerid = $row['ownerid'];
$padding =$row['padding'];

$sql = "select *from user where uid = '$ownerid'";

$result = mysqli_query($connect,$sql);
$row = mysqli_fetch_array($result);

$key = substr($row['password'],0,32);

$origin = "../file/test123456/".$dst.".origin";

$file = fopen($origin,"w");
fclose($file);

echo "iv2 : ".$iv."</br>";
fileDecrypt("../file/test123456/".$dst,$origin,$iv,$key,$padding);

$test = sha1_file($origin);


echo (md5($origin));

echo "</br>";

echo (md5("../file/test123456/".$dst));

echo "</br>";
echo (openssl_verify($test,$sign,$pubkey,"sha512WithRSAEncryption"));

if (openssl_verify($test,$sign,$pubkey,"sha512WithRSAEncryption"))
{
    echo "Verify success";
}
else{
    echo "Failed";
}