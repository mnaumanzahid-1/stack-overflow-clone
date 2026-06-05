<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT username, email, created_at FROM users WHERE user_id=$user_id")->fetch_assoc();
$q_count = $conn->query("SELECT COUNT(*) AS c FROM questions WHERE user_id=$user_id")->fetch_assoc()['c'];
$a_count = $conn->query("SELECT COUNT(*) AS c FROM answers WHERE user_id=$user_id")->fetch_assoc()['c'];
echo "<h2>Summary</h2>";
echo "<b>Username:</b> " . htmlspecialchars($user['username']) . "<br>";
echo "<b>Email:</b> " . htmlspecialchars($user['email']) . "<br>";
echo "<b>Member since:</b> " . $user['created_at'] . "<br>";
echo "<b>Your Questions:</b> $q_count<br>";
echo "<b>Your Answers:</b> $a_count<br>";
?>