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
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>Smartbase Store Finder</h1>
        <p>Find products and compare stores.</p>
    </header>

    <main>

        <h2>Select a Store</h2>

        <table>
            <?php
            $columnCount = 0;

            //make sure there are database results.
            if ($result && $result->num_rows > 0) {


                while ($store = $result->fetch_assoc()) {

                    // start of row every three columns
                    if ($columnCount % 3 == 0) {
                        echo "<tr>";
                    }
            ?>

                <!-- each store in their card -->
                <td>
                    <a href="search.php?store=<?php echo urlencode($store['Name']); ?>">
                        <h3><?php echo htmlspecialchars($store['Name']); ?></h3>
                    </a>
                    <!-- store hours under the name -->
                    <p><?php echo htmlspecialchars($store['HoursOfOperation']); ?></p>
                </td>

            <?php
                    $columnCount++;

                    // end of row every three columns
                    if ($columnCount % 3 == 0) {
                        echo "</tr>";
                    }
                }

                // end of last row if it has less than three stores
                if ($columnCount % 3 != 0) {
                    echo "</tr>";
                }

            } else {
                echo "<tr><td>No stores found.</td></tr>";
            }
            ?>
        </table>

    </main>

    <footer>
        <p>Smartbase Store Finder</p>
    </footer>

</body>
</html>