<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("includes/database.php");
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Default Timezone
date_default_timezone_set("Asia/Manila");

// Daily Reflection Checker (Check if user already submitted a reflection today.)
$today = date('Y-m-d');
$checkStmt = $pdo->prepare("SELECT reflection_id FROM reflections WHERE user_id = :user_id AND DATE(created_at) = :today LIMIT 1");
$checkStmt->execute([':user_id' => $user_id, ':today' => $today]);
$alreadyReflected = $checkStmt->fetch();

// Question Pool (10 Questions)
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

// Shuffle Questions (Seed randomness by date so questions stay consistent per day.)
$dateSeed = (int) date('Ymd');
mt_srand($dateSeed);
$keys = array_keys($allQuestions);
shuffle($keys);
$todayQuestions = array_slice($keys, 0, 3);
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
    <?php $activePage = "reflection";
    include("includes/header.php"); ?>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Top Row: Greeting + Clock -->
        <div class="dashboard-top">
            <div class="dashboard-greeting">
                <h1><?= htmlspecialchars($username ?? 'User') ?>'s Daily Reflection</h1>
                <p>Answer today's prompts and explore what's on your mind.</p>
            </div>
            <div class="dashboard-clock">
                <img class="clock-icon" src="images/icon-clock.png" alt="Clock Icon" />
                <div class="clock-info">
                    <span class="clock-time" id="clockTime">12:00 AM</span>
                    <span class="clock-date" id="clockDate">Mon, 23rd of February, 2026</span>
                </div>
            </div>
        </div>

        <!-- Daily Reflection Card -->
        <div class="journal-card">
            <h2>Today's Reflection</h2>
            <p class="entry-date" id="entryDate">Monday, 23rd of February, 2026</p>

            <?php if ($alreadyReflected): ?>
                <!-- Already Reflected Notice -->
                <div class="reflection-done">
                    <img src="images/mood-great.png" alt="Done" />
                    <h3>You've already reflected today!</h3>
                    <p>You've completed your daily reflection. Come back tomorrow for a new set of prompts.</p>
                    <div class="reflection-done-actions">
                        <a href="archives.php?type=reflection" class="btn-submit"
                            style="text-decoration:none; text-align:center;">View in Archives</a>
                        <a href="dashboard.php" class="btn-cancel">Back to Dashboard</a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Reflection Form -->
                <form action="submit_reflection.php" method="POST">

                    <?php foreach ($todayQuestions as $i => $key): ?>
                        <div class="field-group">
                            <label for="answer_<?= $i ?>"><?= htmlspecialchars($allQuestions[$key]) ?></label>
                            <textarea id="answer_<?= $i ?>" name="answers[]"
                                placeholder="Write your thoughts here..."></textarea>
                            <input type="hidden" name="questions[]" value="<?= htmlspecialchars($allQuestions[$key]) ?>" />
                        </div>
                    <?php endforeach; ?>

                    <!-- Actions -->
                    <div class="journal-actions">
                        <button type="submit" class="btn-submit">Submit Entry</button>
                        <a href="dashboard.php" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <!-- Clock Widget Script -->
    <script src="js/clock.js"></script>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>