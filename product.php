<?php
include 'db.php';

$query = "SELECT product_id, name, description, price FROM product";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Prepare image statement once
$img_stmt = $mysqli->prepare("SELECT image_url, is_primary FROM product_images WHERE product_id = ? ORDER BY is_primary DESC");

$products = [];

while($row = $result->fetch_assoc()) {

    $product_id = $row['product_id'];

    // Bind and execute image query
    $img_stmt->bind_param("i", $product_id);
    $img_stmt->execute();
    $img_result = $img_stmt->get_result();

    $images = [];
    while($img = $img_result->fetch_assoc()) {
        $images[] = $img;
    }

    $row['images'] = $images;
    $row['primary_image'] = $images[0]['image_url'] ?? 'placeholder.jpg';

    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$img_stmt->close();
$mysqli->close();
?>
