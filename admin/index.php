<?php
include '../db.php';

// Main appointments query
$sql = "SELECT 
            a.id,
            a.client_name,
            a.phone,
            a.car_license,
            a.appointment_date,
            m.name AS mechanic_name
        FROM appointments a
        JOIN mechanics m ON a.mechanic_id = m.id
        ORDER BY a.appointment_date ASC";

$result = $conn->query($sql);

// Stats: Total appointments
$total_result = $conn->query("SELECT COUNT(*) AS total FROM appointments");
$total = $total_result->fetch_assoc()['total'];

// Stats: Today's appointments
$today = date('Y-m-d');
$today_result = $conn->query("SELECT COUNT(*) AS today_total FROM appointments WHERE appointment_date = '$today'");
$today_total = $today_result->fetch_assoc()['today_total'];

// Stats: Total mechanics
$mech_result = $conn->query("SELECT COUNT(*) AS total_mechs FROM mechanics");
$total_mechs = $mech_result->fetch_assoc()['total_mechs'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Workshop Control Room | Hollywood Car Workshop</title>
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

    <!-- Cinematic Page Header -->
    <div class="page-header">
        <h1>Workshop Control Room</h1>
        <p>Executive management of all vehicle assignments</p>
    </div>

    <!-- Premium Stats Section -->
    <div class="stats-bar">

        <div class="stat-card">
            <div class="stat-number"><?php echo $total; ?></div>
            <div class="stat-label">Total Appointments</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $today_total; ?></div>
            <div class="stat-label">Today's Assignments</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $total_mechs; ?></div>
            <div class="stat-label">Active Mechanics</div>
        </div>

    </div>

    <!-- Executive Table -->
    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Phone</th>
                    <th>License</th>
                    <th>Date</th>
                    <th>Mechanic</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['car_license']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                        echo "<td>
                                <span class='mech-badge'>"
                            . htmlspecialchars($row['mechanic_name']) .
                            "</span>
                              </td>";
                        echo "<td>
                                <a href='edit_appointment.php?id=" . $row['id'] . "' 
                                   class='btn-edit'>
                                   Edit
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>
                            <td colspan='7' class='empty-table'>
                                No appointments scheduled yet.
                            </td>
                          </tr>";
                }
                ?>
            </tbody>

        </table>

    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop. All rights reserved.
    </footer>

</body>

</html>