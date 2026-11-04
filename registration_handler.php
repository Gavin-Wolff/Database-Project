<?php
    require_once 'db.php';

    if(!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        echo "<h2>There was a problem with your input. Try again.</h2>";
        header("Location: register.php");
        exit;
    }

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // we use argon2id salted hash rather than plain text passwords
    $p_hash = password_hash($password, PASSWORD_ARGON2ID);

    try {
        $sql = "INSERT INTO users (FName, LName, Email, Password) VALUES ('$fname', '$lname', '$email', '$p_hash');";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: login.php");
        exit;
    } catch (Exception $e) {
        header("Location: register.php");
        echo "Database error: " . $e->getMessage();
        exit;
    }
?>
