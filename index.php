<?php
require_once 'db.php';

// Retrieve all stores from the database
$sql = "SELECT Name, HoursOfOperation FROM store ORDER BY Name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Smartbase Store Finder</title>

    <!-- Bootstrap styling -->
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- Custom styling -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="bg-success text-white p-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-white">Smartbase Store Finder</h1>

            <nav class="d-flex gap-5">
                <a href="search.php" class="text-white text-decoration-none">
                    Search
                </a>

                <a href="login.php" class="text-white text-decoration-none">
                    Log In
                </a>

                <a href="register.php" class="text-white text-decoration-none">
                    Register
                </a>

                <a href="admin.php" class="text-white text-decoration-none">
                    Admin Profile
                </a>
                <a href="logout.php" class="text-white text-decoration-none">
                    Log Out
                </a>
            </nav>
        </div>
    </header>

    <main class="container py-2 flex-grow-1">

        <h2>Select a Store</h2>

        <div class="storeGrid">

            <?php if ($result && $result->num_rows > 0) { ?>

                <?php while ($store = $result->fetch_assoc()) { ?>

                    <a href="search.php?store=<?php echo urlencode($store['Name']); ?>"
                       class="storeCard">

                        <div class="store-image">
                            Store Image
                        </div>

                        <h3><?php echo htmlspecialchars($store['Name']); ?></h3>

                        <p><?php echo htmlspecialchars($store['HoursOfOperation']); ?></p>

                    </a>

                <?php } ?>

            <?php } else { ?>

                <p>No stores found.</p>

            <?php } ?>

    </main>

    <footer class="bg-dark text-white mt-10">

        <div class="container text-center">
            <p class="mb-1">Smartbase Store Finder</p>
        </div>
    
    </footer>

</body>
</html>
