<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hollywood Car Workshop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;600;700&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
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

    <!-- Hero Split Section -->
    <section class="hero-split">
        <div class="hero-content">

            <!-- Left Text -->
            <div class="hero-text">
                <div class="eyebrow">Welcome to the Set</div>
                <h1>Serviced by Legends.<br>Fixed Like a Blockbuster.</h1>
                <p>
                    Our mechanics aren't ordinary — they're inspired by
                    Hollywood's most iconic characters. Pick your favorite
                    and let the stars fix your ride.
                </p>
                <a href="#appointment-form" class="btn btn-gold">
                    Get Appointment →
                </a>
            </div>

            <!-- Right Form Panel -->
            <div class="form-panel" id="appointment-form">
                <h2>Book an Appointment</h2>

                <form action="submit_appointment.php" method="POST" id="appointmentForm">

                    <!-- ===== Step 1: Always Visible ===== -->
                    <div class="form-group">
                        <label>Client Name</label>
                        <input type="text" name="client_name" id="client_name" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" required>
                    </div>

                    <div class="form-group">
                        <label>Car License Number</label>
                        <input type="text" name="car_license" id="car_license" required>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address">
                    </div>

                    <button type="button" class="btn btn-gold btn-block" id="continueBtn">
                        Continue Booking →
                    </button>

                    <!-- ===== Step 2: Hidden Until Continue is Clicked ===== -->
                    <div id="step2">



                        <div class="form-group">
                            <label>Car Engine Number</label>
                            <input type="text" name="car_engine" id="car_engine" required>
                        </div>

                        <div class="form-group">
                            <label>Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" required>
                        </div>

                        <div class="form-group">
                            <label>Select Mechanic</label>
                            <select name="mechanic_id" id="mechanic_select" required>
                                <option value="">-- Choose a Date First --</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gold btn-block">
                            Book Appointment
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; <?php echo date("Y"); ?> Hollywood Car Workshop. All rights reserved.
    </footer>

    <!-- JavaScript -->
    <script>
        // ===== Progressive Disclosure Logic =====
        const continueBtn = document.getElementById('continueBtn');
        const step2 = document.getElementById('step2');

        continueBtn.addEventListener('click', function() {
            const clientName = document.getElementById('client_name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const carLicense = document.getElementById('car_license').value.trim();
            const onlyNumbers = /^[0-9]+$/;

            if (clientName === "") {
                alert("Please enter the client's name.");
                return;
            }

            if (!onlyNumbers.test(phone)) {
                alert("Phone number must contain only digits.");
                return;
            }

            if (carLicense === "") {
                alert("Please enter the car license number.");
                return;
            }

            // ✅ Passed validation — reveal Step 2
            step2.classList.add('show');
            continueBtn.style.display = 'none';
        });

        const dateInput = document.getElementById('appointment_date');
        const mechanicSelect = document.getElementById('mechanic_select');

        dateInput.addEventListener('change', function() {
            const selectedDate = this.value;

            if (selectedDate === "") {
                mechanicSelect.innerHTML = '<option value="">-- Choose a Date First --</option>';
                return;
            }

            fetch('get_mechanic_slots.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'appointment_date=' + selectedDate
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(mechanicsList) {
                    let dropdownHTML = '<option value="">-- Select a Mechanic --</option>';

                    for (let i = 0; i < mechanicsList.length; i++) {
                        let mechanic = mechanicsList[i];

                        let label = mechanic.name;

                        if (mechanic.specialty) {
                            label += " — " + mechanic.specialty;
                        }

                        if (mechanic.is_full) {
                            label += " (FULL)";
                        } else {
                            label += " (" + mechanic.free_slots + " slots)";
                        }

                        let disabledAttribute = "";
                        if (mechanic.is_full) {
                            disabledAttribute = "disabled";
                        }

                        dropdownHTML += '<option value="' + mechanic.id + '" ' + disabledAttribute + '>' + label + '</option>';
                    }

                    mechanicSelect.innerHTML = dropdownHTML;
                });
        });

        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            const clientName = document.querySelector('input[name="client_name"]').value.trim();
            const phone = document.querySelector('input[name="phone"]').value.trim();
            const carLicense = document.querySelector('input[name="car_license"]').value.trim();
            const carEngine = document.querySelector('input[name="car_engine"]').value.trim();
            const appointmentDate = document.querySelector('input[name="appointment_date"]').value;
            const mechanicId = document.querySelector('select[name="mechanic_id"]').value;

            if (clientName === "") {
                alert("Please enter the client's name.");
                event.preventDefault();
                return;
            }

            const onlyNumbers = /^[0-9]+$/;
            if (!onlyNumbers.test(phone)) {
                alert("Phone number must contain only digits.");
                event.preventDefault();
                return;
            }

            if (carLicense === "") {
                alert("Please enter the car license number.");
                event.preventDefault();
                return;
            }

            if (!onlyNumbers.test(carEngine)) {
                alert("Car engine number must contain only digits.");
                event.preventDefault();
                return;
            }

            if (appointmentDate === "") {
                alert("Please select an appointment date.");
                event.preventDefault();
                return;
            }

            if (mechanicId === "") {
                alert("Please select a mechanic.");
                event.preventDefault();
                return;
            }
        });
    </script>

</body>

</html>