<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
date_default_timezone_set("Asia/Manila");
require_once("includes/database.php");

// Get Journal ID from URL
$journal_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$journal_id) {
    header("Location: archives.php");
    exit();
}

// Fetch Entry (Ensure it belongs to the logged-in user.)
$stmt = $pdo->prepare("SELECT * FROM journals WHERE journal_id = :journal_id AND user_id = :user_id");
$stmt->execute([':journal_id' => $journal_id, ':user_id' => $user_id]);
$entry = $stmt->fetch();

if (!$entry) {
    header("Location: archives.php");
    exit();
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $mood = $_POST['mood'] ?? '';
    $body = trim($_POST['body'] ?? '');

    $update = $pdo->prepare("
        UPDATE journals
        SET title = :title, mood = :mood, entry = :entry
        WHERE journal_id = :journal_id AND user_id = :user_id
    ");
    $update->execute([
        ':title' => $title,
        ':mood' => $mood,
        ':entry' => $body,
        ':journal_id' => $journal_id,
        ':user_id' => $user_id,
    ]);

    header("Location: view_journal.php?id=$journal_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Entry - Sevra</title>
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
                <h1>Edit Entry</h1>
                <p>Make changes to your journal entry.</p>
            </div>
            <div class="dashboard-clock">
                <img class="clock-icon" src="images/icon-clock.png" alt="Clock Icon" />
                <div class="clock-info">
                    <span class="clock-time" id="clockTime">12:00 AM</span>
                    <span class="clock-date" id="clockDate">Mon, 23rd of February, 2026</span>
                </div>
            </div>
        </div>

        <!-- Edit Card -->
        <div class="journal-card">
            <h2>Edit Journal Entry</h2>

            <form method="POST">

                <!-- Mood Selector -->
                <span class="mood-label">How were you feeling?</span>
                <div class="mood-options">
                    <button type="button" class="mood-option <?= $entry['mood'] === 'difficult' ? 'selected' : '' ?>"
                        data-mood="difficult" onclick="selectMood(this)">
                        <img src="images/mood-difficult.png" alt="Difficult" class="mood-icon-img" />
                        Difficult
                    </button>
                    <button type="button" class="mood-option <?= $entry['mood'] === 'okay' ? 'selected' : '' ?>"
                        data-mood="okay" onclick="selectMood(this)">
                        <img src="images/mood-okay.png" alt="Okay" class="mood-icon-img" />
                        Okay
                    </button>
                    <button type="button" class="mood-option <?= $entry['mood'] === 'good' ? 'selected' : '' ?>"
                        data-mood="good" onclick="selectMood(this)">
                        <img src="images/mood-good.png" alt="Good" class="mood-icon-img" />
                        Good
                    </button>
                    <button type="button" class="mood-option <?= $entry['mood'] === 'great' ? 'selected' : '' ?>"
                        data-mood="great" onclick="selectMood(this)">
                        <img src="images/mood-great.png" alt="Great" class="mood-icon-img" />
                        Great
                    </button>
                </div>
                <input type="hidden" name="mood" id="moodInput" value="<?= htmlspecialchars($entry['mood']) ?>" />

                <!-- Title -->
                <div class="field-group">
                    <label for="entryTitle">Title (Optional)</label>
                    <input type="text" id="entryTitle" name="title" value="<?= htmlspecialchars($entry['title']) ?>"
                        placeholder="Give your entry a title..." />
                </div>

                <!-- Body -->
                <div class="field-group">
                    <label for="entryBody">Entry</label>
                    <textarea id="entryBody" name="body"><?= htmlspecialchars($entry['entry']) ?></textarea>
                </div>

                <!-- Actions -->
                <div class="journal-actions">
                    <button type="submit" class="btn-submit">Save Changes</button>
                    <a href="view_journal.php?id=<?= $journal_id ?>" class="btn-cancel">Cancel</a>
                </div>

            </form>
        </div>
    </main>

    <!-- Clock Widget Script -->
    <script src="js/clock.js"></script>
    <script>
        function selectMood(el) {
            document.querySelectorAll('.mood-option').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('moodInput').value = el.dataset.mood;
        }
    </script>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>