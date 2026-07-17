<?php
// Database connection details
$servername = "localhost";      
$username = "root";              
$password = "";               
$dbname = "workshop_db";  
    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>