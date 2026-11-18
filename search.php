<?php
require_once 'db.php';

// Get the search keyword
$keyword = $_GET['keyword'] ?? '';
$selectedCity = $_GET['city'] ?? '';
$selectedState = $_GET['state'] ?? '';
$selectedCounty = $_GET['county'] ?? '';
$selectedPriceRating = $_GET['priceRating'] ?? '';
$selectedStockStatus = $_GET['stockStatus'] ?? '';

// Get available cities
$cities = $conn->query(
    "SELECT DISTINCT City FROM location ORDER BY City"
);

// Get available states
$states = $conn->query(
    "SELECT DISTINCT State FROM location ORDER BY State"
);

// Get available counties
$counties = $conn->query(
    "SELECT DISTINCT County FROM location
     WHERE County IS NOT NULL
     ORDER BY County"
);

// Get available price ratings
$priceRatings = $conn->query(
    "SELECT DISTINCT PriceRating FROM store
     WHERE PriceRating IS NOT NULL
     ORDER BY PriceRating"
);

// Get available stock statuses
$stockStatuses = $conn->query(
    "SELECT DISTINCT StockStatus FROM storeitem
     WHERE StockStatus IS NOT NULL
     ORDER BY StockStatus"
);

// Get all stores
$storeResult = $conn->query("SELECT StoreID, Name FROM store ORDER BY Name");

$stores = [];

while ($store = $storeResult->fetch_assoc()) {
    $stores[] = $store;
}

// Get selected store IDs from the filter
$selectedStores = $_GET['stores'] ?? [];

if (!is_array($selectedStores)) {
    $selectedStores = [];
}

$selectedStores = array_values(
    array_filter(
        array_map('intval', $selectedStores),
        fn($id) => $id > 0
    )
);

// If the user clicked a store on the home page, select it
if (isset($_GET['store']) && empty($selectedStores)) {
    foreach ($stores as $store) {
        if ($store['Name'] == $_GET['store']) {
            $selectedStores[] = $store['StoreID'];
        }
    }
}

// Search for products
$sql = "WITH RECURSIVE category_tree AS (
            -- Find categories matching the search
            SELECT ItemID
            FROM item
            WHERE ItemType = 'Category'
            AND ItemName LIKE ?

            UNION

            -- Find all children of matching categories
            SELECT child.ItemID
            FROM item child
            JOIN category_tree parent
                ON child.ParentItemID = parent.ItemID

        ),
        -- Find products matching the keyword
        -- OR products belonging to matching categories
        matching_products AS (

            SELECT ItemID
            FROM item
            WHERE ItemType = 'Product'
            AND ItemName LIKE ?

            UNION

            SELECT i.ItemID
            FROM item i
            JOIN category_tree c
                ON i.ItemID = c.ItemID
            WHERE i.ItemType = 'Product'

        )
        SELECT
            item.ItemID,
            item.ItemName,
            item.Description,
            store.StoreID,
            store.Name,
            store.PriceRating,
            location.City,
            location.State,
            location.County,
            storeitem.Price,
            storeitem.StockStatus

        FROM matching_products

        JOIN item
            ON matching_products.ItemID = item.ItemID

        LEFT JOIN storeitem
            ON item.ItemID = storeitem.ItemID

        LEFT JOIN store
            ON storeitem.StoreID = store.StoreID

        LEFT JOIN location
            ON store.LocationID = location.LocationID

        WHERE 1=1
    ";

// Start with the two keyword parameters from the recursive query
$search = "%$keyword%";

$params = [$search, $search];
$types = "ss";

// Filter by selected stores
if (!empty($selectedStores)) {
    $placeholders = implode(
        ',',
        array_fill(0, count($selectedStores), '?')
    );

    $sql .= " AND store.StoreID IN ($placeholders)";

    foreach ($selectedStores as $storeID) {
        $params[] = (int)$storeID;
        $types .= "i";
    }
}

