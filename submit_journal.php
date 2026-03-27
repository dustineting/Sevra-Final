<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include Database
require_once("includes/database.php");

// Get Form Data
$user_id = $_SESSION['user_id'];
$mood = $_POST['mood'] ?? '';
$title = $_POST['title'] ?? null;
$entry = $_POST['body'] ?? null;

// Basic Validation
if (empty($mood)) {
    header("Location: journal.php?error=mood");
    exit();
}

// Insert into Database
try {
    $stmt = $pdo->prepare("INSERT INTO journals (user_id, mood, title, entry) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $mood, $title ?: null, $entry ?: null]);

    header("Location: journal.php?success=1");
    exit();
} catch (PDOException $e) {
    header("Location: journal.php?error=db");
    exit();
}
?>