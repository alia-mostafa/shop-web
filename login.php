<?php
include 'db.php';


//input retrieval
$user_input = trim($_POST['user_input'] ?? '');
$password = $_POST['password'] ?? '';

//check input validation
$errors = [];
if(empty($user_input)) $errors[] = "Email or Username is required.";
if(empty($password)) $errors[] = "Password is required.";

if(!empty($errors)) {
    foreach($errors as $err) {
        echo $err . "<br>";
    }
    echo '<a href="login.html">Go back</a>';
    exit;
}
//user lookup
$stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1");
$stmt->bind_param("ss", $user_input, $user_input);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows == 0){
    echo "User not found. <a href='login.html'>Try again</a>";
    exit;
}

//get user data
$stmt->bind_result($id, $username, $hashed_password);
$stmt->fetch();

//check password
if(password_verify($password, $hashed_password)){
    //login successful
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;

    echo "Login successful! <a href='dashboard.php'>Go to Dashboard</a>";
} else {
    echo "Incorrect password. <a href='login.html'>Try again</a>";
}

$stmt->close();
$mysqli->close();
?>
