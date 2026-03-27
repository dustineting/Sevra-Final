<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - Sevra</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Partial Navigation -->
    <?php $activePage = "about"; ?>
    <nav>
        <div class="nav-left">
            <a href="../index/about.php" <?= $activePage === 'about' ? 'class="active"' : '' ?>>About Us</a>
            <a href="../index/contacts.php" <?= $activePage === 'contacts' ? 'class="active"' : '' ?>>Contact Us</a>
            <a href="../index/psychiatrists.php" <?= $activePage === 'psychiatrists' ? 'class="active"' : '' ?>>Psychiatrists</a>
        </div>
        <div class="nav-logo"><a href="../index.php">Sevra</a></div>
        <div class="nav-right">
            <a href="../login.php" <?= $activePage === 'login' ? 'class="active"' : '' ?>>Log In</a>
            <a href="../register.php" class="btn-signup <?= $activePage === 'register' ? 'class="active"' : '' ?>">Sign
                Up</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="about-main">
        <!-- Our Mission -->
        <div class="about-section">
            <h2>Our Mission</h2>
            <div class="about-card">
                To provide a space for people who struggle to express themselves openly.
                It exists for those who feel like they have no one to talk to, or who are afraid of being judged when
                they share what's on their mind.
                Sevra aims to become a safe and welcoming environment where emotions can be acknowledged and validated.
            </div>
        </div>

        <!-- Core Values -->
        <div class="about-section">
            <h2>Core Values</h2>
            <div class="core-values-grid">
                <div class="value-card">
                    <img src="../images/value-compassion.png" alt="Compassion" class="value-icon" />
                    <div class="value-text">
                        <h3>Compassion First</h3>
                        <p>We believe in creating a safe, judgment-free space where every individual feels heard and
                            supported.</p>
                    </div>
                </div>
                <div class="value-card">
                    <img src="../images/value-privacy.png" alt="Privacy" class="value-icon" />
                    <div class="value-text">
                        <h3>Privacy & Security</h3>
                        <p>Your thoughts are sacred. We prioritize the security and confidentiality of your journal
                            entries.</p>
                    </div>
                </div>
                <div class="value-card">
                    <img src="../images/value-growth.png" alt="Growth" class="value-icon" />
                    <div class="value-text">
                        <h3>Personal Growth</h3>
                        <p>We empower you to discover insights, track patterns, and grow through mindful reflection.</p>
                    </div>
                </div>
                <div class="value-card">
                    <img src="../images/value-community.png" alt="Community" class="value-icon" />
                    <div class="value-text">
                        <h3>Community Support</h3>
                        <p>Connect with professional resources and build a support network for your mental wellness.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story -->
        <div class="about-section">
            <h2>Our Story</h2>
            <div class="about-card">
                Sevra was created from something personal.
                As a group, we didn't just want to build a website for compliance but we wanted to build something that
                has real meaning.
                The idea of Sevra came from the reality that there are people, including us, who sometimes struggle to
                open up to other people.
                Not everyone feels comfortable expressing their thoughts and emotions to a “living” person.
                Sometimes, it's easier to stay quiet. Sometimes, it feels safer to keep everything inside.
                <br><br>
                Sevra was born from that feeling.
                It was created for individuals who feel alone, unheard, or misunderstood.
                The website serves as a safe digital space where users can feel seen without the pressure of judgment.
                In many ways, Sevra reflects what we personally experience, especially the feeling of isolation that can
                happen even when you're surrounded by people.
                <br><br>
                Building Sevra was emotional for us because it wasn't just about design and coding.
                It was about translating a feeling into a platform.
                Every section, every feature, and every detail was carefully thought of with one goal in mind: to make
                users feel like they are not alone.
                The website represents comfort, understanding, and quiet support for those who find it hard to open up
                in real life.
            </div>
        </div>

        <!-- Join Our Community -->
        <div class="about-section">
            <div class="community-card">
                <h2>Join Our Community</h2>
                <p>Start your journey toward better mental wellness today. Your story matters, and we're here to support
                    you every step of the way.</p>
                <div class="community-buttons">
                    <a href="../register.php" class="btn-community filled">Start Journaling</a>
                    <a href="../index/psychiatrists.php" class="btn-community outline">Connect with a Psychiatrist</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Partial Footer -->
    <footer>
        <div class="footer-logo">Sevra</div>
        <div class="footer-links">
            <a href="../index/about.php">About Us</a>
            <a href="../index/contacts.php">Contact Us</a>
            <a href="../index/psychiatrists.php">Psychiatrists</a>
        </div>
        <div class="footer-copy">
            Copyright &copy;2025<br>Sevra. All Rights Reserved
        </div>
    </footer>
</body>

</html>