<?php


$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "coffee_shop_db";
$db_port = 3307;  

try {
    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name, $db_port);

} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>