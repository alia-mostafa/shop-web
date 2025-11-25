<?php
session_start();
//database connection
$host = "localhost";
$db_user = "root";   
$db_pass = "";       
$db_name = "myapp";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
//retrieve input
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

//check input validation
$errors = [];
if(strlen($username) < 3) $errors[] = "Username must be at least 3 characters.";
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if(strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
if($password !== $password_confirm) $errors[] = "Passwords do not match.";

if(!empty($errors)) {
    foreach($errors as $err) {
        echo $err . "<br>";
    }
    echo '<a href="register.html">Go back</a>';
    exit;
}

//check for existing username or email
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0) {
    echo "Username or Email already exists.<br>";
    echo '<a href="register.html">Go back</a>';
    exit;
}
$stmt->close();
//hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//insert
$stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if($stmt->execute()) {
    //registration 
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;

    echo "Registration successful! <a href='dashboard.php'>Go to Dashboard</a>";
} else {
    echo "Something went wrong, try again.";
}

$stmt->close();
$mysqli->close();
?>
