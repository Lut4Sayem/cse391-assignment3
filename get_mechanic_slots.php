<?php
include 'db.php';

// Get the appointment date from JavaScript (sent via $_POST)
$appointment_date = $_POST['appointment_date'] ?? null;

// Validate that date was provided
if (!$appointment_date) {
    echo json_encode(['error' => 'No date provided']);
    exit;
}

// Query to get mechanics and their appointment counts on the selected date
$stmt = $conn->prepare("SELECT m.id, m.name, m.specialty, COUNT(a.id) as appointment_count
    FROM mechanics m
    LEFT JOIN appointments a ON m.id = a.mechanic_id AND a.appointment_date = ?
    GROUP BY m.id, m.name, m.specialty
    ORDER BY m.id");

$stmt->bind_param("s", $appointment_date);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo json_encode(['error' => 'Database query failed']);
    exit;
}

// Build an array to send back as JSON
$mechanics = [];

while ($row = $result->fetch_assoc()) {
    $free_slots = 4 - $row['appointment_count'];

    $mechanics[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'specialty' => $row['specialty'],
        'free_slots' => $free_slots,
        'is_full' => ($free_slots <= 0)
    ];
}

// Send back as JSON
echo json_encode($mechanics);