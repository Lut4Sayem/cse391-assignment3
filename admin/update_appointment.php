<?php
require_once 'auth.php';
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$id               = $_POST['id'] ?? null;
$appointment_date = $_POST['appointment_date'] ?? null;
$mechanic_id      = $_POST['mechanic_id'] ?? null;

if (empty($id) || empty($appointment_date) || empty($mechanic_id)) {
    showError("All fields are required.");
}

/* Check mechanic capacity (exclude current appointment) */
$sql_check = "SELECT COUNT(*) AS total_slots 
              FROM appointments 
              WHERE mechanic_id = ? 
              AND appointment_date = ? 
              AND id != ?";

$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("isi", $mechanic_id, $appointment_date, $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['total_slots'] >= 4) {
    showError("This mechanic is fully booked on that date. Please choose another mechanic or date.");
}

$stmt_check->close();

/* Update */
$sql_update = "UPDATE appointments 
               SET appointment_date = ?, mechanic_id = ? 
               WHERE id = ?";

$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("sii", $appointment_date, $mechanic_id, $id);
$stmt_update->execute();
$stmt_update->close();

/* Redirect back */
header("Location: index.php");
exit();

/* ===== Styled Error Page ===== */
function showError($message)
{
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Error | Hollywood Car Workshop</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&family=Staatliches&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>

        <!-- Navbar -->
        <div class="navbar navbar-solid">
            <a href="../index.php" class="brand">
                <img src="../images/logo.png" alt="Logo" class="brand-logo">
                <span class="brand-text">Hollywood Car Workshop</span>
            </a>
            <div>
                <a href="../index.php">Home</a>
                <a href="index.php">Admin</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="page-content">

            <div class="error-container">
                <div class="error-card">
                    <div class="error-icon">⚠</div>
                    <h2>Update Failed</h2>
                    <p><?php echo htmlspecialchars($message); ?></p>
                    <a href="javascript:history.back()" class="btn btn-gold">
                        Go Back
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer>
            &copy; <?php echo date("Y"); ?> Hollywood Car Workshop.
        </footer>

    </body>

    </html>
<?php
    exit();
}
?>