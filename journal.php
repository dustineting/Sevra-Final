<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Default Timezone
date_default_timezone_set("Asia/Manila");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Journal - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Navigation Header -->
    <?php $activePage = "journal";
    include("includes/header.php"); ?>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Top Row: Greeting + Clock -->
        <div class="dashboard-top">
            <div class="dashboard-greeting">
                <h1><?= htmlspecialchars($username ?? 'User') ?>'s Journal</h1>
                <p>Express your thoughts and feelings in a safe space.</p>
            </div>
            <div class="dashboard-clock">
                <img class="clock-icon" src="images/icon-clock.png" alt="Clock Icon" />
                <div class="clock-info">
                    <span class="clock-time" id="clockTime">12:00 AM</span>
                    <span class="clock-date" id="clockDate">Mon, 23rd of February, 2026</span>
                </div>
            </div>
        </div>

        <!-- Journal Entry Card -->
        <div class="journal-card">
            <h2>Today's Reflection</h2>
            <p class="entry-date" id="entryDate">Monday, 23rd of February, 2026</p>

            <form id="journalForm" action="submit_journal.php" method="POST">

                <!-- Mood Selector -->
                <span class="mood-label">How are you feeling today, <?= htmlspecialchars($username ?? 'User') ?>?</span>
                <div class="mood-options">
                    <button type="button" class="mood-option" data-mood="difficult" onclick="selectMood(this)">
                        <img src="images/mood-difficult.png" alt="Difficult" class="mood-icon-img" />
                        Difficult
                    </button>
                    <button type="button" class="mood-option" data-mood="okay" onclick="selectMood(this)">
                        <img src="images/mood-okay.png" alt="Okay" class="mood-icon-img" />
                        Okay
                    </button>
                    <button type="button" class="mood-option" data-mood="good" onclick="selectMood(this)">
                        <img src="images/mood-good.png" alt="Good" class="mood-icon-img" />
                        Good
                    </button>
                    <button type="button" class="mood-option" data-mood="great" onclick="selectMood(this)">
                        <img src="images/mood-great.png" alt="Great" class="mood-icon-img" />
                        Great
                    </button>
                </div>
                <input type="hidden" name="mood" id="moodInput" value="" />

                <!-- Title -->
                <div class="field-group">
                    <label for="entryTitle">Title (Optional)</label>
                    <input type="text" id="entryTitle" name="title" placeholder="Give your entry a title..." />
                </div>

                <!-- Body -->
                <div class="field-group">
                    <label for="entryBody">What's on your mind, <?= htmlspecialchars($username ?? 'User') ?>?</label>
                    <textarea id="entryBody" name="body" placeholder="Start writing here..."></textarea>
                </div>

                <!-- Actions -->
                <div class="journal-actions">
                    <button type="button" class="btn-submit" onclick="openConfirm()">Submit Entry</button>
                    <a href="dashboard.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Submit Confirmation Modal -->
    <div class="confirm-overlay" id="confirmModal">
        <div class="confirm-modal">
            <h3>Submit Entry</h3>
            <p>Are you ready to save this journal entry? You can always edit it later from the archives.</p>
            <div class="confirm-modal-actions">
                <button class="btn-confirm-submit" onclick="document.getElementById('journalForm').submit()">Yes, Submit</button>
                <button class="btn-cancel" onclick="closeConfirm()">Go Back</button>
            </div>
        </div>
    </div>

    <!-- Clock Widget Script -->
    <script src="js/clock.js"></script>
    <script>
        // Mood Selection
        function selectMood(el) {
            document.querySelectorAll('.mood-option').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('moodInput').value = el.dataset.mood;
        }

        function openConfirm() {
            document.getElementById('confirmModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirm() {
            document.getElementById('confirmModal').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>