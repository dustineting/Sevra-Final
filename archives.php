<?php
session_start();

// Redirect if Not Logged In
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Access Database
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
require_once("includes/database.php");

// Filters
$type = $_GET['type'] ?? 'journal';
$year = $_GET['year'] ?? 'all';
$search = trim($_GET['search'] ?? '');

// Build Query Based on Type
if ($type === 'reflection') {
    $query = "SELECT reflection_id AS id, NULL AS title, answer_1 AS preview, created_at FROM reflections WHERE user_id = :user_id";
    $params = [':user_id' => $user_id];
} else {
    $query = "SELECT journal_id AS id, title, entry AS preview, created_at FROM journals WHERE user_id = :user_id";
    $params = [':user_id' => $user_id];
}

if ($year !== 'all') {
    $query .= " AND YEAR(created_at) = :year";
    $params[':year'] = $year;
}

if ($search !== '') {
    if ($type === 'reflection') {
        $query .= " AND (answer_1 LIKE :search OR answer_2 LIKE :search OR answer_3 LIKE :search)";
    } else {
        $query .= " AND (title LIKE :search OR entry LIKE :search)";
    }
    $params[':search'] = '%' . $search . '%';
}

$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$entries = $stmt->fetchAll();

// Available Years
$yearStmt = $pdo->prepare(
    "SELECT DISTINCT YEAR(created_at) AS y FROM journals WHERE user_id = :uid
     UNION
     SELECT DISTINCT YEAR(created_at) AS y FROM reflections WHERE user_id = :uid2
     ORDER BY y DESC"
);
$yearStmt->execute([':uid' => $user_id, ':uid2' => $user_id]);
$years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);

// Ordinal Suffix for Date
function ordinal($n)
{
    $s = ['th', 'st', 'nd', 'rd'];
    $v = $n % 100;
    return $n . ($s[($v - 20) % 10] ?? $s[min($v, 3)]);
}

function formatDate($datetime)
{
    $ts = strtotime($datetime);
    return date('jS \o\f F, Y \a\t g:i A', $ts);
}

// Default Timezone
date_default_timezone_set("Asia/Manila");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Archives - Sevra</title>
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
    <main class="archives-main">

        <!-- Search + Filters -->
        <form method="GET" action="archives.php">
            <div class="archives-controls">
                <!-- Search -->
                <div class="archives-search">
                    <img src="images/icon-search.png" alt="Search" />
                    <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($search) ?>" />
                </div>

                <!-- Type Filter -->
                <select name="type" class="archives-select" onchange="this.form.submit()">
                    <option value="journal" <?= $type === 'journal' ? 'selected' : '' ?>>Journal</option>
                    <option value="reflection" <?= $type === 'reflection' ? 'selected' : '' ?>>Reflection</option>
                </select>

                <!-- Year Filter -->
                <select name="year" class="archives-select" onchange="this.form.submit()">
                    <option value="all" <?= $year === 'all' ? 'selected' : '' ?>>All Years</option>
                    <?php foreach ($years as $y): ?>
                        <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Hidden Search Submit on Enter -->
                <button type="submit" style="display:none;"></button>
            </div>
        </form>

        <!-- Entry Count -->
        <p class="archives-count"><?= count($entries) ?> <?= count($entries) === 1 ? 'Entry' : 'Entries' ?> Found</p>

        <!-- Entry Grid -->
        <div class="archives-grid">
            <?php if (empty($entries)): ?>
                <div class="archives-empty">No entries found.</div>
            <?php else: ?>
                <?php foreach ($entries as $entry):
                    $detailPage = $type === 'reflection'
                        ? "view_reflection.php?id={$entry['id']}"
                        : "view_journal.php?id={$entry['id']}";
                    $title = $type === 'reflection'
                        ? 'Daily Reflection'
                        : (trim($entry['title']) !== '' ? htmlspecialchars($entry['title']) : 'Untitled');
                    $preview = htmlspecialchars($entry['preview']);
                    $date = formatDate($entry['created_at']);
                    ?>
                    <a href="<?= $detailPage ?>" class="entry-card">
                        <div class="entry-card-title"><?= $title ?></div>
                        <div class="entry-card-date">
                            <img src="images/icon-calendar.png" alt="Date" />
                            <?= $date ?>
                        </div>
                        <div class="entry-card-preview"><?= $preview ?></div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>