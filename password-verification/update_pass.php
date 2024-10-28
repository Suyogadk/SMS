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
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate password match
        if ($new_password === $confirm_password) {
            

            // Update the password in the database
            $sql = "UPDATE `SMS4L` SET `password` = '$password' WHERE `username` = '$username'";
            if (mysqli_query($conn, $sql)) {
                echo "<h3>Password updated successfully!</h3>";
                echo '<a href="../log-in/login.html">Go to Login</a>';
                // Clear the session
                unset($_SESSION['username']);
            } else {
                echo "<h3>Error updating password. Please try again.</h3>";
                echo '<a href="../login.html">Go to Login</a>';
            }
        } else {
            echo "<h3>Passwords do not match. Please try again.</h3>";
            echo '<a href="verify_code.html">Go back</a>';
        }
    } else {
        echo "<h3>No user session found. Please start over.</h3>";
        echo '<a href="../log-in/login.html">Go to Login</a>';
    }
} else {
    echo "<h3>Invalid Access</h3>";
    echo '<a href="../log-in/login.html">Go to Login</a>';
}

mysqli_close($conn);
?>