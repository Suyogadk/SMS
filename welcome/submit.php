<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../log-in/login.html");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $address = htmlspecialchars($_POST['address']);
    $contact_no = htmlspecialchars($_POST['contact_no']);

    // Store the data in session variables to display on info.php
    $_SESSION['gender'] = $gender;
    $_SESSION['dob'] = $dob;
    $_SESSION['address'] = $address;
    $_SESSION['contact_no'] = $contact_no;

    // Redirect to info.php
    header("Location: info.php");
    exit;
} else {
    // If the form is not submitted, redirect back to the form
    header("Location: welcome.php");
    exit;
}
?>