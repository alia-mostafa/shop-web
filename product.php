<?php
include 'db.php';

//brining data from products table
$query = "SELECT product_id, name, description, price FROM products";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

//getting images for each product
$img_stmt = $mysqli->prepare(
    "SELECT image_url, is_primary 
     FROM product_images 
     WHERE product_id = ? 
     ORDER BY is_primary DESC"
);

//getting items for each product
$items_stmt = $mysqli->prepare(
    "SELECT item_id, serial_number, status 
     FROM items 
     WHERE product_id = ?"
);

$products = [];
//fetching products
while ($row = $result->fetch_assoc()) {

    $product_id = $row['product_id'];

    // Fetch images
    $img_stmt->bind_param("i", $product_id);
    $img_stmt->execute();
    $img_result = $img_stmt->get_result();

    $images = [];
    while ($img = $img_result->fetch_assoc()) {
        $images[] = $img;
    }
    $row['images'] = $images;
    $row['primary_image'] = $images[0]['image_url'] ?? 'placeholder.jpg';

    // Fetch items
    $items_stmt->bind_param("i", $product_id);
    $items_stmt->execute();
    $items_result = $items_stmt->get_result();

    $items = [];
    while ($item = $items_result->fetch_assoc()) {
        $items[] = $item;
    }
    $row['items'] = $items;

    $products[] = $row;
}


echo json_encode($products);

// Closing statements and connection
$stmt->close();
$img_stmt->close();
$items_stmt->close();
$mysqli->close();
?>
