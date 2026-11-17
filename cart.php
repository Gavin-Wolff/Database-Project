<?php
    require_once 'db.php';
    require_once 'session.php';

    $uid = $_SESSION['uid'];
    $sql = "SELECT item.ItemName, store.Name FROM (cart JOIN store ON cart.StoreID = store.StoreID) JOIN item ON cart.ItemID = item.ItemID WHERE UID = '$uid';";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>

    <!-- Bootstrap styling -->
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- Custom styling -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="s.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <header class="bg-success text-white p-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-white">Shopping Cart</h1>

            <nav class="d-flex gap-5">

                <?php if(isset($_SESSION["name"])){
                    echo "<p>Hi, " . $_SESSION["name"] . "!";
                    echo "<p></p>";
                    echo "<p></p>";
                }?>

                <a href="search.php" class="text-white text-decoration-none">
                    Search
                </a>
                
                <a href="index.php" class="text-white text-decoration-none">
                    Home
                </a>

                <a href="admin.php" class="text-white text-decoration-none">
                    Account Management
                </a>

                <a href="logout.php" class="text-white text-decoration-none">
                    Log Out
                </a>
            </nav>
        </div>
    </header>
    <!-- right now this is a super basic page its basically just copy and paste of the index.php, i will update it later -->
    <main class="container py-2 flex-grow-1">
        <br>
        <h2>Your Saved Items</h2>
        <br>

        <div class="storeGrid">

            <?php if ($result && $result->num_rows > 0) { ?>

                <?php while ($store = $result->fetch_assoc()) { ?>

                    <a href="search.php" class="storeCard">

                        <div class="product-image">
                            Item Image
                        </div>

                        <h3><?php echo htmlspecialchars($store['ItemName']); ?></h3>

                        <p><?php echo htmlspecialchars($store['Name']); ?></p>

                    </a>

                <?php } ?>

            <?php } else { ?>

                <p>You don't have any saved items.</p>

            <?php } ?>

    </main>

    <footer class="bg-dark text-white mt-10">

        <div class="container text-center">
            <p class="mb-1">Smartbase Store Finder</p>
        </div>
    
    </footer>

</body>
</html>
