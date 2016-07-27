<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/25/16
 * Time: 10:00 AM
 */

//var_dump($_SESSION);
if(!isset($_SESSION['uid'])){
    header('Location:../login.html');
    exit();
}