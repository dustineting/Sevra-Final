<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

require_once("includes/database.php");

// Get Reflection ID from URL
$reflection_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$reflection_id) {
    header("Location: archives.php");
    exit();
}

// Delete Entry (Ensure it belongs to the logged-in user.)
$stmt = $pdo->prepare("DELETE FROM reflections WHERE reflection_id = :reflection_id AND user_id = :user_id");
$stmt->execute([':reflection_id' => $reflection_id, ':user_id' => $user_id]);

header("Location: archives.php?type=reflection");
exit();