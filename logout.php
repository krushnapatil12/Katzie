<?php

session_start();
$_SESSION = array();
session_destroy();
//header("location: login.php");

echo '<script>alert("Succcessfully logged out!")</script>';

echo '<script>setTimeout(function(){window.location.href = "login.php";}, 50);</script>';

?>