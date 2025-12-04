<?php
include("database.php");

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "SELECT * FROM drinks";

if (!empty($search)) {
    $sql .= " WHERE 
        product_name LIKE '%$search%' OR 
        product_temp_type LIKE '%$search%' OR 
        subcategory LIKE '%$search%' OR 
        classification LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['product_temp_type']}</td>
                <td>{$row['subcategory']}</td>
                <td>{$row['quantity_inventory']}</td>
                <td>{$row['base_price']}</td>
                <td>{$row['classification']}</td>
                <td>{$row['size_value']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No drinks found</td></tr>";
}
