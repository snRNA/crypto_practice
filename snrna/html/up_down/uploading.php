<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/25/16
 * Time: 12:43 PM
 */

require_once "../public_lib/common_func.php";
include ("../public_lib/connect.php");
include ("file_crypt.php");

session_start();
include ("../public_lib/check_login.php");


//var_dump($_FILES);


$path = '../file';

$fileInfo = $_FILES['file'];
$msg = uploadFile($fileInfo,$path,$connect);
mysqli_close($connect);
echo ($msg);
//alertMsg($msg,"index.php");


function uploadFile ($fileInfo,$path,$connect){
    //
    if($fileInfo['error'] == UPLOAD_ERR_OK){
        if(is_uploaded_file($fileInfo['tmp_name']))
        {

            // add control message

            if(filesize($fileInfo['tmp_name']) > 1048576)  //10MB  modify php.ini post_max_size  upload_max_filesize
            {
                $msg = "File size over 10MB";
                return $msg;
            }

            if(!fileTypeCheck($fileInfo))
            {
                $msg = "Upload illegal file types!";
                return $msg;
            }

            $file_sha1 = sha1_file($fileInfo['tmp_name']);
            $filename = sha1($fileInfo['name']);


            $ownerid = $_SESSION['uid'];
            $origin_name = $fileInfo['name'];


            $sql = "select password,uniq_id from user where uid = '$ownerid' limit 1";

            $result = mysqli_query($connect,$sql);
            if(!$result)
            {
                $msg = "Database occur error";
                return $msg;
            }
            $row = mysqli_fetch_row($result);

            $password =$row[0];
            $uniq_id = $row[1];

            if(file_exists("../file/".$uniq_id."/".$filename))
            {

                $msg ="You have uploaded the same file";
                return $msg;
            }

            $key = substr($password,0,32);
            $des_tmp = "/tmp/".$filename;
            $info_array = fileEncrypt($fileInfo['tmp_name'],$des_tmp,$key);
            $iv = $info_array['iv'];
            $padding = $info_array['padding'];


//            $pri_key = openssl_pkey_get_private("../Key/server.key");
//
//            echo ($pri_key);

//            $config = array(
//                "digest_alg" => "sha512",
//                "private_key_bits" => 1024,
//                "private_key_type" => OPENSSL_KEYTYPE_RSA
//            );
//
//
//            $res = openssl_pkey_new($config);
//            openssl_pkey_export($res, $pri_key);
//            $pubkey = openssl_pkey_get_details($res);
//            $pubkey = $pubkey['key'];

            //file_put_contents("../Key/pulic.key",$pubkey);
            //file_put_contents("../key/pri_key.key",$pri_key);

            //echo ($pubkey);

            $pri_key= file_get_contents("../Key/private.key");

            openssl_sign($file_sha1,$sign,$pri_key,OPENSSL_ALGO_SHA512);




            //file_put_contents()
            //echo "iv1: ".$iv."</br>";

            $sign_dst = $path."/".$row[1]."/".substr($filename,0,10).".sign";


            $sql = "insert into file(filename,origin_name,ownerid,uploadtime,file_sha1,iv,sign,padding)VALUES
 ('$filename','$origin_name','$ownerid',NOW(),'$file_sha1','$iv','$sign_dst','$padding')";

            //var_dump()
            //var_dump(mysqli_query($connect,$sql));

            if(!mysqli_query($connect,$sql))
            {
                echo (mysqli_error($connect));
                $msg = "Insert data error";
                return $msg;
            }

            if (!file_exists($path."/".$row[1]))
            {
                mkdir($path."/".$row[1]);
            }
            $destination = $path."/".$row[1]."/".$filename;




            file_put_contents($sign_dst,$sign);

            //echo ($des_tmp);
            //echo "</br>";
            //echo ($destination);

            if(rename($des_tmp,$destination)) {
                $msg = "Upload Success!";
                //unlink($fileInfo['tmp_name']);
            }else{
                $msg = "Move file failed";
            }
        }
        else{
            $msg = "Uploading is refused by is_uploaded_file()";
        }
    }else
    {
        $msg = "Upload failed.Error code".$fileInfo['error']."</br>";
    }

    return $msg;
}


function fileTypeCheck ($fileInfo)
{
    $type_array = array(
        "image/gif",       //gif
        "image/jpeg",     //jpeg
        "image/png",     //png
        "image/bmp",    // bmp
        "image/x-icon",   //ico
        "image/tiff",     //tif tiff
        "image/vnd.adobe.photoshop", //psd
        "text/plain",  // txt text conf def list log in
        "application/pdf",  //pdf
        "application/msword",   //doc dot
        "application/vnd.ms-powerpoint",  //ppt pps pot
        "application/vnd.ms-excel",  //xls xlm xla xlc xlt xlw
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",  //docx
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",  //xlsx
        "application/vnd.openxmlformats-officedocument.presentationml.presentation", //pptx
    );

    foreach ($type_array as $test)
    {
        if($fileInfo['type']=== $test)
        {
            return true;
        }
    }

    return false;
}
