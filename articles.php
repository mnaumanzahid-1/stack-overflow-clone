<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$user_id = $_SESSION['user_id'];
if (isset($_POST['title']) && isset($_POST['body'])) {
    $stmt = $conn->prepare("INSERT INTO articles (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $user_id, $_POST['title'], $_POST['body']);
    $stmt->execute();
    $stmt->close();
}
$res = $conn->query("SELECT * FROM articles WHERE user_id=$user_id ORDER BY created_at DESC");
echo "<h2>Your Articles</h2>";
?>
<form method="post">
    <input name="title" placeholder="Title" required><br>
    <textarea name="body" placeholder="Write your article..." required></textarea><br>
    <button type="submit">Submit Article</button>
</form>
<ul>
<?php while($row = $res->fetch_assoc()) { ?>
    <li>
        <b><?php echo htmlspecialchars($row['title']); ?></b><br>
        <div style="margin-left:20px"><?php echo nl2br(htmlspecialchars($row['body'])); ?></div>
        <small>Posted on <?php echo $row['created_at']; ?></small>
    </li>
<?php } ?>
</ul>