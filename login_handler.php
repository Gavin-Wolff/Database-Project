<?php
session_start();
require_once 'db.php';

function back($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    header("Location: home.php");
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
if ($email === '' || $password === '') {
    back('danger', 'Please enter your email and password.');
}

$stmt = $conn->prepare("SELECT UID, FName, Password FROM users WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row && password_verify($password, $row['Password'])) {
    session_regenerate_id(true);
    $_SESSION['uid'] = $row['UID'];
    $_SESSION['name'] = $row['FName'];
    back('success', 'Welcome back, ' . $row['FName'] . '!');
}

back('danger', 'Incorrect email or password.');
