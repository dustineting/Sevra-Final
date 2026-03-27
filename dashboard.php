<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Access Database for Stats Widgets
require_once("includes/database.php");
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Total Entries
$stmt = $pdo->prepare("SELECT COUNT(*) FROM journals WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_entries = $stmt->fetchColumn();

// This Week Entries
$stmt = $pdo->prepare("SELECT COUNT(*) FROM journals WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
$stmt->execute([$user_id]);
$week_entries = $stmt->fetchColumn();

// Default Timezone
date_default_timezone_set("Asia/Manila");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Navigation Header -->
    <?php $activePage = "dashboard";
    include("includes/header.php"); ?>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Top Row: Greeting + Clock -->
        <div class="dashboard-top">
            <div class="dashboard-greeting">
                <h1>Welcome back, <?= htmlspecialchars($username ?? 'User') ?>!</h1>
                <p>Track your thoughts, emotions, and personal growth in a safe and mindful space.</p>
            </div>
            <div class="dashboard-clock">
                <img class="clock-icon" src="images/icon-clock.png" alt="Clock Icon" />
                <div class="clock-info">
                    <span class="clock-time" id="clockTime">12:00 AM</span>
                    <span class="clock-date" id="clockDate">Mon, 23rd of February, 2026</span>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-text">
                    <span class="stat-title">Total Entries</span>
                    <span class="stat-desc">Your all time journal entries.</span>
                </div>
                <span class="stat-number"><?= $total_entries ?></span>
            </div>
            <div class="stat-card">
                <div class="stat-text">
                    <span class="stat-title">This Week</span>
                    <span class="stat-desc">Your entries in the last 7 days.</span>
                </div>
                <span class="stat-number"><?= $week_entries ?></span>
            </div>
        </div>

        <!-- Action Buttons Row -->
        <div class="dashboard-actions">
            <a href="journal.php" class="action-card">
                <span class="action-dot"></span>
                <span class="action-label">Start Writing</span>
            </a>
            <a href="reflection.php" class="action-card">
                <span class="action-dot"></span>
                <span class="action-label">Daily Reflection</span>
            </a>
        </div>

        <!-- Emergency Hotlines -->
        <div class="dashboard-hotlines">
            <h2>Emergency Hotlines</h2>
            <p>If you or someone you know needs immediate support, please reach out to these hotlines:</p>
            <ul>
                <li><strong>National Center for Mental Health (NCMH):</strong> 1553 (24/7)</li>
                <li><strong>In Touch Crisis Line:</strong> (02) 8893-7603 | 0917-800-1123</li>
                <li><strong>Hopeline Philippines:</strong> (02) 8804-4673 | 0917-558-4673</li>
                <li><strong>Emergency (Police / Ambulance):</strong> 911</li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="dashboard-logout">
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </main>

    <!-- Clock Widget Script -->
    <script src="js/clock.js"></script>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>