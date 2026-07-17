<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Elite Mechanics | Hollywood Car Workshop</title>
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

    <!-- Header -->
    <div class="page-header">
        <h1>Meet Our Elite Mechanics</h1>
        <p>Five legends. Zero compromises.</p>
    </div>

    <section class="mechanics-elite-grid">

        <!-- Dominic Toretto -->
        <div class="mechanic-elite-card">
            <img src="images/mechanics/dominic_toretto.jpeg" alt="Dominic Toretto">
            <div class="mechanic-content">
                <h3>Dominic Toretto</h3>
                <span class="role">Muscle Cars &amp; Nitrous Tuning</span>
                <p>Raw American horsepower. Classic V8 rebuilds, custom forced induction, and precision nitrous oxide injection systems.</p>
                <a href="index.php#appointment-form" class="btn btn-gold btn-block">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Walter White -->
        <div class="mechanic-elite-card">
            <img src="images/mechanics/Walter_White.jpeg" alt="Walter White">
            <div class="mechanic-content">
                <h3>Walter White</h3>
                <span class="role">Emissions &amp; Catalyst Chemistry</span>
                <p>Pure chemical engineering. Advanced fuel mixture manipulation, fluid degradation analysis, and optimized exhaust chemistry.</p>
                <a href="index.php#appointment-form" class="btn btn-gold btn-block">
                    Book Now
                </a>
            </div>
        </div>

        <!-- John Wick -->
        <div class="mechanic-elite-card">
            <img src="images/mechanics/John_Wick.jpeg" alt="John Wick">
            <div class="mechanic-content">
                <h3>John Wick</h3>
                <span class="role">Body Armor &amp; Structural Rigidity</span>
                <p>Tactical automotive defense. Reinforced steel paneling, bullet-resistant glass installation, and heavy impact chassis reinforcement.</p>
                <a href="index.php#appointment-form" class="btn btn-gold btn-block">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Bruce Wayne -->
        <div class="mechanic-elite-card">
            <img src="images/mechanics/Bruce_Wayne.jpeg" alt="Bruce Wayne">
            <div class="mechanic-content">
                <h3>Bruce Wayne</h3>
                <span class="role">Propulsion &amp; Stealth Systems</span>
                <p>Next-gen prototype tech. Radar-jamming electrical integration, thermal masking, and custom jet-turbine exhaust systems.</p>
                <a href="index.php#appointment-form" class="btn btn-gold btn-block">
                    Book Now
                </a>
            </div>
        </div>

        <!-- Pablo Escobar -->
        <div class="mechanic-elite-card">
            <img src="images/mechanics/Pablo_Escobar.jpeg" alt="Pablo Escobar">
            <div class="mechanic-content">
                <h3>Pablo Escobar</h3>
                <span class="role">Cargo Space &amp; Suspension Specialist</span>
                <p>Custom logistics engineering. Advanced hidden compartments, seamless chassis modifications, and reinforced heavy-duty suspension lifting.</p>
                <a href="index.php#appointment-form" class="btn btn-gold btn-block">
                    Book Now
                </a>
            </div>
        </div>

    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop.
    </footer>

</body>

</html>