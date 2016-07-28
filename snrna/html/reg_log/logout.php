<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/28/16
 * Time: 5:56 PM
 */

session_start();

unset($_SESSION['uid']);
unset($_SESSION['username']);
echo "Log out success!</br>";
echo " <a href = '../index.html'> return</a> ";