// Filter by city
if ($selectedCity != '') {
    $sql .= " AND location.City = ?";
    $params[] = $selectedCity;
    $types .= "s";
}

// Filter by state
if ($selectedState != '') {
    $sql .= " AND location.State = ?";
    $params[] = $selectedState;
    $types .= "s";
}

// Filter by county
if ($selectedCounty != '') {
    $sql .= " AND location.County = ?";
    $params[] = $selectedCounty;
    $types .= "s";
}

// Filter by price rating
if ($selectedPriceRating != '') {
    $sql .= " AND store.PriceRating = ?";
    $params[] = (int)$selectedPriceRating;
    $types .= "i";
}

// Filter by stock status
if ($selectedStockStatus != '') {
    $sql .= " AND storeitem.StockStatus = ?";
    $params[] = $selectedStockStatus;
    $types .= "s";
}

$sql .= " ORDER BY item.ItemName";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind all parameters
$bindParams = [$types];

foreach ($params as $key => $value) {
    $bindParams[] = &$params[$key];
}

call_user_func_array([$stmt, 'bind_param'], $bindParams);

// Execute the query
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
<header class="bg-success text-white p-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-white">Smartbase Store Finder</h1>

            <nav class="d-flex gap-5">
                <a href="index.php" class="text-white text-decoration-none">
                    Home
                </a>

                <a href="login.php" class="text-white text-decoration-none">
                    Log In
                </a>

                <a href="register.php" class="text-white text-decoration-none">
                    Register
                </a>
            </nav>
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

                <h5>Filters</h5>

                <div class="row g-3">

                    <!-- City Filter -->
                    <div class="col-md-4">
                        <label for="city" class="form-label">City</label>

                        <select name="city" id="city" class="form-select">
                            <option value="">All Cities</option>

                            <?php while ($city = $cities->fetch_assoc()): ?>

                                <option value="<?= htmlspecialchars($city['City']) ?>"
                                    <?= $selectedCity == $city['City'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($city['City']) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>


                    <!-- State Filter -->
                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>

                        <select name="state" id="state" class="form-select">
                            <option value="">All States</option>

                            <?php while ($state = $states->fetch_assoc()): ?>

                                <option value="<?= htmlspecialchars($state['State']) ?>"
                                    <?= $selectedState == $state['State'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($state['State']) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>


                    <!-- County Filter -->
                    <div class="col-md-4">
                        <label for="county" class="form-label">County</label>

                        <select name="county" id="county" class="form-select">
                            <option value="">All Counties</option>

                            <?php while ($county = $counties->fetch_assoc()): ?>

                                <option value="<?= htmlspecialchars($county['County']) ?>"
                                    <?= $selectedCounty == $county['County'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($county['County']) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>


                    <!-- Price Rating Filter -->
                    <div class="col-md-6">
                        <label for="priceRating" class="form-label">
                            Price Rating
                        </label>

                        <select name="priceRating" id="priceRating" class="form-select">
                            <option value="">All Price Ratings</option>

                            <?php while ($rating = $priceRatings->fetch_assoc()): ?>

                                <option value="<?= $rating['PriceRating'] ?>"
                                    <?= $selectedPriceRating == $rating['PriceRating'] ? 'selected' : '' ?>>

                                    <?= $rating['PriceRating'] ?>

                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>


                    <!-- Stock Status Filter -->
                    <div class="col-md-6">
                        <label for="stockStatus" class="form-label">
                            Stock Status
                        </label>

                        <select name="stockStatus" id="stockStatus" class="form-select">
                            <option value="">All Stock Statuses</option>

                            <?php while ($status = $stockStatuses->fetch_assoc()): ?>

                                <option value="<?= htmlspecialchars($status['StockStatus']) ?>"
                                    <?= $selectedStockStatus == $status['StockStatus'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($status['StockStatus']) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>

                </div>

                <hr>

                <h5>Filter by Store</h5>

                <!-- Keep your existing store checkboxes here -->

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