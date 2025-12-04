<?php
session_start();
include("database.php");

// Get the search query if submitted
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "SELECT * FROM drinks";

// If search is not empty, add a WHERE clause
if (!empty($search)) {
    $sql .= " WHERE 
        product_name LIKE '%$search%' OR 
        product_temp_type LIKE '%$search%' OR 
        subcategory LIKE '%$search%' OR 
        classification LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheDailyGrind System Management</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 6px;
            width: 250px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 6px 12px;
        }
    </style>
</head>

<body>
    <h2>Drink Inventory</h2>

    <!-- Search Form -->
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search drinks..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Temp Type</th>
            <th>Subcategory</th>
            <th>Quantity Inventory</th>
            <th>Base Price</th>
            <th>Classification</th>
            <th>Size Value</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['product_name'] . "</td>
                        <td>" . $row['product_temp_type'] . "</td>
                        <td>" . $row['subcategory'] . "</td>
                        <td>" . $row['quantity_inventory'] . "</td>
                        <td>" . $row['base_price'] . "</td>
                        <td>" . $row['classification'] . "</td>
                        <td>" . $row['size_value'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No drinks found</td></tr>";
        }
        ?>
    </table>
</body>

</html>