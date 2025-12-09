<?php
include "db_connection.php";

$sql2 = "
CREATE TABLE IF NOT EXISTS p (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
";


$sql3 = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
";

$tables = [
    "app_users" => $sql1,
    "p" => $sql2,
    "orders" => $sql3
];

foreach ($tables as $name => $query) {
    if ($mysqli->query($query)) {
        echo "Table '$name' created successfully.<br>";
    } else {
        echo "Error creating $name: " . $mysqli->error . "<br>";
    }
}

$mysqli->close();
?>
