<?php
// Handles the contact form submission from index.php
include 'db.php';

// Only accept POST submissions; anything else goes back to the homepage.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Collect and trim the submitted fields.
$first_name   = trim($_POST['first_name']   ?? '');
$last_name    = trim($_POST['last_name']    ?? '');
$email        = trim($_POST['email']        ?? '');
$inquiry_type = trim($_POST['inquiry_type'] ?? '');
$message      = trim($_POST['message']      ?? '');

// Basic validation: required fields + a valid email.
if (
    $first_name === '' || $last_name === '' || $message === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    header('Location: index.php?sent=error#contact');
    exit;
}

// Save to the database using a prepared statement.
$stmt = $conn->prepare(
    "INSERT INTO contact_messages (first_name, last_name, email, inquiry_type, message)
     VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param('sssss', $first_name, $last_name, $email, $inquiry_type, $message);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: index.php?sent=1#contact');
    exit;
}

// Insert failed.
$stmt->close();
$conn->close();
header('Location: index.php?sent=error#contact');
exit;
