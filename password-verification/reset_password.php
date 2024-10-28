<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if verification codes exist in the session
    if (isset($_SESSION['verification_codes']) && isset($_SESSION['username'])) {
        $input_code = $_POST['code'];
        $verification_codes = $_SESSION['verification_codes'];
        $username = $_SESSION['username'];

        // Check if the input code matches any of the verification codes
        if (in_array($input_code, $verification_codes)) {
            // If the code is correct, allow the user to reset their password
            echo '<form action="update_password.php" method="POST">';
            echo '<label for="new_password">Enter your new password:</label>';
            echo '<input type="password" id="new_password" name="new_password" required>';
            echo '<label for="confirm_password">Confirm your new password:</label>';
            echo '<input type="password" id="confirm_password" name="confirm_password" required>';
            echo '<button type="submit">Reset Password</button>';
            echo '</form>';

            // Clear the verification codes from the session
            unset($_SESSION['verification_codes']);
        } else {
            echo "<h3>Invalid verification code. Please try again.</h3>";
            echo '<a href="verify_code.html">Go back</a>';
        }
    } else {
        echo "<h3>No verification codes found. Please start over.</h3>";
        echo '<a href="../login.html">Go to Login</a>';
    }
} else {
    echo "<h3>Invalid Access</h3>";
    echo '<a href="../login.html">Go to Login</a>';
}
?>