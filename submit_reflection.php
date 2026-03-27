<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include Database
require_once("includes/database.php");

$user_id = $_SESSION['user_id'];
$answers = $_POST['answers'] ?? [];

// Ensures Exactly 3 Answers
$answer_1 = isset($answers[0]) ? trim($answers[0]) : '';
$answer_2 = isset($answers[1]) ? trim($answers[1]) : '';
$answer_3 = isset($answers[2]) ? trim($answers[2]) : '';

// Requires One Answer
if (empty($answer_1) && empty($answer_2) && empty($answer_3)) {
    header("Location: reflection.php?error=empty");
    exit();
}

// Insert into Database
try {
    $stmt = $pdo->prepare("
        INSERT INTO reflections (user_id, answer_1, answer_2, answer_3)
        VALUES (:user_id, :answer_1, :answer_2, :answer_3)
    ");

    $stmt->execute([
        ':user_id' => $user_id,
        ':answer_1' => $answer_1,
        ':answer_2' => $answer_2,
        ':answer_3' => $answer_3,
    ]);

    header("Location: reflection.php?success=1");
    exit();

} catch (PDOException $e) {
    header("Location: reflection.php?error=db");
    exit();
}
?>