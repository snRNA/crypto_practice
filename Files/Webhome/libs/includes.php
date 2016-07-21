<?php
/**
 * Created by PhpStorm.
 * User: cuc
 * Date: 15-7-20
 * Time: 上午10:45
 */

$FileCrypt_LibFolder = '/home/cuc/WebKey/libs';
$Connect_Lib = '/home/cuc/WebKey/libs/connect.php';
$upload_folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/files/';

include $FileCrypt_LibFolder . "/encrypt.php";
include $FileCrypt_LibFolder . "/decrypt.php";

function fencrypt($FileName, $toFileName)
{
    if (file_exists($FileName)) {
        $content = file_get_contents($FileName);
    } else {
        print("File not exist" . $FileName);
    }
    $return_Array = dataencrypt($content);
    $encrypted = $return_Array['data'];
    $file = fopen($toFileName, "w");
    fwrite($file, $encrypted);
    fclose($file);
    return $return_Array['iv'];
}

function fdecrypt($FileName, $toFileName, $iv, $rawsize)
{
    if (file_exists($FileName)) {
        $content = file_get_contents($FileName);
    } else {
        print("File not exist" . $FileName);
    }
    $decrypted = datadecrypt($iv, $content);
    $file = fopen($toFileName, "w");
    fwrite($file, $decrypted);
    fclose($file);
    // Open for reading and writing; place the file pointer at the beginning of the file.
    $handle_cut_file = fopen($toFileName, 'r+');
    ftruncate($handle_cut_file, $rawsize);
    fclose($handle_cut_file);
}

function mdecrypt($FileName, $iv, $rawsize)
{
    $randomname = "/tmp/" . substr(sha1(rand()), 0, 8);
    fdecrypt($FileName, $randomname, $iv, $rawsize);
    $File_Content = file_get_contents($randomname);
    unlink($randomname);
    return $File_Content;
}

//Test Code
//$size = filesize($argv[1]);
//$iv = fencrypt($argv[1], $argv[2]);
//$output_file = "decrypted-" . $argv[2];
//fdecrypt($argv[2], $output_file, $iv, $size);
//$size2 = filesize($output_file);


?>
