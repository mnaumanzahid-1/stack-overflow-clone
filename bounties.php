<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT b.*, q.title FROM bounties b JOIN questions q ON b.question_id=q.id WHERE b.user_id=$user_id");
echo "<h2>Your Bounties</h2>";
if ($res->num_rows === 0) {
    echo "You haven't placed any bounties.";
} else {
    echo "<ul>";
    while ($row = $res->fetch_assoc()) {
        echo "<li>Bounty of <b>{$row['amount']}</b> on question <a href='question_view.php?id={$row['question_id']}'>" . htmlspecialchars($row['title']) . "</a> (Placed: {$row['created_at']})</li>";
    }
    echo "</ul>";
}
?>