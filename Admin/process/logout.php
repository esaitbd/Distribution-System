<?php
//Start session
session_start();

session_destroy();
header("location: http://192.168.45.176:192/DS/sandbox/index.php");
exit();