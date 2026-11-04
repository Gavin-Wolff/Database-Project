<?php
require_once 'db.php';

// Get the search keyword
$keyword = $_GET['keyword'] ?? '';

// Get all stores
$storeResult = $conn->query("SELECT StoreID, Name FROM store ORDER BY Name");

$stores = [];

while ($store = $storeResult->fetch_assoc()) {
    $stores[] = $store;
}

// Get selected store IDs from the filter
$selectedStores = $_GET['stores'] ?? [];

// If the user clicked a store on the home page, select it
if (isset($_GET['store']) && empty($selectedStores)) {
    foreach ($stores as $store) {
        if ($store['Name'] == $_GET['store']) {
            $selectedStores[] = $store['StoreID'];
        }
    }
}

// Search for products
$sql = "SELECT item.ItemID, item.ItemName, item.Description,
               store.StoreID, store.Name, storeitem.Price
        FROM item
        LEFT JOIN storeitem
            ON item.ItemID = storeitem.ItemID
        LEFT JOIN store
            ON storeitem.StoreID = store.StoreID
        WHERE item.ItemType = 'Product'
        AND item.ItemName LIKE ?";

// If stores are selected, only show their prices
if (!empty($selectedStores)) {
    $ids = implode(',', array_map('intval', $selectedStores));
    $sql .= " AND store.StoreID IN ($ids)";
}

$sql .= " ORDER BY item.ItemName";

$stmt = $conn->prepare($sql);

$search = "%$keyword%";
$stmt->bind_param("s", $search);

$stmt->execute();
$result = $stmt->get_result();

// Group prices under each product
$products = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['ItemID'];

    if (!isset($products[$id])) {
        $products[$id] = [
            'name' => $row['ItemName'],
            'description' => $row['Description'],
            'prices' => []
        ];
    }

    // Only add prices when a store is selected
    if ($row['Price'] !== null && !empty($selectedStores)) {
        $products[$id]['prices'][] = [
            'store' => $row['Name'],
            'price' => $row['Price']
        ];
    }
}

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
    <title>Smartbase Store Finder</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- Custom styling -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<!-- Green header -->
<header class="bg-success text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>Smartbase Food Finder</h1>

        <a href="index.php" class="btn btn-outline-light">
            Back to Home
        </a>
    </div>
</header>

<main class="container py-4">

    <!-- Search bar -->
    <form method="GET" action="search.php" class="mb-4">

        <div class="input-group input-group-lg">

            <input
                type="text"
                name="keyword"
                class="form-control"
                placeholder="Search for food..."
                value="<?= htmlspecialchars($keyword) ?>"
                list="productSuggestions"
            >

            <!-- Product suggestions -->
            <datalist id="productSuggestions">
                <?php while ($item = $suggestions->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($item['ItemName']) ?>">
                <?php endwhile; ?>
            </datalist>

            <button class="btn btn-success">
                Search
            </button>

        </div>

    </form>

    <!-- Store filters -->
    <form method="GET" action="search.php">

        <input type="hidden" name="keyword"
               value="<?= htmlspecialchars($keyword) ?>">

        <div class="card mb-4">
            <div class="card-body">

                <h5>Filter by Store</h5>

                <?php foreach ($stores as $store): ?>

                    <label class="me-3">

                        <input
                            type="checkbox"
                            name="stores[]"
                            value="<?= $store['StoreID'] ?>"
                            <?= in_array($store['StoreID'], $selectedStores) ? 'checked' : '' ?>
                        >

                        <?= htmlspecialchars($store['Name']) ?>

                    </label>

                <?php endforeach; ?>

                <br>

                <button class="btn btn-success mt-3">
                    Apply Filters
                </button>

                <a href="search.php" class="btn btn-secondary mt-3">
                    Clear Filters
                </a>

            </div>
        </div>

    </form>

    <h2 class="mb-4">
        <?= $keyword ? "Search Results" : "All Products" ?>
    </h2>

    <!-- Product cards -->
    <div class="row g-4">

        <?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>

                <div class="col-12 col-sm-6 col-lg-3">

                    <div class="card h-100 shadow-sm">

                        <!-- Picture placeholder -->
                        <div class="product-image">
                            Product Image
                        </div>

                        <div class="card-body">

                            <h5>
                                <?= htmlspecialchars($product['name']) ?>
                            </h5>

                            <p>
                                <?= htmlspecialchars($product['description'] ?? '') ?>
                            </p>

                            <!-- Show prices from selected stores -->
                            <?php foreach ($product['prices'] as $price): ?>

                                <p>
                                    <?= htmlspecialchars($price['store']) ?>:

                                    <strong>
                                        $<?= number_format($price['price'], 2) ?>
                                    </strong>
                                </p>

                            <?php endforeach; ?>

                            <!-- Highlight the lowest price -->
                            <?php if (!empty($product['prices'])): ?>

                                <?php
                                $prices = array_column($product['prices'], 'price');
                                $cheapest = min($prices);
                                ?>

                                <div class="alert alert-success p-2">
                                    Cheapest: $<?= number_format($cheapest, 2) ?>
                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>No products found.</p>

        <?php endif; ?>

    </div>

</main>

</body>
</html>