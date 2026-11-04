<?php
// Shared top bar + flash message. Include right after <body> on every page.
if (session_status() === PHP_SESSION_NONE) session_start();
$loggedIn = isset($_SESSION['uid']);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES);
$page = basename($_SERVER['SCRIPT_NAME']);
?>
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" style="color:#ffbe18;" href="home.php">
            <i class="bi bi-hexagon-fill text-info me-2"></i>SmartBase
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= $page === 'home.php' ? 'active' : '' ?>" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $page === 'search.php' ? 'active' : '' ?>" href="search.php">Search</a></li>

                <?php if ($loggedIn) { /* data-entry menus: logged-in users only */ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Location Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#locationModal"><i class="bi bi-plus-circle me-2"></i>Add/Edit Location</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Store Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#storeModal"><i class="bi bi-shop me-2"></i>Add Store</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Product Data</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#productModal"><i class="bi bi-box me-2"></i>Add Product</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Inventory Pricing</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#inventoryModal"><i class="bi bi-tags me-2"></i>Update Store Item</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <div class="d-flex gap-2 align-items-center">
                <?php if ($loggedIn) { ?>
                    <span class="me-2">Hello, <strong><?= $e($_SESSION['name']) ?></strong></span>
                    <a class="btn btn-outline-dark rounded-pill px-4" href="logout.php">Log Out</a>
                <?php } else { ?>
                    <button class="btn btn-outline-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</button>
                    <button class="btn btn-primary-custom rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#registerModal">Sign Up</button>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<?php if ($flash) { ?>
    <div class="container-fluid px-4 pt-3">
        <div class="alert alert-<?= $e($flash['type']) ?> alert-dismissible fade show mb-0">
            <?= $e($flash['msg']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php } ?>
