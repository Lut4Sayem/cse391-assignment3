# Hollywood Car Workshop — Appointment System (PHP + MySQL)

## Project Overview

**Hollywood Car Workshop** is a PHP + MySQL web application for booking car workshop appointments.  
Clients can choose a desired mechanic based on availability for a selected date. The system enforces business rules such as **no duplicate booking (same license + same date)** and **maximum 4 appointments per mechanic per day**.

Built for **CSE 391: Programming for the Internet — Assignment 3** using:

- HTML, CSS, JavaScript (AJAX)
- PHP (server-side validation + prepared statements)
- MySQL (database storage)

### Database Setup

Run the included `setup.sql` file in phpMyAdmin or MySQL to create the database and tables.

---

## Features

### User Panel (Client Booking)

- Appointment booking form:
  - Client Name, Address, Phone
  - Car License Number, Car Engine Number
  - Appointment Date
  - Desired Mechanic selection
- AJAX mechanic availability:
  - Shows free slots per mechanic
  - Fully booked mechanics are disabled
- Progressive form UI:
  - Shows required fields first
  - Expands full form after clicking **Continue Booking**
- Validation:
  - Client-side (JavaScript)
  - Server-side (PHP)

### Admin Panel

- Admin dashboard ("Workshop Control Room")
- View all appointments (JOIN query shows mechanic name)
- Edit an appointment (change date + mechanic)
- Update appointment with mechanic capacity check (excluding current appointment)

### Extra Pages

- `mechanics.php` — Elite mechanics photo-card showcase
- `help.php` — FAQ style help/rules page

---

## Business Rules (Assignment Requirements)

1. A client cannot book more than one appointment on the same date using the same car license number.
2. Each mechanic can handle a maximum of **4 appointments per day**.
3. Fully booked mechanics cannot be selected.

> Note: The assignment mentions “around 5 mechanics”. This project uses **5 mechanics** to match the scenario.

---

## Directory Structure

```txt
workshop/
├── admin/
│   ├── index.php                # Admin dashboard (appointments list)
│   ├── edit_appointment.php     # Edit appointment form
│   └── update_appointment.php   # Update handler + styled error page
│
├── css/
│   └── styles.css               # Full site styling (Hollywood theme)
│
├── images/
│   ├── background.jpg           # Main background image
│   ├── logo.png                 # Navbar logo
│   └── mechanics/               # Mechanic photo cards
│       ├── walter.jpg
│       ├── toretto.jpg
│       ├── wick.jpg
│       ├── wayne.jpg
│       └── bond.jpg
│
├── db.php                       # Database connection
├── index.php                    # Home page (booking + hero)
├── submit_appointment.php       # Appointment submission handler
├── get_mechanic_slots.php       # AJAX endpoint (availability per date)
├── mechanics.php                # Elite mechanics showcase page
└── help.php                     # FAQ page (rules + instructions)
```
