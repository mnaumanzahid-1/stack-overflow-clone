    <?php
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>StackOverflow Clone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="container">
    <h1>StackOverflow Clone</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
      <span>Welcome, <b><?=htmlspecialchars($_SESSION['username']??'User');?></b></span>
    <?php else: ?>
      <a href="login.php" style="color:#fff;">Login</a>
    <?php endif; ?>
  </div>
</header>
<nav>
  <ul>
    <li><a href="index.php" <?=($current=='index.php')?'class="active"':'';?>>Home</a></li>
    <li><a href="questions.php" <?=($current=='questions.php')?'class="active"':'';?>>Questions</a></li>
    <li><a href="answers.php" <?=($current=='answers.php')?'class="active"':'';?>>Answers</a></li>
    <li><a href="tags.php" <?=($current=='tags.php')?'class="active"':'';?>>Tags</a></li>
    <li><a href="articles.php" <?=($current=='articles.php')?'class="active"':'';?>>Articles</a></li>
    <li><a href="profile.php" <?=($current=='profile.php')?'class="active"':'';?>>Profile</a></li>
    <li><a href="badges.php" <?=($current=='badges.php')?'class="active"':'';?>>Badges</a></li>
    <li><a href="bounties.php" <?=($current=='bounties.php')?'class="active"':'';?>>Bounties</a></li>
    <li><a href="reputation.php" <?=($current=='reputation.php')?'class="active"':'';?>>Reputation</a></li>
    <li><a href="jokes.php" <?=($current=='jokes.php')?'class="active"':'';?>>Jokes</a></li>
    <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="logout.php">Logout</a></li>
    <?php endif; ?>
  </ul>
</nav>
<div class="container">