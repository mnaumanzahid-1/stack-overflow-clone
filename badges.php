<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT b.name, b.description, ub.awarded_at FROM user_badges ub JOIN badges b ON ub.badge_id = b.id WHERE ub.user_id=$user_id");
echo "<h2>Your Badges</h2>";
if ($res->num_rows === 0) {
    echo "No badges earned yet.";
} else {
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li><b>" . htmlspecialchars($row['name']) . "</b>: " . htmlspecialchars($row['description']) . " <small>(awarded at {$row['awarded_at']})</small></li>";
    }
    echo "</ul>";
}
?>