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
    die("Error: Client Name cannot be empty.");
}

if (!ctype_digit($phone)) {
    die("Error: Phone number must contain only numbers.");
}

if (!ctype_digit($car_engine)) {
    die("Error: Car Engine must contain only numbers.");
}

if (empty($car_license)) {
    die("Error: Car License Number cannot be empty.");
}

if (empty($appointment_date)) {
    die("Error: Appointment Date must be selected.");
}

if (empty($mechanic_id)) {
    die("Error: You must select a mechanic.");
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
    die("Error: You have already scheduled an appointment for this date.");
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
    die("Error: This mechanic is fully booked on this date.");
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
    echo "<h2>Success! Your appointment has been booked.</h2>";
    echo "<p>Thank you, " . htmlspecialchars($client_name) . ".</p>";
    echo "<a href='index.php'>Book Another Appointment</a>";
} else {
    // If the database crashes or hits an unexpected system issue
    echo "Error saving appointment: " . $stmt_insert->error;
}
$stmt_insert->close();