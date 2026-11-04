
<?php
// Connect to the database
require_once 'db.php';

// Get what the user typed
$keyword = $_GET['keyword'] ?? '';

// Search for products
$search = "%$keyword%";

$sql = "SELECT ItemID, ItemName, Description
        FROM item
        WHERE ItemType = 'Product'
        AND ItemName LIKE ?
        ORDER BY ItemName";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

// Get product names for autocomplete
$suggestions = $conn->query(
    "SELECT ItemName FROM item
     WHERE ItemType = 'Product'
     ORDER BY ItemName"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smartbase Food Finder</title>

    <!-- Bootstrap styling -->
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- Custom styling -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<!-- Green header -->
<header class="bg-success text-white p-4">
    <div class="container">
        <h1>Smartbase Food Finder</h1>
    </div>
</header>

<main class="container py-4">

    <!-- Search bar -->
    <form method="GET" action="search.php" class="mb-3">

        <div class="input-group input-group-lg">

            <input
                type="text"
                name="keyword"
                class="form-control"
                placeholder="Search for food..."
                value="<?= htmlspecialchars($keyword) ?>"
                list="productSuggestions"
            >

            <!-- Show product names while typing -->
            <datalist id="productSuggestions">
                <?php while ($item = $suggestions->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($item['ItemName']) ?>">
                <?php endwhile; ?>
            </datalist>

            <button class="btn btn-success" type="submit">
                Search
            </button>

        </div>
    </form>

    <!-- Return to the home page -->
    <a href="index.php" class="btn btn-outline-success mb-4">
        Back to Home
    </a>

    <h2 class="mb-4">
        <?= $keyword ? "Search Results" : "All Products" ?>
    </h2>

    <!-- Display products -->
    <div class="row g-4">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($item = $result->fetch_assoc()): ?>

                <div class="col-12 col-sm-6 col-lg-3">

                    <!-- Click a product to see its details -->
                    <a href="product.php?id=<?= $item['ItemID'] ?>"
                       class="text-decoration-none text-dark">

                        <div class="card h-100">

                            <!-- Space for the product picture -->
                            <div class="product-image">
                                Product Image
                            </div>

                            <div class="card-body">

                                <h5 class="card-title">
                                    <?= htmlspecialchars($item['ItemName']) ?>
                                </h5>

                                <p class="card-text">
                                    <?= htmlspecialchars($item['Description'] ?? '') ?>
                                </p>

                            </div>
                        </div>

                    </a>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p>No products found.</p>

        <?php endif; ?>

    </div>

</main>

<!-- Bootstrap JavaScript -->
<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
