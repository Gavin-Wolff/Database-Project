<?php
    require_once 'db.php';
    session_start();

    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $sql = "SELECT Password, FName, UID FROM users WHERE Email='$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            $hash = $row[0];
            $name = $row[1];
            $uid = $row[2];
            if(password_verify($password, $hash)) {
                $_SESSION["email"] = $email;
                $_SESSION["name"] = $name;
                $_SESSION["uid"] = $uid;
                header("Location: index.php");
            } else {
                header("Location: login.php");
                exit;
            }
            exit;
        } catch (Throwable $e) {
            //header("Location: register.php");
            echo "Database error: " . $e->getMessage();
            //exit;
        }
    } else {
        header("Location: login.php");
        echo "<h2>There was a problem with your input. Try again.</h2>";
        exit;
    }
?>
