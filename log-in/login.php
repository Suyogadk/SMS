<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
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
    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query to check user
    $sql = "SELECT * FROM `SMS4L` WHERE `username` = '$username' AND `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // First try direct password comparison (for non-hashed passwords)
        if ($password === $row['password']) {
            $_SESSION['username'] = $username;
            header("Location: ../welcome/welcome.php");
            exit;
        }
        // Then try password_verify (for hashed passwords)
        else if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: ../welcome/welcome.php");
            exit;
        }
        else {
            // If both methods fail, show error
            echo "<div style='text-align: center; margin-top: 20px;'>";
            echo "<h3>Invalid password!</h3>";
            echo "<p>Please check your password and try again.</p>";
            echo "<a href='login.html' style='text-decoration: none; color: white; background-color: #4CAF50; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-top: 10px;'>Try Again</a>";
            echo "</div>";
        }
    } else {
        // User not found
        echo "<div style='text-align: center; margin-top: 20px;'>";
        echo "<h3>Login Failed</h3>";
        echo "<p>Incorrect username or email.</p>";
        echo "<a href='login.html' style='text-decoration: none; color: white; background-color: #4CAF50;padding:10px 20px; border-radius: 5px; display: inline-block; margin-top: 10px;'>Try Again</a>";
        echo "</div>";
    }
} else {
    // If someone tries to access this file directly without POST data
    echo "<div style='text-align: center; margin-top: 20px;'>";
    echo "<h3>Invalid Access</h3>";
    echo "<p>Please access this page through the login form.</p>";
    echo "<a href='login.html' style='text-decoration: none; color: white; background-color: #4CAF50; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-top: 10px;'>Go to Login</a>";
    echo "</div>";
}

// After successful password verification
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Check if user details exist
    $checkDetailsSql = "SELECT * FROM `user-d` WHERE `username` = '$username'";
    $detailsResult = mysqli_query($conn, $checkDetailsSql);

    $_SESSION['username'] = $username;

    if ($detailsResult && mysqli_num_rows($detailsResult) > 0) {
        // User details found, redirect to info.php
        header("Location: ../welcome/info.php");
    } else {
        // User details not found, redirect to welcome.html
        header("Location: ../welcome/welcome.html");
    }
    exit;
}

mysqli_close($conn);
?>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h3 {
    color: #333;
    margin-bottom: 10px;
}

p {
    color: #666;
    margin-bottom: 20px;
}

a:hover {
    background-color: #45a049;
}
</style>
