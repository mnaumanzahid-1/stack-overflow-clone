<?php
$server_name = "localhost";
$db_name = "stackoverflow_clone"; // use actual name shown in InfinityFree
$user_name = "root";
$pass_word = "";  // your InfinityFree MySQL password
$port = 3306;

try {
  $dsn = "mysql:host=$server_name;port=$port;dbname=$db_name";
  $pdo = new PDO($dsn, $user_name, $pass_word);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>
