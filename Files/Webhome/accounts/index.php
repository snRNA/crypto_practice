<?php
/**
 * Created by PhpStorm.
 * User: KomeijiKuroko
 * Date: 2015/7/22
 * Time: 3:18
 */

session_start();

//未登录：跳到登录
if (!isset($_SESSION['userid'])) {
    header("Location:login.html");
    exit();
}

//已经登录，显示My
if (isset($_SESSION['userid'])) {
    header("Location:my.html");
    exit();
}