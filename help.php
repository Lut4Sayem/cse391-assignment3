<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Help & Booking Rules | Hollywood Car Workshop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Navbar -->
    <div class="navbar navbar-solid">
        <a href="index.php" class="brand">
            <img src="images/logo.png" alt="Logo" class="brand-logo">
            <span class="brand-text">Hollywood Car Workshop</span>
        </a>
        <div>
            <a href="index.php">Home</a>
            <a href="mechanics.php">Mechanics</a>
            <a href="admin/index.php">Admin</a>
            <a href="help.php">Help</a>
        </div>
    </div>

    <div class="page-header">
        <h1>Help & Booking Rules</h1>
        <p>Everything you need to know before booking your appointment.</p>
    </div>

    <section class="faq-section">

        <div class="faq-item">
            <details>
                <summary>How do I book an appointment?</summary>
                <p>Fill in your name, phone number, and car license number on the homepage, then click "Continue Booking" to complete the rest of the form.</p>
            </details>
        </div>

        <div class="faq-item">
            <details>
                <summary>What information do I need to provide?</summary>
                <p>Client name, phone number, car license number, and car engine number are required. Address is optional.</p>
            </details>
        </div>

        <div class="faq-item">
            <details>
                <summary>Can I book multiple appointments with the same car?</summary>
                <p>No. A car (identified by its license number) can only have one appointment per date.</p>
            </details>
        </div>

        <div class="faq-item">
            <details>
                <summary>What happens if my chosen mechanic is fully booked?</summary>
                <p>Mechanics who are fully booked for the selected date will appear disabled and cannot be selected.</p>
            </details>
        </div>

        <div class="faq-item">
            <details>
                <summary>How many appointments can a mechanic take per day?</summary>
                <p>Each mechanic can handle a maximum of 4 appointments per day.</p>
            </details>
        </div>

    </section>
    <div class="back-link">
        <a href="index.php" class="btn btn-gold">← Back to Booking</a>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop. All rights reserved.
    </footer>

</body>

</html>