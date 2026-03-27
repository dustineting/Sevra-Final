<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

require_once("includes/database.php");

// Get Journal ID from URL
$journal_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$journal_id) {
    header("Location: archives.php");
    exit();
}

// Delete Entry (Ensure it belongs to the logged-in user.)
$stmt = $pdo->prepare("DELETE FROM journals WHERE journal_id = :journal_id AND user_id = :user_id");
$stmt->execute([':journal_id' => $journal_id, ':user_id' => $user_id]);

header("Location: archives.php");
exit();
?>