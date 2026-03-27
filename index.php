<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Partial Navigation -->
    <?php $activePage = "index"; ?>
    <nav>
        <div class="nav-left">
            <a href="index/about.php" <?= $activePage === 'about' ? 'class="active"' : '' ?>>About Us</a>
            <a href="index/contacts.php" <?= $activePage === 'contacts' ? 'class="active"' : '' ?>>Contact Us</a>
            <a href="index/psychiatrists.php" <?= $activePage === 'psychiatrists' ? 'class="active"' : '' ?>>Psychiatrists</a>
        </div>
        <div class="nav-logo"><a href="index.php">Sevra</a></div>
        <div class="nav-right">
            <a href="login.php" <?= $activePage === 'login' ? 'class="active"' : '' ?>>Log In</a>
            <a href="register.php" class="btn-signup <?= $activePage === 'register' ? 'class="active"' : '' ?>">Sign Up</a>
        </div>
    </nav>

    <!-- 2-Column Hero Section -->
    <section class="hero">
        <!-- Left Column -->
        <div class="hero-left">
            <h1>Rediscover yourself through every entry.</h1>
            <p>Sevra exists to provide a space for people who struggle to express themselves openly.
                It exists for those who feel like they have no one to talk to, or who are afraid of being judged when
                they share what's on their mind.
                Sevra aims to become a safe and welcoming environment where emotions can be acknowledged and validated.
            </p>
            <a href="login.php" class="btn-start">Let's get you started!</a>
        </div>

        <!-- Right Column (Hero Image) -->
        <div class="hero-right">
            <img src="images/placeholder.jpg" alt="Sevra Hero Image" />
        </div>
    </section>

    <!-- Partial Footer -->
    <footer>
        <div class="footer-logo">Sevra</div>
        <div class="footer-links">
            <a href="index/about.php">About Us</a>
            <a href="index/contacts.php">Contact Us</a>
            <a href="index/psychiatrists.php">Psychiatrists</a>
        </div>
        <div class="footer-copy">
            Copyright &copy;2025<br>Sevra. All Rights Reserved
        </div>
    </footer>
</body>

</html>