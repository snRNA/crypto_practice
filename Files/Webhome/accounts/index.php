<?php
/**
 * Created by PhpStorm.
 * User: KomeijiKuroko
 * Date: 2015/7/22
 * Time: 3:18
 */

session_start();

//δ��¼��������¼
if (!isset($_SESSION['userid'])) {
    header("Location:login.html");
    exit();
}

//�Ѿ���¼����ʾMy
if (isset($_SESSION['userid'])) {
    header("Location:my.html");
    exit();
}