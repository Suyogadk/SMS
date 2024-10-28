<?php
session_start();
require 'vendor/autoload.php'; // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$host = 'sql8.freesqldatabase.com'; 
$db = 'sql8739904';
$user = 'sql8739904';
$pass = 'UBN9aaWh58';
$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());}
    ?>