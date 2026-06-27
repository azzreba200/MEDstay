<?php
// Booking handler for property.php  ->  inserts into bookings with overlap prevention.
include 'db.php';

// Only accept POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$property_id = isset($_POST['property_id']) ? (int) $_POST['property_id'] : 0;
$guest_name  = trim($_POST['guest_name']  ?? '');
$guest_email = trim($_POST['guest_email'] ?? '');
$check_in    = trim($_POST['check_in']    ?? '');
$check_out   = trim($_POST['check_out']   ?? '');

// Helper: bounce back to the property page with a status code.
function redirect_back($property_id, $status) {
    $target = $property_id > 0
        ? "property.php?id={$property_id}&booked={$status}"
        : "index.php";
    header("Location: $target");
    exit;
}

// --- Validation ---------------------------------------------------------
$valid_dates =
    preg_match('/^\d{4}-\d{2}-\d{2}$/', $check_in) &&
    preg_match('/^\d{4}-\d{2}-\d{2}$/', $check_out);

if (
    $property_id <= 0 ||
    $guest_name === '' ||
    !filter_var($guest_email, FILTER_VALIDATE_EMAIL) ||
    !$valid_dates ||
    $check_out <= $check_in              // check-out must be after check-in
) {
    redirect_back($property_id, 'invalid');
}

// Make sure the property actually exists.
$check = $conn->prepare("SELECT id FROM properties WHERE id = ?");
$check->bind_param('i', $property_id);
$check->execute();
if (!$check->get_result()->fetch_assoc()) {
    $check->close();
    redirect_back($property_id, 'error');
}
$check->close();

// --- Atomic insert with double-booking prevention -----------------------
// The row is only inserted when no existing booking for the same property
// overlaps the requested range. Overlap = existing.check_in < new.check_out
// AND existing.check_out > new.check_in (touching dates, e.g. one guest's
// checkout = next guest's check-in, are allowed).
$sql = "INSERT INTO bookings (property_id, guest_name, guest_email, check_in, check_out)
        SELECT ?, ?, ?, ?, ?
        FROM DUAL
        WHERE NOT EXISTS (
            SELECT 1 FROM bookings
            WHERE property_id = ?
              AND check_in  < ?
              AND check_out > ?
        )";

$stmt = $conn->prepare($sql);
// types: property_id(i), name(s), email(s), check_in(s), check_out(s),
//        property_id(i), new_check_out(s), new_check_in(s)
$stmt->bind_param(
    'issssiss',
    $property_id, $guest_name, $guest_email, $check_in, $check_out,
    $property_id, $check_out, $check_in
);

if (!$stmt->execute()) {
    $stmt->close();
    redirect_back($property_id, 'error');
}

$inserted = $stmt->affected_rows;   // 1 = booked, 0 = dates overlapped
$stmt->close();
$conn->close();

redirect_back($property_id, $inserted === 1 ? '1' : 'unavailable');
