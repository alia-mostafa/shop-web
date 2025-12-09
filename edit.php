<?php
include("db_connection.php");
$id = $_GET['id'] ?? null;

$sql = "SELECT product_name, quantity, price FROM orders WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
?>
<form action="edit.php?id=<?= $id ?>" method="POST">
    <input type="text" name="product_name" value="<?= $row['product_name'] ?>" required>
    <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required>
    <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>
    <button type="submit" name="update">Update</button>
</form>
<?php
if (isset($_POST['update'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE orders SET product_name=?, quantity=?, price=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sidi", $product_name, $quantity, $price, $id);
    $stmt->execute();

    header("Location: order.php");
    exit;
}


?>


