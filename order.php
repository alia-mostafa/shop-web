<?php
include "db_connection.php";

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $deleteQuery = "DELETE FROM orders WHERE id = ?";
    $stmt = $mysqli->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: order.php");
    exit;
}

// Fetch users
$query = "SELECT id, product_name, quantity, price, order_date FROM orders";
$result = $mysqli->query($query);
?>

<link rel="stylesheet" href="css/style.css">

<h2>Orders</h2>


<table>
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Order Date</th>
        <th>Actions</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td>
                    <a class="btn" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn btn-danger" href="order.php?delete=<?= $row['id'] ?>"
                        onclick="return confirm('Are you sure you want to delete this order?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align:center;">No users found</td>
        </tr>
    <?php endif; ?>
</table>