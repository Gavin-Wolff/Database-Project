<?php
    require_once 'db.php';

    if(!isset($_POST['email']) || !isset($_POST['password'])) {
        header("Location: login.php");
        echo "<h2>There was a problem with your input. Try again.</h2>";
        exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT Password FROM users WHERE Email='$email'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $hash = $row[0];

        if(password_verify($password, $hash)) {
            echo "<h1>True</h2>";
        } else {
            header("Location: login.php");
            echo "<h3>Authentication failed, try again.</h3>";
        }
        exit;
    } catch (Throwable $e) {
        //header("Location: register.php");
        echo "Database error: " . $e->getMessage();
        //exit;
    }
?>
