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
        <form action="registration_handler.php" method="post">

            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required placeholder="John"><br>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required placeholder="Smith"><br>

            <label for="email">Email Address:</label>
            <input type="text" id="email" name="email" required placeholder="email@example.com"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="********"><br><br>

            <button type="submit">Submit</button>
            <button type="reset">Reset</button>
        </form>
    </body>
</html>
