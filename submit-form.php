<?php

$host = "localhost";
$dbname = "fceindia_fce3_form_data";
$username = "fceindia_fce3_user";
$password = "fce3@indiadatabase";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$service = trim($_POST['service'] ?? '');
$message = trim($_POST['message'] ?? '');

if (
    empty($name) ||
    empty($phone) ||
    empty($email) ||
    empty($service) ||
    empty($message)
) {
    die("Please fill in all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

$sql = "INSERT INTO form_submissions
        (name, phone, email, service, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssss",
    $name,
    $phone,
    $email,
    $service,
    $message
);

if ($stmt->execute()) {
    echo "Form submitted successfully!";
} else {
    echo "Error submitting form.";
}

$stmt->close();
$conn->close();

?>