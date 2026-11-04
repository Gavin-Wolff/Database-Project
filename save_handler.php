<?php
// Receives the data-entry modals from home.php and writes them to MySQL.
session_start();
require_once 'db.php';

function back($type, $msg) {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
    header("Location: home.php");
    exit;
}

if (!isset($_SESSION['uid']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    back('danger', 'Please sign in first.');
}

// empty string -> NULL for optional fields
$nul = fn($k) => (isset($_POST[$k]) && $_POST[$k] !== '') ? $_POST[$k] : null;

try {
    switch ($_POST['entity'] ?? '') {
        case 'location':
            $stmt = $conn->prepare(
                "INSERT INTO location (City, State, County, Latitude, Longitude, Timezone) VALUES (?,?,?,?,?,?)
                 ON DUPLICATE KEY UPDATE County=VALUES(County), Latitude=VALUES(Latitude),
                                         Longitude=VALUES(Longitude), Timezone=VALUES(Timezone)");
            $city = $_POST['city']; $state = $_POST['state'];
            $county = $nul('county'); $lat = $nul('lat'); $lng = $nul('lng'); $tz = $nul('tz');
            $stmt->bind_param("sssdds", $city, $state, $county, $lat, $lng, $tz);
            break;

        case 'store':
            $stmt = $conn->prepare("INSERT INTO store (LocationID, Name, Type, PriceRating, HoursOfOperation, CustomerReviews) VALUES (?,?,?,?,?,?)");
            $loc = (int)$_POST['location_id']; $name = $_POST['name']; $type = $_POST['type'];
            $pr = $nul('price_rating'); $hours = $nul('hours'); $rev = $nul('reviews');
            $stmt->bind_param("issisd", $loc, $name, $type, $pr, $hours, $rev);
            break;

        case 'item':
            $stmt = $conn->prepare("INSERT INTO item (ParentItemID, ItemName, Description, ItemType) VALUES (?,?,?,?)");
            $parent = $nul('parent_id'); $name = $_POST['name']; $desc = $nul('description');
            $type = $_POST['item_type'] === 'Category' ? 'Category' : 'Product';
            $stmt->bind_param("isss", $parent, $name, $desc, $type);
            break;

        case 'storeitem':
            $stmt = $conn->prepare(
                "INSERT INTO storeitem (StoreID, ItemID, Price, StockStatus, ProductRating) VALUES (?,?,?,?,?)
                 ON DUPLICATE KEY UPDATE Price=VALUES(Price), StockStatus=VALUES(StockStatus), ProductRating=VALUES(ProductRating)");
            $sid = (int)$_POST['store_id']; $iid = (int)$_POST['item_id'];
            $price = $_POST['price']; $stock = $_POST['stock']; $rating = $nul('rating') ?? 4.0;
            $stmt->bind_param("iidsd", $sid, $iid, $price, $stock, $rating);
            break;

        default:
            back('danger', 'Unknown form.');
    }
    $stmt->execute();
    back('success', 'Saved to the database.');
} catch (mysqli_sql_exception $ex) {
    back('danger', 'Database error: ' . $ex->getMessage());
}
