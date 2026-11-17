<?php
    require_once 'db.php';
    require_once 'session.php';
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];

    $f = false;
    $l = false;
    $m = false;
    $p = false;

    $fname = "";
    $lname = "";
    $mail = "";
    $pass = "";

    try {
        if(isset($_POST['fname']) && strlen($_POST['fname']) > 0) {
            $sql = "SELECT FName FROM users WHERE Email='$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            $fname = $row[0];
            if($fname != $_POST['fname']) {
                $f = true;
                $fname = $_POST['fname'];
            }
            $stmt->close();
        }

        if(isset($_POST['lname']) && strlen($_POST['lname']) > 0) {
            $sql = "SELECT LName FROM users WHERE Email='$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            $lname = $row[0];
            if($lname != $_POST['lname']) {
                $l = true;
                $lname = $_POST['lname'];
            }
            $stmt->close();
        }

        if(isset($_POST['email']) && strlen($_POST['email']) > 0) {
            $sql = "SELECT Email FROM users WHERE Email='$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();
            $mail = $row[0];
            if($mail != $_POST['email']) {
                $m = true;
                $mail = $_POST['email'];
            }
            $stmt->close();
        }

        if(isset($_POST['password']) && strlen($_POST['password']) > 0) {
            $sql = "SELECT Password FROM users WHERE Email='$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();

            $existing_password = $row[0];
            $new_pass = $_POST['password'];
            if(!(password_verify($new_pass, $existing_password))){
                $p = true;
                $pass = password_hash($new_pass, PASSWORD_ARGON2ID);
            }
            $stmt->close();
        }

    } catch (Throwable $e){
        print_r($e);
        exit;
    }

    try {
        if($f === true){
            $sql = "UPDATE users SET FName = '$fname' WHERE Email='$email';";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->close();
            $_SESSION['name'] = $fname;
        }
        if($l === true){
            $sql = "UPDATE users SET LName = '$lname' WHERE Email='$email';";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->close();
        }
        if($m === true){
            $sql = "UPDATE users SET Email = '$mail' WHERE Email='$email';";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->close();
            $_SESSION['email'] = $mail;
            $email = $mail;
        }
        if($p === true){
            $sql = "UPDATE users SET Password = '$pass' WHERE Email='$email';";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->close();
        }
    } catch (Throwable $e){
        print_r($e);
        echo "<h3>F: " . $f . ", fname: " . $fname . ".</h3>";
        echo "<h3>L: " . $l . ", lname: " . $lname . ".</h3>";
        echo "<h3>M: " . $m . ", mail: " . $mail . ".</h3>";
        echo "<h3>P: " . $p . ", pass: " . $pass . ".</h3>";
        exit;
    }

    header("Location: admin.php");
?>
