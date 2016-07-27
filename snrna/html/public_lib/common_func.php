<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/25/16
 * Time: 2:24 PM
 */


function alertMsg($msg,$url){
    echo "<script type='text/javascript'>alert('{$msg}'); location.href = '{$url}';</script>";
}