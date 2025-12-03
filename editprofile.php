<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']); 

   
    if (empty($new_username) || empty($new_email) || empty($new_password)) {
        die("All fields are required, including password.");
    }
    $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);


    $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("sssi", $new_username, $new_email, $hashed_pass, $user_id);
    $stmt->execute();

    
    $_SESSION['username'] = $new_username;

    header("Location: AccountPage.php");
    exit();
}



$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

<section class="edit-profile">
    <h1>Edit Profile</h1>

    <form class="edit-form" method="POST">
        <label>User name</label>
        <input type="text" name="username" placeholder="enter your name" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="enter your email"  required >

        <label>New Password</label>
        <input type="password" name="password" placeholder="Enter your new password"  required>

        <button type="submit" class="btn">Save Changes</button>
    </form>
</section>

</body>
</html>
