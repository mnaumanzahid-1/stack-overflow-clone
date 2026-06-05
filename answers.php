<?php
session_start();
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once('connect.php');

// Fetch all answers by this user, with their question's title
$stmt = $pdo->prepare("
    SELECT a.id AS answer_id, a.body, a.created_at, q.id AS question_id, q.title AS question_title
    FROM answers a
    JOIN questions q ON a.question_id = q.id
    WHERE a.user_id = ?
    ORDER BY a.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Answers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>My Answers</h2>
        <?php if (empty($answers)): ?>
            <div class="empty-state">You have not answered any questions.</div>
        <?php else: ?>
            <ul class="answer-list">
                <?php foreach ($answers as $answer): ?>
                    <li>
                        <strong>On: <a href="question_view.php?id=<?= $answer['question_id'] ?>">
                            <?= htmlspecialchars($answer['question_title']) ?>
                        </a></strong>
                        <div><?= nl2br(htmlspecialchars($answer['body'])) ?></div>
                        <div class="meta"><?= date('Y-m-d', strtotime($answer['created_at'])) ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="profile.php">Back to profile</a>
    </div>
</body>
</html>