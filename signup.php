<?php
// signup.php

// Include the database connection
include 'database.php';

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $student_name  = trim($_POST['student_name']);
    $phone_number  = trim($_POST['phone_number']);
    $student_class = trim($_POST['student_class']);
    $school_name   = trim($_POST['school_name']);
    $guardian_phone= trim($_POST['guardian_phone']);
    $student_email = trim($_POST['student_email']);
    $student_pin   = trim($_POST['student_pin']);

    // You may add further validations (email format, pin length, etc.)
    if(empty($student_name) || empty($phone_number) || empty($student_class) || empty($school_name) || empty($guardian_phone) || empty($student_email) || empty($student_pin)) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Prepare and execute a safe insert query using prepared statements
    $stmt = $conn->prepare("INSERT INTO student_registration (student_name, phone_number, student_class, school_name, guardian_phone, student_email, student_pin) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    // Bind parameters, all as strings
    $stmt->bind_param("sssssss", $student_name, $phone_number, $student_class, $school_name, $guardian_phone, $student_email, $student_pin);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
