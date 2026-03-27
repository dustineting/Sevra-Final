<?php
session_start();
require_once("includes/database.php");

// Redirect if Already Logged In
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = $_SESSION['error'] ?? "";
$success = $_SESSION['success'] ?? "";
unset($_SESSION['error'], $_SESSION['success']);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: register.php");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("Location: register.php");
        exit();
    } elseif (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters.";
        header("Location: register.php");
        exit();
    } else {
        // Check if Username or Email Already Exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $_SESSION['error'] = "Username or email is already taken.";
            header("Location: register.php");
            exit();
        } else {
            // Hash Password and Insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);
            $_SESSION['success'] = "Account created! You can now log in.";
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Partial Navigation -->
    <?php $activePage = "register"; ?>
    <nav>
        <div class="nav-left">
            <a href="index/about.php" <?= $activePage === 'about' ? 'class="active"' : '' ?>>About Us</a>
            <a href="index/contacts.php" <?= $activePage === 'contacts' ? 'class="active"' : '' ?>>Contact Us</a>
            <a href="index/psychiatrists.php" <?= $activePage === 'psychiatrists' ? 'class="active"' : '' ?>>Psychiatrists</a>
        </div>
        <div class="nav-logo"><a href="index.php">Sevra</a></div>
        <div class="nav-right">
            <a href="login.php" <?= $activePage === 'login' ? 'class="active"' : '' ?>>Log In</a>
            <a href="register.php" class="btn-signup <?= $activePage === 'register' ? 'active' : '' ?>">Sign Up</a>
        </div>
    </nav>

    <!-- 2-Column Main Section -->
    <main class="login-main">
        <!-- Left: Image -->
        <div class="login-left">
            <img src="images/placeholder.jpg" alt="Sevra Hero Image" />
        </div>

        <!-- Right: Register Card -->
        <div class="login-right">
            <div class="login-card">
                <h1>Welcome to Sevra!</h1>

                <?php if (!empty($error)): ?>
                    <p class="error-msg">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <p class="success-msg">
                        <?= htmlspecialchars($success) ?>
                    </p>
                <?php endif; ?>

                <form method="POST" action="register.php">
                    <div class="input-group">
                        <input type="text" name="username" placeholder="Username" required />
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email" required />
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required />
                    </div>

                    <button type="submit" class="btn-login">Create Account</button>
                </form>

                <p class="register">
                    Already have an account? <a href="login.php">Log in here!</a>
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