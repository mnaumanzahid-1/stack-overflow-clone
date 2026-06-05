<?php
session_start();
include 'header.php';
if (!isset($_GET['id'])) die('No question specified');
$conn = new mysqli('localhost', 'root', '', 'stackoverflow_clone');
$qid = intval($_GET['id']);
$q = $conn->query("SELECT q.*, u.username FROM questions q JOIN users u ON q.user_id=u.user_id WHERE q.id=$qid")->fetch_assoc();
if (!$q) die('Question not found');
if (isset($_POST['body']) && isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("INSERT INTO answers (question_id, user_id, body) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $qid, $_SESSION['user_id'], $_POST['body']);
    $stmt->execute();
    $stmt->close();
}
$answers = $conn->query("SELECT a.*, u.username FROM answers a JOIN users u ON a.user_id=u.user_id WHERE a.question_id=$qid ORDER BY a.created_at ASC");
?>
<h2><?php echo htmlspecialchars($q['title']); ?></h2>
<p><?php echo nl2br(htmlspecialchars($q['body'])); ?></p>
<small>by <?php echo htmlspecialchars($q['username']); ?></small>
<hr>
<h3>Answers</h3>
<ul>
<?php while($a = $answers->fetch_assoc()) { ?>
    <li>
        <?php echo nl2br(htmlspecialchars($a['body'])); ?>
        <br>
        <small>by <?php echo htmlspecialchars($a['username']); ?></small>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $a['user_id']) { ?>
            | <a href="answer_edit.php?id=<?php echo $a['id']; ?>">Edit/Delete</a>
        <?php } ?>
    </li>
<?php } ?>
</ul>
<?php if (isset($_SESSION['user_id'])) { ?>
<h4>Your Answer</h4>
<form method="post">
    <textarea name="body" required></textarea><br>
    <button type="submit">Post Answer</button>
</form>
<?php } ?>