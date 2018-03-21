<?php
//Create authentication

//Start session
session_start();

if(!isset($_SESSION['ADMIN_ID']) || count($_SESSION['ADMIN_ID']) == 0) {
    header("location: http://192.168.45.176:192/DS/sandbox/index.php");
    exit();
}