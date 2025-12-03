
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) { die("Prepare failed: " . $mysqli->error); }
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found in database.");
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="logo">MY<span>STORE</span></div>
    <nav>
        <ul>
            <li><a href="homePage.html">Home</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="AccountPage.php">Account</a></li>
        </ul>
    </nav>
</header>

<section class="account">
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <h2>Account Options</h2>
    <ul class="account-options">
        <li><a href="editprofile.php">Edit Profile</a></li>
        <li><a href="cartpage.php">My Orders</a></li>
        <li><a href="logout.php" class="btn">Log Out</a></li>
    </ul>
</section>

</body>
</html>
