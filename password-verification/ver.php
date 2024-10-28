<?php
session_start();
$host = 'sql8.freesqldatabase.com'; 
$db = 'sql8739904';
$user = 'sql8739904';
$pass = 'UBN9aaWh58';
$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email exists in the database
    $sql = "SELECT * FROM `SMS4L` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];

        // Generate random verification codes
        $codes = [];
        for ($i = 0; $i < 3; $i++) {
            $codes[] = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        }

        // Store codes in session for later verification
        $_SESSION['verification_codes'] = $codes;
        $_SESSION['username'] = $username;

        // Send email using PHP's mail function
        $subject = "SMS - Password Verification Required";
        $message = "Hello $username,\n\n";
        $message .= "We received a request to verify your identity for password recovery on your SMS account. To confirm it’s really you, please choose the correct verification code below.\n\n";
        $message .= "Here are your options:\n";
        foreach ($codes as $index => $code) {
            $message .= ($index + 1) . ". **$code**\n";
        }
        $message .= "\nIf you didn’t request this, please ignore this email.\n\n";
        $message .= "Thank you,\nThe SMS Support Team\n";

        // Use mail function
        if (mail($email, $subject, $message, "From: SMS Support <stdmgtsys4l@gmail.com>")) {
            echo 'Verification email has been sent!';
            // Redirect to verification page
            header("Location: verify_code.html");
            exit;
        } else {
            echo 'Email sending failed.';
        }
    } else {
        echo "Email not found. Please try again.";
    }
}

mysqli_close($conn);
?>