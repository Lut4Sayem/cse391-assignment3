<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, go to admin dashboard
if (!empty($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

$error = "";

// Change these two (quick setup)
$ADMIN_USERNAME = "admin";
$ADMIN_PASSWORD = "hollywood123"; // change this before submission

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    // Simple check
    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login | Hollywood Car Workshop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <div class="navbar navbar-solid">
        <a href="../index.php" class="brand">
            <img src="../images/logo.png" alt="Logo" class="brand-logo">
            <span class="brand-text">Hollywood Car Workshop</span>
        </a>
        <div>
            <a href="../index.php">Home</a>
            <a href="../mechanics.php">Mechanics</a>
            <a href="../help.php">Help</a>
        </div>
    </div>

    <div class="page-content">
        <div class="page-header">
            <h1>Admin Login</h1>
            <p>Authorized access only</p>
        </div>

        <div class="login-container">
            <div class="form-card">
                <h3>Sign In</h3>

                <?php if ($error): ?>
                    <div class="form-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-gold btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop.
    </footer>

</body>

</html>