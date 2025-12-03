<?php
include 'db.php';

$images = [];

$sql = "SELECT image_id, product_id, image_url, is_primary FROM product_images";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($images);

$mysqli->close();
?>
