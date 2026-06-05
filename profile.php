<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once('connect.php');

// Fetch user info
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found!");
}

// Calculate member duration
$createdAt = new DateTime($user['created_at']);
$now = new DateTime();
$memberFor = $now->diff($createdAt)->format('%a days');

// You can replace these with real calculations if you wish
$lastSeen = "recently";
$visitedDays = "N/A";

// Fetch user's questions
$questionsStmt = $pdo->prepare("SELECT id, title, created_at FROM questions WHERE user_id = ? ORDER BY created_at DESC");
$questionsStmt->execute([$_SESSION['user_id']]);
$questions = $questionsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user's answers and their related question titles
$answersStmt = $pdo->prepare("
    SELECT a.id, a.body, a.created_at, q.id AS question_id, q.title AS question_title 
    FROM answers a 
    JOIN questions q ON a.question_id = q.id 
    WHERE a.user_id = ? 
    ORDER BY a.created_at DESC
");
$answersStmt->execute([$_SESSION['user_id']]);
$answers = $answersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($user['username']) ?> - Stack Overflow Clone</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar Navigation -->
        <aside class="profile-sidebar">
            <div class="profile-card">
                <ul class="nav-menu">
                     <li><a href="index.php">Home</a></li>
                    <li><a href="summary.php">Summary</a></li>
                    <li><a href="answers.php">Answers</a></li>
                    <li><a href="questions.php">Questions</a></li>
                    <li><a href="tags.php">Tags</a></li>
                    <li><a href="articles.php">Articles</a></li>
                    <li><a href="badges.php">Badges</a></li>
                    <li><a href="following.php">Following</a></li>
                    <li><a href="bounties.php">Bounties</a></li>
                    <li><a href="reputation.php">Reputation</a></li>
                    <li><a href="actions.php">All actions</a></li>
                    <li><a href="responses.php">Responses</a></li>
                    <li><a href="votes.php">Votes</a></li>
                </ul>
            </div>
            <div class="profile-card">
                <h3>Accounts</h3>
                <ul class="nav-menu">
                    <li><strong>Stack Overflow</strong></li>
                </ul>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="profile-main">
            <div class="profile-header">
                <div class="username-container">
                    <h1><?= htmlspecialchars($user['username']) ?></h1>
                    <div class="header-actions">
                        <a href="logout.php" class="logout-btn">
                            <span class="logout-icon">⎋</span> Log out
                        </a>
                    </div>
                </div>
                <div class="profile-meta">
                    Member for <?= htmlspecialchars($memberFor) ?><br>
                    Last seen <?= htmlspecialchars($lastSeen) ?><br>
                    Visited <?= htmlspecialchars($visitedDays) ?>
                </div>
            </div>
            
            <!-- Summary Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Summary</h2>
                    <p><strong>Reputation is how the community thanks you</strong></p>
                    <p>When users upvote your helpful posts, you'll earn reputation and unlock new privileges.</p>
                    <p><a href="#">Learn more about reputation and privileges</a></p>
                </div>
            </section>
            
            <!-- Answers Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Answers</h2>
                    <?php if (empty($answers)): ?>
                        <div class="empty-state">You have not answered any questions</div>
                    <?php else: ?>
                        <ul>
                        <?php foreach ($answers as $a): ?>
                            <li>
                                Answered 
                                <a href="question_view.php?id=<?= $a['question_id'] ?>">
                                    <?= htmlspecialchars($a['question_title']) ?>
                                </a>
                                <span class="meta">(<?= date('Y-m-d', strtotime($a['created_at'])) ?>)</span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
            
            <!-- Questions Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Questions</h2>
                    <?php if (empty($questions)): ?>
                        <div class="empty-state">You have not asked any questions</div>
                    <?php else: ?>
                        <ul>
                        <?php foreach ($questions as $q): ?>
                            <li>
                                <a href="question_view.php?id=<?= $q['id'] ?>">
                                    <?= htmlspecialchars($q['title']) ?>
                                </a>
                                <span class="meta">(<?= date('Y-m-d', strtotime($q['created_at'])) ?>)</span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
          
            <!-- Tags Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Tags</h2>
                    <div class="empty-state">You have not participated in any tags</div>
                </div>
            </section>
            
            
            <!-- Badges Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Badges</h2>
                    <div class="empty-state">You have not earned any badges</div>
                </div>
            </section>
            
            <!-- Following Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Followed posts</h2>
                    <div class="empty-state">You are not following any posts</div>
                </div>
            </section>
            
            <!-- Bounties Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Active bounties (0)</h2>
                    <div class="empty-state">You have no active bounties</div>
                </div>
            </section>
            
            <!-- Articles Section -->
            <section class="profile-section">
                <div class="profile-card">
                    <h2>Articles</h2>
                    <div class="empty-state">You have no active articles</div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>