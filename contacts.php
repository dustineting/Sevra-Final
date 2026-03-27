<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Sevra</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!-- Navigation Header -->
    <?php $activePage = "contacts";
    include("includes/header.php"); ?>

    <!-- Main Content -->
    <main class="contact-main">
        <div class="contact-card">

            <div class="contact-left">
                <h1>Contact Us</h1>
                <div class="contact-info">
                    <div class="contact-info-item">
                        <img src="images/icon-email.png" alt="Email" />
                        sevra@gmail.com
                    </div>
                </div>
            </div>

            <div class="contact-right">
                <form action="submit_contact.php" method="POST">
                    <div class="contact-form-row">
                        <div class="contact-field">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="first_name" placeholder="Maria" />
                        </div>
                        <div class="contact-field">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="last_name" placeholder="Cruz" />
                        </div>
                    </div>
                    <div class="contact-field contact-field-full">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="mariacruz@gmail.com" required />
                    </div>
                    <div class="contact-field contact-field-full">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Type your message here..."></textarea>
                    </div>
                    <div class="contact-submit-row">
                        <button type="submit" class="btn-contact-submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>
</body>

</html>