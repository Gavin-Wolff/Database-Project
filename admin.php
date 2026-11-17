<?php
    require_once 'db.php';
    session_start();
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    try {
        $sql = "SELECT LName, Password FROM users WHERE Email='$email'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $lname = $row[0];
        $hash = $row[1];
    } catch (Throwable $e){
        print_r($e);
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="bg-success text-white p-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>Account Management</h1>
            <nav class="d-flex">

            </nav>
            <nav class="d-flex gap-5">
                <a href="login.php" class="text-white text-decoration-none">Login</a>
                <a href="index.php" class="text-white text-decoration-none">Home</a>
            </nav>
        </div>
    </header>

    <main class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <!-- Bootstrap Card for visual framing -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Update your Information</h3>
                        
                        <form action="admin_handler.php" method="post">
                            
                            <div class="mb-3">
                                <label for="fname" class="form-label fw-semibold">First Name</label>
                                <input type="text" class="form-control bg-light" id="fname" name="fname" placeholder="<?php echo $name;?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="lname" class="form-label fw-semibold">Last Name</label>
                                <input type="text" class="form-control bg-light" id="lname" name="lname" placeholder="<?php echo $lname;?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control bg-light" id="email" name="email" placeholder="<?php echo $email;?>">
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Change your password">
                            </div>
                            
                            <!-- Grouped buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                <button type="submit" class="btn btn-success px-4">Submit</button>
                            </div>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>

