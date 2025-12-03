<?php
include 'db.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$stmt = $mysqli->prepare("SELECT product_id, name, description, price FROM product WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$product = $result->fetch_assoc();

$img_stmt = $mysqli->prepare("SELECT image_url, is_primary FROM product_images WHERE product_id = ? ORDER BY is_primary DESC");
$img_stmt->bind_param("i", $product_id);
$img_stmt->execute();
$img_result = $img_stmt->get_result();

$images = [];
while ($img = $img_result->fetch_assoc()) {
    $images[] = $img;
}

$product['images'] = $images;
$product['primary_image'] = !empty($images) ? $images[0]['image_url'] : 'images/placeholder.jpg';

header('Content-Type: application/json');
echo json_encode($product);

$stmt->close();
$img_stmt->close();
$mysqli->close();
?>
