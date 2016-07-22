<?php
include $_SERVER['DOCUMENT_ROOT'] . "/not_login_jump.php";

session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/libs/includes.php";
include $Connect_Lib;
include $_SERVER['DOCUMENT_ROOT'] . "/libs/filecheck.php";

$fileName = $_FILES["file"]["name"];
$fileType = $_FILES["file"]["type"];
$fileSize = $_FILES["file"]["size"];
$tempFile = $_FILES["file"]["tmp_name"];

if (!preg_match('/^[\x80-\xff\w\-\_\.\#\+]+$/', $fileName)) {
    exit('文件名不能包含特殊字符！<a href="javascript:history.back(-1);">返回</a>');
}

if ($fileSize > 10 * 1024 * 1024) {
    echo "上传文件大小超过10MB!";
    exit();
}

if (checkFiletype($fileType)) {
    if ($_FILES["file"]["error"] > 0) {
        exit("Return Code: " . $_FILES["file"]["error"]);
    } else {

        //文件名处理
        $file_hash_md5 = md5_file($tempFile);
        $file_hash_sha1 = sha1_file($tempFile);

        if (file_exists($upload_folder . $file_hash_sha1)) {
            //debug -- 省存储空间
            $upload__result = "Same file already exists.";
        } else {

            //加密文件
            $outputfilepath = $upload_folder . $file_hash_sha1;
            $outputfilename = $file_hash_sha1;
            $upload_iv = fencrypt($tempFile, $outputfilepath);
            //move_uploaded_file($_FILES["file"]["tmp_name"],$upload_folder . $file_hash_sha1);
            unlink($_FILES["file"]["tmp_name"]);

            //显示文件信息
            echo "文件名: " . $fileName . "<br />";
            echo "文件类型: " . $fileType . "<br />";
            echo "文件大小: " . ($fileSize / 1024) . " Kb<br />";
            //echo "Temp file: " . $tempFile . "<br />";
            //echo "文件路径: " . $outputfilepath. "<br />";

            $upload__username = $_SESSION['username'];
            $upload__userid = $_SESSION['userid'];
			
			$result=mysql_query("select prikey from user where uid='$upload__userid' limit 1");
            $row=mysql_fetch_array($result);
            $priKey=$row['prikey'];
            $enfile_hash_sha1 = sha1_file($outputfilepath);
            $enfile_hash_md5 = md5_file($outputfilepath);
            openssl_sign($enfile_hash_sha1, $signaturesha1, $priKey, OPENSSL_ALGO_SHA256);
            openssl_sign($enfile_hash_md5, $signaturemd5, $priKey, OPENSSL_ALGO_SHA256);
			$signaturesha1=base64_encode($signaturesha1);
			$signaturemd5=base64_encode($signaturemd5);
			
            $sql = "INSERT INTO file(filename,size,savefilename,ownername,ownerid,uploadtime,MD5,SHA1,iv,directory,MD5S,SHA1S)
                                    VALUES('$fileName',
                                            '$fileSize',
                                            '$outputfilename',
                                            '$upload__username',
                                            '$upload__userid',
                                            CURRENT_TIME(),
                                            '$file_hash_md5',
                                            '$file_hash_sha1',
                                            '$upload_iv',
											'$outputfilepath',
											'$signaturemd5',
											'$signaturesha1')";
            if (mysql_query($sql, $conn)) {
                $upload__result = "success";
            } else {
                $upload__result = "fail";
                //删除临时文件
                unlink($outputfilepath);
            }
        }
    }
} else {
    $upload__result="Type Error";
}
?>
