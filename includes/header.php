<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="journal.php" <?= $activePage === 'journal' ? 'class="active"' : '' ?>>Journal</a>
            <a href="psychiatrists.php" <?= $activePage === 'psychiatrists' ? 'class="active"' : '' ?>>Psychiatrists</a>
            <a href="archives.php" <?= $activePage === 'archives' ? 'class="active"' : '' ?>>Archives</a>
        </div>
        <div class="nav-logo"><a href="dashboard.php">Sevra</a></div>
        <div class="nav-right">
            <a href="dashboard.php" <?= $activePage === 'dashboard' ? 'class="active"' : '' ?>>Dashboard</a>
            <a href="about.php" <?= $activePage === 'about' ? 'class="active"' : '' ?>>About Us</a>
            <a href="contacts.php" <?= $activePage === 'contacts' ? 'class="active"' : '' ?>>Contact Us</a>
        </div>
    </nav>
</body>

</html>