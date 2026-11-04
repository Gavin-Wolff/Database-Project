<?php
require_once 'db.php';
session_start();

$storeCount   = $conn->query("SELECT COUNT(*) c FROM store")->fetch_assoc()['c'];
$productCount = $conn->query("SELECT COUNT(*) c FROM item WHERE ItemType='Product'")->fetch_assoc()['c'];
$trending     = $conn->query("SELECT ItemName FROM item WHERE ItemType='Product' ORDER BY ItemID LIMIT 4");
$stores       = $conn->query("SELECT Name, HoursOfOperation FROM store ORDER BY Name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBase Store Finder</title>
    <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container-fluid p-4">

    <!-- Hero search -->
    <div class="gradient-card shadow-sm text-center mb-4">
        <h2 class="fw-bold mb-3">Find the Right Store in Moscow-Pullman</h2>
        <p class="mb-4 fs-5">Enter what you need, and we'll show prices across local stores.</p>
        <form class="row g-3 justify-content-center mx-auto" style="max-width:700px;" method="GET" action="search.php">
            <div class="col-md-8">
                <input type="text" name="keyword" class="form-control form-control-lg rounded-pill px-4" placeholder="What are you looking for? (e.g. Milk)" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark btn-lg rounded-pill w-100 fw-bold">Search</button>
            </div>
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="row g-4 h-100">
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h6 class="text-secondary fw-bold"><i class="bi bi-shop me-2 text-primary"></i>Active Stores</h6>
                        <h2 class="fw-bold mt-2"><?= (int)$storeCount ?></h2>
                        <small class="text-success"><i class="bi bi-check-circle"></i> Connected to Moscow-Pullman grid</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-card">
                        <h6 class="text-secondary fw-bold"><i class="bi bi-box-seam me-2 text-primary"></i>Tracked Products</h6>
                        <h2 class="fw-bold mt-2"><?= (int)$productCount ?></h2>
                        <small class="text-success"><i class="bi bi-check-circle"></i> Inventory synced</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card">
                <h6 class="text-secondary fw-bold mb-3">Trending Local Searches</h6>
                <?php while ($t = $trending->fetch_assoc()) { ?>
                    <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                        <h6 class="mb-0 fw-bold flex-grow-1"><?= $e($t['ItemName']) ?></h6>
                        <a class="btn btn-sm btn-outline-dark rounded-pill" href="search.php?keyword=<?= urlencode($t['ItemName']) ?>">Search</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Browse by store -->
    <h4 class="fw-bold mb-3">Browse by Store</h4>
    <div class="storeGrid">
        <?php if ($stores && $stores->num_rows > 0) { ?>
            <?php while ($s = $stores->fetch_assoc()) { ?>
                <a href="search.php?store=<?= urlencode($s['Name']) ?>" class="storeCard">
                    <h6 class="fw-bold mb-1"><?= $e($s['Name']) ?></h6>
                    <small class="text-muted"><?= $e($s['HoursOfOperation']) ?></small>
                </a>
            <?php } ?>
        <?php } else { ?>
            <p>No stores found.</p>
        <?php } ?>
    </div>
</div>

<footer class="text-center text-muted py-4 small">SmartBase Store Finder &middot; CS 3600</footer>

<?php include 'modals.php'; ?>
</body>
</html>
