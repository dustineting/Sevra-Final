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

// Fetch Entry (Ensure it belongs to the logged-in user.)
$stmt = $pdo->prepare("SELECT * FROM journals WHERE journal_id = :journal_id AND user_id = :user_id");
$stmt->execute([':journal_id' => $journal_id, ':user_id' => $user_id]);
$entry = $stmt->fetch();

if (!$entry) {
    header("Location: archives.php");
    exit();
}

// Format Date
$ts = strtotime($entry['created_at']);
$formattedDate = date('l, jS \o\f F Y \a\t g:i A', $ts);
date_default_timezone_set("Asia/Manila");

// Mood Display Map
$moodMap = [
    'difficult' => ['label' => 'Difficult', 'img' => 'images/mood-difficult.png'],
    'okay' => ['label' => 'Okay', 'img' => 'images/mood-okay.png'],
    'good' => ['label' => 'Good', 'img' => 'images/mood-good.png'],
    'great' => ['label' => 'Great', 'img' => 'images/mood-great.png'],
];
$mood = $moodMap[$entry['mood']] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($entry['title'] ?: 'Journal Entry') ?> - Sevra</title>
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
                <h1>Journal Entry</h1>
                <p>Your thoughts, saved in time.</p>
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

            <!-- Header: Title, Date, Mood -->
            <div class="view-header">
                <h2><?= htmlspecialchars($entry['title'] ?: 'Untitled') ?></h2>
                <div class="view-date">
                    <img src="images/icon-calendar.png" alt="Date" />
                    <?= $formattedDate ?>
                </div>
                <?php if ($mood): ?>
                    <div class="view-mood">
                        <span class="view-mood-label">Feeling</span>
                        <img src="<?= $mood['img'] ?>" alt="<?= $mood['label'] ?>" />
                        <span><?= $mood['label'] ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Entry Body -->
            <div class="view-body"><?= nl2br(htmlspecialchars($entry['entry'])) ?></div>

            <!-- Actions -->
            <div class="journal-actions">
                <a href="edit_journal.php?id=<?= $journal_id ?>" class="btn-submit"
                    style="text-align:center; text-decoration:none;">Edit Entry</a>
                <button type="button" class="btn-cancel" onclick="confirmDelete()">Delete Entry</button>
            </div>

        </div>

        <!-- Back Button -->
        <div style="display:flex; justify-content:center;">
            <a href="archives.php" class="btn-cancel">← Back to Archives</a>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="confirm-overlay" id="deleteModal">
        <div class="confirm-modal">
            <h3>Delete Entry</h3>
            <p>Are you sure you want to delete this entry? This action cannot be undone.</p>
            <div class="confirm-modal-actions">
                <button class="btn-confirm-submit"
                    onclick="window.location.href='delete_journal.php?id=<?= $journal_id ?>'">Yes, Delete</button>
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