<?php
session_start();

$regions = [
    'Luzon' => [
        [
            'name' => 'Dr. Rowena Raymundo',
            'clinic' => 'Raymundo Psychiatric Clinic',
            'number' => '0968-264-3379',
            'location' => 'Baguio City, Benguet',
            'images' => '../images/rowena-raymundo.jpg',
        ],
        [
            'name' => 'Dr. Joseph Gene Ponio',
            'clinic' => 'St. Claire Psychiatric Homecare',
            'number' => '0918-925-0278',
            'location' => 'San Fernando, Pampanga',
            'images' => '../images/joseph-ponio.jpg',
        ],
        [
            'name' => 'Dr. Melencio M. Bautista',
            'clinic' => "Donna's Home Care Psychiatric Center",
            'number' => '(047) 612-1751',
            'location' => 'Malolos, Bulacan',
            'images' => '../images/melencio-bautista.jpg',
        ],
    ],
    'Visayas' => [
        [
            'name' => 'Dr. Fareda Fatima Flores',
            'clinic' => 'RecoveryHub Psychiatry Services',
            'number' => '(032) 344-2141',
            'location' => 'Cebu City, Cebu',
            'images' => '../images/fareda-flores.jpg',
        ],
        [
            'name' => 'Dr. Joyce Magallon-Fernandez',
            'clinic' => 'Psychiatric Services Clinic',
            'number' => '(034) 709-9500',
            'location' => 'Bacolod City, Negros Occidental',
            'images' => '../images/joyce-fernandez.jpg',
        ],
        [
            'name' => 'Dr. Benita Ponio',
            'clinic' => 'Private Psychiatric Practice',
            'number' => '0917-803-1198',
            'location' => 'Cebu City, Cebu',
            'images' => '../images/benita-ponio.jpg',
        ],
    ],
    'Mindanao' => [
        [
            'name' => 'Dr. Jose J. Coruna Sr.',
            'clinic' => 'Maria Reyna Xavier University Hospital Psychiatry Department',
            'number' => '0926-929-8708',
            'location' => 'Cagayan de Oro City',
            'images' => '../images/jose-coruna.jpg',
        ],
        [
            'name' => 'Dr. Radaza-Penaranda',
            'clinic' => 'Cagayan de Oro Medical Center Psychiatry Clinic',
            'number' => '0920-974-1148',
            'location' => 'Cagayan de Oro City',
            'images' => '../images/radaza-penaranda.jpg',
        ],
        [
            'name' => 'Dr. Go',
            'clinic' => 'Cagayan de Oro Medical Center Psychiatry Department',
            'number' => '0927-261-1038',
            'location' => 'Cagayan de Oro City',
            'images' => '../images/doctor-go.jpg',
        ],
    ],
];

$rowClasses = ['psychiatrists-row-right', 'psychiatrists-row-left', 'psychiatrists-row-right'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Psychiatrists - Sevra</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/psychiatrists.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Island+Moments&family=Lora:wght@400;700&family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <?php $activePage = "psychiatrists"; ?>
    <nav>
        <div class="nav-left">
            <a href="../index/about.php" <?= $activePage === 'about' ? 'class="active"' : '' ?>>About Us</a>
            <a href="../index/contacts.php" <?= $activePage === 'contacts' ? 'class="active"' : '' ?>>Contact Us</a>
            <a href="../index/psychiatrists.php" <?= $activePage === 'psychiatrists' ? 'class="active"' : '' ?>>Psychiatrists</a>
        </div>
        <div class="nav-logo"><a href="../index.php">Sevra</a></div>
        <div class="nav-right">
            <a href="../login.php" <?= $activePage === 'login' ? 'class="active"' : '' ?>>Log In</a>
            <a href="../register.php" class="btn-signup">Sign Up</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="psychiatrists-main">

        <?php $i = 0;
        foreach ($regions as $regionName => $psychiatrists): ?>
            <h2 class="psychiatrists-region-title"><?= $regionName ?></h2>

            <div class="psychiatrists-row <?= $rowClasses[$i] ?>">
                <?php foreach ($psychiatrists as $doc): ?>
                    <div class="psychiatrist-card">
                        <div class="psychiatrist-image">
                            <img src="<?= htmlspecialchars($doc['images']) ?>" alt="<?= htmlspecialchars($doc['name']) ?>" />
                        </div>
                        <div class="psychiatrist-info">
                            <span class="psychiatrist-name"><?= htmlspecialchars($doc['name']) ?></span>
                            <span class="psychiatrist-detail"><?= htmlspecialchars($doc['clinic']) ?></span>
                            <span class="psychiatrist-detail"><?= htmlspecialchars($doc['number']) ?></span>
                            <span class="psychiatrist-detail"><?= htmlspecialchars($doc['location']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $i++; endforeach; ?>
    </main>

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