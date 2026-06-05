<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT u.username FROM following f JOIN users u ON f.followee_id=u.user_id WHERE f.follower_id=$user_id");
echo "<h2>Users You Follow</h2>";
if ($res->num_rows === 0) {
    echo "You are not following anyone yet.";
} else {
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['username']) . "</li>";
    }
    echo "</ul>";
}
?>