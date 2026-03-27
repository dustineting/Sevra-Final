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

// Fetch Entry (Ensure it belongs to the logged-in user.)
$stmt = $pdo->prepare("SELECT * FROM reflections WHERE reflection_id = :reflection_id AND user_id = :user_id");
$stmt->execute([':reflection_id' => $reflection_id, ':user_id' => $user_id]);
$entry = $stmt->fetch();

if (!$entry) {
    header("Location: archives.php");
    exit();
}

// Format Date
date_default_timezone_set("Asia/Manila");
$ts = strtotime($entry['created_at']);
$formattedDate = date('l, jS \o\f F Y \a\t g:i A', $ts);

// Question Pool (Same seed logic so questions match what was shown.)
$allQuestions = [
    "What is one thing you're grateful for today?",
    "What was the most challenging part of your day, and how did you handle it?",
    "What emotion has been most present for you today? What do you think triggered it?",
    "Is there something you've been avoiding? What's holding you back?",
    "What's one small win you had today, no matter how minor?",
    "Who or what gave you energy today? Who or what drained it?",
    "What do you wish you had done differently today?",
    "What is something you're looking forward to, even in the smallest way?",
    "What would you tell a close friend if they were feeling exactly how you feel right now?",
    "What does your body or mind need most right now?"
];

$dateSeed = (int) date('Ymd', $ts);
mt_srand($dateSeed);
$keys = array_keys($allQuestions);
shuffle($keys);
$entryQuestions = array_slice($keys, 0, 3);

$answers = [
    $entry['answer_1'],
    $entry['answer_2'],
    $entry['answer_3'],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Reflection - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Navigation Header -->
    <?php $activePage = "archives";
    include("includes/header.php"); ?>

    <!-- Main Content -->
    <main class="dashboard-main">

        <!-- Top Row: Greeting + Clock -->
        <div class="dashboard-top">
            <div class="dashboard-greeting">
                <h1>Daily Reflection</h1>
                <p>Your reflections, saved in time.</p>
            </div>
            <div class="dashboard-clock">
                <img class="clock-icon" src="images/icon-clock.png" alt="Clock Icon" />
                <div class="clock-info">
                    <span class="clock-time" id="clockTime">12:00 AM</span>
                    <span class="clock-date" id="clockDate">Mon, 23rd of February, 2026</span>
                </div>
            </div>
        </div>

        <!-- View Card -->
        <div class="journal-card">

            <!-- Header: Title + Date -->
            <div class="view-header">
                <h2>Daily Reflection</h2>
                <div class="view-date">
                    <img src="images/icon-calendar.png" alt="Date" />
                    <?= $formattedDate ?>
                </div>
            </div>

            <!-- Q&A -->
            <div class="view-qa">
                <?php foreach ($entryQuestions as $i => $key): ?>
                    <?php if (!empty($answers[$i])): ?>
                        <div class="view-qa-item">
                            <div class="view-qa-question"><?= htmlspecialchars($allQuestions[$key]) ?></div>
                            <div class="view-qa-answer"><?= nl2br(htmlspecialchars($answers[$i])) ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Actions -->
            <div class="journal-actions">
                <button type="button" class="btn-submit" onclick="confirmDelete()">Delete Entry</button>
            </div>
        </div>

        <!-- Back Button -->
        <div style="display:flex; justify-content:center;">
            <a href="archives.php?type=reflection" class="btn-cancel">← Back to Archives</a>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="confirm-overlay" id="deleteModal">
        <div class="confirm-modal">
            <h3>Delete Entry</h3>
            <p>Are you sure you want to delete this reflection? This action cannot be undone.</p>
            <div class="confirm-modal-actions">
                <button class="btn-confirm-submit"
                    onclick="window.location.href='delete_reflection.php?id=<?= $reflection_id ?>'">Yes, Delete</button>
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Clock Widget Script -->
    <script src="js/clock.js"></script>
    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>