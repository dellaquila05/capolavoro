<?php
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: ../public/login.html");
}else{
    header("location: home.html");
}
?>