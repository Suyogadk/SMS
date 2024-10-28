<?php
session_start();

// Database connection
$host = 'sql8.freesqldatabase.com'; 
$db = 'sql8739904';
$user = 'sql8739904';
$pass = 'UBN9aaWh58';
$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Initialize variables
$username = '';
$data = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username from the form
    $username = trim($_POST['username']);

    // Prepare and execute the query for the SMS4L table
    $sql1 = "SELECT first_name, last_name, email FROM SMS4L WHERE username = ?";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1 === false) {
        die("ERROR: Could not prepare statement for SMS4L: " . $conn->error);
    }
    $stmt1->bind_param("s", $username);
    if (!$stmt1->execute()) {
        die("ERROR: Could not execute query for SMS4L: " . $stmt1->error);
    }
    $result1 = $stmt1->get_result();
    $userData = $result1->fetch_assoc();

    // Prepare and execute the query for the userd table
    $sql2 = "SELECT gender, address, contact_no, dob FROM `userd` WHERE username = ?";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2 === false) {
        die("ERROR: Could not prepare statement for userd: " . $conn->error);
    }
    $stmt2->bind_param("s", $username);
    if (!$stmt2->execute()) {
        die("ERROR: Could not execute query for userd: " . $stmt2->error);
    }
    $result2 = $stmt2->get_result();
    $additionalData = $result2->fetch_assoc();

    // Combine data
    $data = array_merge($userData ?? [], $additionalData ?? []);

    // Close the database connection
    $stmt1->close();
    $stmt2->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="info.css">
</head>
<body>

<div class="container">
    <h2>User Information</h2>
    <?php if (!empty($data)): ?>
        <div class="info">
            <strong>First Name:</strong> <?php echo htmlspecialchars($data['first_name'] ?? 'N/A'); ?>
        </div>
        <div class="info">
            <strong>Last Name:</strong> <?php echo htmlspecialchars($data['last_name'] ?? 'N/A'); ?>
        </div>
        <div class="info">
            <strong>Username:</strong> <?php echo htmlspecialchars($username); ?>
        </div>
        <div class="info">
            <strong>Email:</strong> <?php echo htmlspecialchars($data['email'] ?? 'N/A'); ?>
        </div>
        <div class="info">
            <strong>Gender:</strong> <?php echo htmlspecialchars($data['gender'] ?? 'N/A'); ?>
        </div>
        <div class="info">
            <strong>Date of Birth:</strong> <?php echo htmlspecialchars($data['dob'] ?? 'N/A'); ?>
        </div>
        <div class="info">
            <strong>Address:</strong> <?php echo nl2br(htmlspecialchars($data['address'] ?? 'N/A')); ?>
        </div>
        <div class="info">
            <strong>Contact No:</strong> <?php echo htmlspecialchars($data['contact_no'] ?? 'N/A'); ?>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class="info">
            <strong>No data found for the username:</strong> <?php echo htmlspecialchars($username); ?>
        </div>
    <?php endif; ?>
