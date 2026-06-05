<?php
session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
if (isset($_POST['title']) && isset($_POST['body'])) {
    $stmt = $conn->prepare("INSERT INTO questions (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $_SESSION['user_id'], $_POST['title'], $_POST['body']);
    $stmt->execute();
    $stmt->close();
}
$result = $conn->query("SELECT q.id, q.title, u.username FROM questions q JOIN users u ON q.user_id=u.user_id ORDER BY q.created_at DESC");
?>
<h2>Ask a Question</h2>
<form method="post">
    <input name="title" placeholder="Title" required><br>
    <textarea name="body" placeholder="Your question..." required></textarea><br>
    <button type="submit">Submit</button>
</form>
<h2>Questions</h2>
<ul>
<?php while($row = $result->fetch_assoc()) { ?>
    <li>
        <a href="question_view.php?id=<?php echo $row['id']; ?>">
            <?php echo htmlspecialchars($row['title']); ?>
        </a> by <?php echo htmlspecialchars($row['username']); ?>
    </li>
<?php } ?>
</ul>