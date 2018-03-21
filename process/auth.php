<?php
//Create authentication

//Start session
session_start();

if(!isset($_SESSION['STUD_ID']) || count($_SESSION['STUD_ID']) == 0) {
    header("location: http://192.168.45.176:192/DS/index.php");
    exit();
}