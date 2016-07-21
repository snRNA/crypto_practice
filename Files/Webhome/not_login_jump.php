<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:/accounts/login.html");
    exit();
}
