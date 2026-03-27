<?php
session_start();
require_once("includes/database.php");

// Redirect if Already Logged In
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);

// Handle Login Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($input) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: login.php");
        exit();
    } else {
        // Check by Username or Email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$input, $input]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set Session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Set Session
            $_SESSION['error'] = "Invalid username/email or password.";
            header("Location: login.php");
            exit();
        }
    }
}

// Random Greeting Header
$greetings = [
    "Hello again, dear!",
    "How are you?",
    "Nice to see you again!",
    "Welcome back!",
    "We missed you!"
];
$random = $greetings[array_rand($greetings)];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Partial Navigation -->
    <?php $activePage = "login"; ?>
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

    <!-- 2-Column Main Section -->
    <main class="login-main">
        <!-- Left: Image -->
        <div class="login-left">
            <img src="images/placeholder.jpg" alt="Sevra Hero Image" />
        </div>

        <!-- Right: Login Card -->
        <div class="login-right">
            <div class="login-card">
                <h1><?= htmlspecialchars($random) ?></h1>

                <?php if (!empty($error)): ?>
                    <p class="error-msg"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="input-group">
                        <input type="text" name="username" placeholder="Username/Email" required />
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required />
                    </div>

                    <a href="#" class="forgot">Forgot Password?</a>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="register">
                    Don't have an account? <a href="register.php">Create one here!</a>
                </p>
            </div>
        </div>
    </main>

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