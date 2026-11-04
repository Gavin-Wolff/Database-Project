<?php
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <!-- at the moment this is very raw. will style it more later -->
    <body class="bg-light d-flex flex-column min-vh-100">

        <header class="bg-success text-white p-2">
            <div class="container d-flex justify-content-between align-items-center">
                <h1>Registration</h1>

                <nav class="d-flex gap-5">
                    <a href="login.php" class="text-white text-decoration-none">
                        Login
                    </a>

                    <a href="index.php" class="text-white text-decoration-none">
                        Home
                    </a>
                <nav>
            </div>
        </header>
        <br>
        <div>
			<br>
            <div style="display: flex; justify-content: center;">
                <h3>Update your Information</h3>
            </div>
			<br>
            <div style="display: flex; justify-content: center;">
                <form method="POST" action="">
                    <label for="fname">First Name</label><br>
                    <input type="text" id="fname" name="fname" placeholder="Change your first name">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Submit"><br><br>
                </form>
            </div>
            <div style="display: flex; justify-content: center;">
                <form method="POST" action="">
                    <label for="lname">Last Name</label><br>
                    <input type="text" id="lname" name="lname" placeholder="Change your last name">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Submit"><br><br>
                </form>
            </div>
            <div style="display: flex; justify-content: center;">
                <form method="POST" action="">
                    <label for="email">Email Address</label><br>
                    <input type="text" id="email" name="email" placeholder="Change your email address">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Submit"><br><br>
                </form>
            </div>
            <div style="display: flex; justify-content: center;">
                <form method="POST" action="">
                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Change your password">
                    <input type="reset" value="Reset">
                    <input type="submit" value="Submit"><br><br>
                </form>
            </div>
            <br>
        </div>
    </body>
</html>
