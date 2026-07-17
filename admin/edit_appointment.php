<?php
include '../db.php';

// Get appointment ID safely
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch appointment
$sql = "SELECT * FROM appointments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    header("Location: index.php");
    exit();
}

// Fetch mechanics
$mechanics_result = $conn->query("SELECT id, name FROM mechanics");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Appointment | Hollywood Car Workshop</title>
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
            <a href="../mechanics.php">Mechanics</a>
            <a href="index.php">Admin</a>
            <a href="../help.php">Help</a>
        </div>
    </div>

    <!-- Header -->
    <div class="page-content">
        <div class="page-header">
            <h1>Edit Appointment</h1>
            <p>Modify vehicle assignment details</p>
        </div>

        <div class="edit-container">

            <!-- Client Info Card -->
            <div class="client-info-card">
                <h3>Client Information</h3>

                <div class="info-row">
                    <span class="info-label">Client Name</span>
                    <span><?php echo htmlspecialchars($appointment['client_name']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span><?php echo htmlspecialchars($appointment['phone']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Car License</span>
                    <span><?php echo htmlspecialchars($appointment['car_license']); ?></span>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="form-card">
                <h3>Update Assignment</h3>

                <form action="update_appointment.php" method="POST">

                    <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">

                    <div class="form-group">
                        <label>Appointment Date</label>
                        <input
                            type="date"
                            name="appointment_date"
                            value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Assign Mechanic</label>
                        <select name="mechanic_id" required>
                            <?php
                            while ($mech = $mechanics_result->fetch_assoc()) {
                                $selected = ($mech['id'] == $appointment['mechanic_id']) ? "selected" : "";
                                echo "<option value='" . $mech['id'] . "' $selected>"
                                    . htmlspecialchars($mech['name'])
                                    . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="edit-actions">
                        <button type="submit" class="btn btn-gold">
                            Save Changes
                        </button>

                        <a href="index.php" class="btn-cancel">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop. All rights reserved.
    </footer>

</body>

</html>