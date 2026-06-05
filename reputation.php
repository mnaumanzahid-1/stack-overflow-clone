<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
$q_count = $conn->query("SELECT COUNT(*) AS c FROM questions WHERE user_id=$user_id")->fetch_assoc()['c'];
$a_count = $conn->query("SELECT COUNT(*) AS c FROM answers WHERE user_id=$user_id")->fetch_assoc()['c'];
$reputation = ($a_count * 10) + ($q_count * 5);
echo "<h2>Reputation</h2>";
echo "<b>Your reputation:</b> $reputation<br>";
echo "(10 points per answer, 5 per question)";
?>