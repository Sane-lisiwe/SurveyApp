<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "surveydb";


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function calculateAge($dateOfBirth) {
    $currentYear = 2025;
    $birthYear = date('Y', strtotime($dateOfBirth));
    $age = $currentYear - $birthYear;
    return $age;
}


function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>