<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/26/16
 * Time: 9:14 AM
 */

include("../public_lib/encrypt.php");
include ("../public_lib/decrypt.php");

function fileEncrypt($filename, $dst_filename, $key)
{
    if(file_exists($filename))
    {
        $content = file_get_contents($filename);
    }
    else
    {
        print ("File :".$filename." not exists");
        exit;
    }

    $size = filesize($filename);



    $return_array = dataencrypt($content,$key);

    $encrypted_data = $return_array['data'];
    $padding =$return_array['block'] -($size%$return_array['block']);
    $file = fopen($dst_filename, "w");
    fwrite($file, $encrypted_data);
    fclose($file);


    $returnArray =array(
        'iv' =>$return_array['iv'],
        'padding' =>$padding
    );

    return $returnArray;

}


function fileDecrypt($filename,$dst_filename,$iv,$key,$padding)
{
    if(file_exists($filename))
    {
        $content = file_get_contents($filename);
    }
    else
    {
        print ("File :".$filename." not exists");
        exit;
    }

    $decrypted_data = datadecrypt($iv,$content,$key);


    $file = fopen($dst_filename, "w");
    echo "padding".$padding."</br>";
    $decrypted_data = substr($decrypted_data,0,strlen($decrypted_data)-$padding);
    fwrite($file, $decrypted_data);
    fclose($file);


}