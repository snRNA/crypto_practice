<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/21/16
 * Time: 9:49 AM
 */

$connect = mysqli_connect('localhost','root','toor');
if(!$connect){
    log("database connected failed",mysqli_error($connect));
    //echo "Failed\n";
    //echo(mysqli_error($connect));
}

mysqli_select_db($connect,"ac2016");
mysqli_query($connect,"set character set 'utf-8'");
mysqli_query($connect,"set names 'utf8'");
//echo "\nSuccess!";
