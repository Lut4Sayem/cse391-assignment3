<?php
// 1. Include the database connection file
include 'db.php';

// Check if the page was accessed via a POST form submission
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // If someone went directly to the URL, kick them back to the form page
    header("Location: index.php");
    exit(); // Stop the script immediately
}

// 2. Retrieve all form fields from $_POST
$client_name      = $_POST['client_name'];
$address          = $_POST['address'];
$phone            = $_POST['phone'];
$car_license      = $_POST['car_license'];
$car_engine       = $_POST['car_engine'];
$appointment_date = $_POST['appointment_date'];
$mechanic_id      = $_POST['mechanic_id'];

// 3. Validation: Check existing fields
if (empty($client_name)) {
    showMessage("error", "Validation Failed", "Client Name cannot be empty.");
}

if (!ctype_digit($phone)) {
    showMessage("error", "Validation Failed", "Phone number must contain only numbers.");
}

if (!ctype_digit($car_engine)) {
    showMessage("error", "Validation Failed", "Car Engine must contain only numbers.");
}

if (empty($car_license)) {
    showMessage("error", "Validation Failed", "Car License Number cannot be empty.");
}

if (empty($appointment_date)) {
    showMessage("error", "Validation Failed", "Appointment Date must be selected.");
}

if (empty($mechanic_id)) {
    showMessage("error", "Validation Failed", "You must select a mechanic.");
}


// BUSINESS RULE 1 - DUPLICATE BOOKING CHECK

//SQL query template using placeholders (?) for safety
$sql_check = "SELECT COUNT(*) AS total_booked FROM appointments WHERE car_license = ? AND appointment_date = ?";
$stmt_check = $conn->prepare($sql_check);

//attach actual variables to the placeholders and run
$stmt_check->bind_param("ss", $car_license, $appointment_date);
$stmt_check->execute();

// Step E: Fetch the numeric answer sent back by the database
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

// Step F: Stop the script if the database count is 1 or more
if ($row_check['total_booked'] > 0) {
    showMessage("error", "Duplicate Booking", "You have already scheduled an appointment on this date with this car license.");
}
$stmt_check->close();

// BUSINESS RULE 2 - MECHANIC FULL CHECK
// query counting rows for a specific mechanic and date
$sql_check2 = "SELECT COUNT(*) AS total_slots FROM appointments WHERE mechanic_id = ? AND appointment_date = ?";
$stmt_check2 = $conn->prepare($sql_check2);

// Bind variables. "is" means mechanic_id is an Integer, appointment_date is a String
$stmt_check2->bind_param("is", $mechanic_id, $appointment_date);
$stmt_check2->execute();
$result_check2 = $stmt_check2->get_result();
$row_check2 = $result_check2->fetch_assoc();

// Step C: If mechanic already has 4 or more appointments, stop execution
if ($row_check2['total_slots'] >= 4) {
    showMessage("error", "Mechanic Unavailable", "This mechanic is fully booked on the selected date. Please choose another mechanic or date.");
}
$stmt_check2->close();



// DATABASE INSERTION (THE FINALE)
// Prepare the SQL template with 7 placeholders (?)
$sql_insert = "INSERT INTO appointments (client_name, address, phone, car_license, car_engine, appointment_date, mechanic_id) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

// Bind all 7 fields: "ssssssi" tells PHP the data types:
$stmt_insert->bind_param("ssssssi", $client_name, $address, $phone, $car_license, $car_engine, $appointment_date, $mechanic_id);
if (empty($address)) {
    $address = null;
}
// Execute the insertion and check if it worked!:
if ($stmt_insert->execute()) {
    // SUCCESS
    showMessage("success", "Appointment Confirmed!", "Thank you, " . htmlspecialchars($client_name) . ". Your appointment has been booked successfully.");
} else {
    // If the database crashes or hits an unexpected system issue
    showMessage("error", "System Error", "Error saving appointment: " . $stmt_insert->error);
}
$stmt_insert->close();


/* =====================================================
   PAGE RENDERER FUNCTION
   Displays a themed success or error page
   Does NOT change any business logic above
===================================================== */
function showMessage($type, $title, $message)
{
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title><?php echo htmlspecialchars($title); ?> | Hollywood Car Workshop</title>
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
                <a href="help.php">Help</a>
                <a href="admin/index.php">Admin</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="page-content">
            <div class="feedback-container">
                <div class="feedback-card <?php echo $type === 'success' ? 'feedback-success' : 'feedback-error'; ?>">

                    <!-- Icon -->
                    <div class="feedback-icon">
                        <?php echo $type === 'success' ? '✅' : '⚠️'; ?>
                    </div>

                    <!-- Title -->
                    <h1><?php echo htmlspecialchars($title); ?></h1>

                    <!-- Message -->
                    <p><?php echo htmlspecialchars($message); ?></p>

                    <!-- Booking Summary (only shown on success) -->
                    <?php if ($type === 'success'): ?>
                        <div class="booking-summary">
                            <div class="summary-row">
                                <span class="summary-label">Name</span>
                                <span><?php echo htmlspecialchars($GLOBALS['client_name']); ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Car License</span>
                                <span><?php echo htmlspecialchars($GLOBALS['car_license']); ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Appointment Date</span>
                                <span><?php echo htmlspecialchars($GLOBALS['appointment_date']); ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Phone</span>
                                <span><?php echo htmlspecialchars($GLOBALS['phone']); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="feedback-actions">
                        <?php if ($type === 'success'): ?>
                            <a href="index.php" class="btn btn-gold">
                                Book Another Appointment
                            </a>
                            <a href="mechanics.php" class="btn btn-outline">
                                View Our Mechanics
                            </a>
                        <?php else: ?>
                            <a href="javascript:history.back()" class="btn btn-gold">
                                Go Back & Fix
                            </a>
                            <a href="index.php" class="btn btn-outline">
                                Start Over
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            &copy; <?php echo date("Y"); ?> Hollywood Car Workshop. All rights reserved.
        </footer>

    </body>

    </html>
<?php
    exit();
}
?>