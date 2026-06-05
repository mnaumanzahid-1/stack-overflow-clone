<?php
session_start();
include 'header.php';
session_destroy();
header("Location: login.php");
?>