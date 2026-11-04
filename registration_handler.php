<?php
session_start();
require_once 'db.php';

function back($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    header("Location: home.php");
    exit;
}

$fname = trim($_POST['fname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($fname === '' || $lname === '' || $email === '' || strlen($password) < 8) {
    back('danger', 'Please fill in every field (password needs 8+ characters).');
}

// argon2id salted hash rather than plain text
$hash = password_hash($password, PASSWORD_ARGON2ID);

try {
    $stmt = $conn->prepare("INSERT INTO users (FName, LName, Email, Password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $lname, $email, $hash);
    $stmt->execute();
    back('success', 'Account created! You can sign in now.');
} catch (mysqli_sql_exception $ex) {
    // 1062 = duplicate email
    back('danger', $ex->getCode() == 1062 ? 'That email is already registered.' : 'Could not create account.');
}
