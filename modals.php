<?php
// All popup forms + Bootstrap JS. Needs $conn, $loggedIn, $e (from db.php / navbar.php).
?>
<?php if ($loggedIn) { ?>
<!-- ===== Data entry modals: each posts to save_handler.php ===== -->

<div class="modal fade" id="locationModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header bg-light"><h5 class="modal-title fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Location Data Entry</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form class="row g-3" method="post" action="save_handler.php">
            <input type="hidden" name="entity" value="location">
            <div class="col-md-12"><label class="form-label">City</label>
                <select name="city" class="form-select" required><option value="Moscow">Moscow</option><option value="Pullman">Pullman</option></select></div>
            <div class="col-md-6"><label class="form-label">State</label><input name="state" class="form-control" value="Idaho" required></div>
            <div class="col-md-6"><label class="form-label">County</label><input name="county" class="form-control" value="Latah"></div>
            <div class="col-md-4"><label class="form-label">Latitude</label><input name="lat" type="number" step="0.000001" class="form-control" placeholder="46.73238"></div>
            <div class="col-md-4"><label class="form-label">Longitude</label><input name="lng" type="number" step="0.000001" class="form-control" placeholder="-117.0001"></div>
            <div class="col-md-4"><label class="form-label">Timezone</label><input name="tz" class="form-control" value="America/Los_Angeles"></div>
            <div class="col-12 text-end mt-4"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-primary-custom">Save Location</button></div>
        </form>
    </div>
</div></div></div>

<div class="modal fade" id="storeModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header bg-light"><h5 class="modal-title fw-bold"><i class="bi bi-shop me-2 text-primary"></i>Store Data Entry</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form class="row g-3" method="post" action="save_handler.php">
            <input type="hidden" name="entity" value="store">
            <div class="col-md-6"><label class="form-label">Location</label>
                <select name="location_id" class="form-select" required>
                    <?php $locs = $conn->query("SELECT LocationID, City, State FROM location ORDER BY City");
                    while ($l = $locs->fetch_assoc()) { ?>
                        <option value="<?= (int)$l['LocationID'] ?>"><?= $e($l['City'] . ', ' . $l['State']) ?></option>
                    <?php } ?>
                </select></div>
            <div class="col-md-6"><label class="form-label">Store Name</label><input name="name" class="form-control" placeholder="e.g. WinCo Foods" required></div>
            <div class="col-md-4"><label class="form-label">Type</label>
                <select name="type" class="form-select"><option>Grocery</option><option>Convenience</option><option>Pharmacy</option><option>Hardware</option></select></div>
            <div class="col-md-4"><label class="form-label">Price Rating (1-5)</label><input name="price_rating" type="number" min="1" max="5" class="form-control"></div>
            <div class="col-md-4"><label class="form-label">Customer Reviews</label><input name="reviews" type="number" step="0.1" min="0" max="5" class="form-control"></div>
            <div class="col-md-12"><label class="form-label">Hours of Operation</label><input name="hours" class="form-control" placeholder="e.g. 24 Hours or 8AM - 10PM"></div>
            <div class="col-12 text-end mt-4"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-primary-custom">Save Store</button></div>
        </form>
    </div>
</div></div></div>

<div class="modal fade" id="productModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header bg-light"><h5 class="modal-title fw-bold"><i class="bi bi-box me-2 text-primary"></i>Product Item Entry</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form class="row g-3" method="post" action="save_handler.php">
            <input type="hidden" name="entity" value="item">
            <div class="col-md-12"><label class="form-label">Item Name</label><input name="name" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Type</label>
                <select name="item_type" class="form-select"><option>Product</option><option>Category</option></select></div>
            <div class="col-md-6"><label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-select"><option value="">None</option>
                    <?php $cats = $conn->query("SELECT ItemID, ItemName FROM item WHERE ItemType='Category' ORDER BY ItemName");
                    while ($c = $cats->fetch_assoc()) { ?>
                        <option value="<?= (int)$c['ItemID'] ?>"><?= $e($c['ItemName']) ?></option>
                    <?php } ?>
                </select></div>
            <div class="col-md-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
            <div class="col-12 text-end mt-4"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-primary-custom">Save Product</button></div>
        </form>
    </div>
</div></div></div>

<div class="modal fade" id="inventoryModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header bg-light"><h5 class="modal-title fw-bold"><i class="bi bi-tags me-2 text-primary"></i>Store Pricing &amp; Inventory</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">
        <form class="row g-3" method="post" action="save_handler.php">
            <input type="hidden" name="entity" value="storeitem">
            <div class="col-md-6"><label class="form-label">Store</label>
                <select name="store_id" class="form-select" required>
                    <?php $ss = $conn->query("SELECT StoreID, Name FROM store ORDER BY Name");
                    while ($s = $ss->fetch_assoc()) { ?>
                        <option value="<?= (int)$s['StoreID'] ?>"><?= $e($s['Name']) ?></option>
                    <?php } ?>
                </select></div>
            <div class="col-md-6"><label class="form-label">Product</label>
                <select name="item_id" class="form-select" required>
                    <?php $ii = $conn->query("SELECT ItemID, ItemName FROM item WHERE ItemType='Product' ORDER BY ItemName");
                    while ($i = $ii->fetch_assoc()) { ?>
                        <option value="<?= (int)$i['ItemID'] ?>"><?= $e($i['ItemName']) ?></option>
                    <?php } ?>
                </select></div>
            <div class="col-md-12"><label class="form-label">Price ($)</label><input name="price" type="number" step="0.01" min="0" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Stock Status</label>
                <select name="stock" class="form-select"><option>In Stock</option><option>Limited</option><option>Out of Stock</option><option>Unknown</option></select></div>
            <div class="col-md-6"><label class="form-label">Product Rating</label><input name="rating" type="number" step="0.1" min="0" max="5" class="form-control" value="4.0"></div>
            <div class="col-12 text-end mt-4"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-primary-custom">Save Pricing</button></div>
        </form>
    </div>
</div></div></div>

<?php } else { ?>

<div class="modal fade" id="loginModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
    <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Sign In</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body p-4">
        <form method="post" action="login_handler.php">
            <div class="mb-3"><label class="form-label text-muted">Email address</label><input type="email" name="email" class="form-control rounded-3 py-2" placeholder="name@gmail.com" required></div>
            <div class="mb-4"><label class="form-label text-muted">Password</label><input type="password" name="password" class="form-control rounded-3 py-2" required></div>
            <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill">Login</button>
        </form>
    </div>
</div></div></div>

<div class="modal fade" id="registerModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
    <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Create an Account</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body p-4">
        <form method="post" action="registration_handler.php">
            <div class="row g-2 mb-3">
                <div class="col"><label class="form-label text-muted">First Name</label><input name="fname" class="form-control rounded-3 py-2" required></div>
                <div class="col"><label class="form-label text-muted">Last Name</label><input name="lname" class="form-control rounded-3 py-2" required></div>
            </div>
            <div class="mb-3"><label class="form-label text-muted">Email address</label><input type="email" name="email" class="form-control rounded-3 py-2" required></div>
            <div class="mb-4"><label class="form-label text-muted">Password</label><input type="password" name="password" class="form-control rounded-3 py-2" minlength="8" required></div>
            <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill">Sign Up</button>
        </form>
    </div>
</div></div></div>

<?php } ?>

<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Allow links like home.php#login / home.php#register to open the modal
    const m = {'#login': 'loginModal', '#register': 'registerModal'}[location.hash];
    if (m && document.getElementById(m)) new bootstrap.Modal(document.getElementById(m)).show();
</script>
