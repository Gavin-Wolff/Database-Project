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

        <main>
            <div class="container p-5 my-5 rounded border border-1 border-secondary" style="max-width: 700px; border-color: rgb(25, 135, 84); background-color: rgb(250, 250, 250);">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="text-success">Create an Account</h3><br>
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
                    
                <form action="registration_handler.php" method="post">

                    <label for="fname" style="color: rgb(12, 87, 52);">First Name:</label>
                    <input type="text" id="fname" name="fname" required placeholder="Victor" class="form-control rounded-3 border border-1 border-secondary-subtle" style="color: rgb(12, 87, 52);"><br>
                    
                    <label for="lname" style="color: rgb(12, 87, 52);">Last Name:</label>
                    <input type="text" id="lname" name="lname" required placeholder="Wembanyama" class="form-control rounded-3 border border-1 border-secondary-subtle"><br>

                    <label for="email" style="color: rgb(12, 87, 52);">Email Address:</label>
                    <input type="text" id="email" name="email" required placeholder="victor@spurs.com" class="form-control rounded-3 border border-1 border-secondary-subtle"><br>

                    <label for="password" style="color: rgb(12, 87, 52);">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="************" class="form-control rounded-3 border border-1 border-secondary-subtle"><br><br>

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success rounded-3">Register</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="reset" class="btn btn-outline-dark btn-dark rounded-3 text-light">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <footer class="bg-dark text-white mt-10" style="margin-top: auto;">
            <div class="container text-center">
                <p class="mb-1">Smartbase Store Finder</p>
            </div>
        </footer>
    </body>
</html>
