<?php
// Add a new user to the database. Requires input from register_new_user.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db_connect.php";

$new_username = $_GET['username'];
$new_password1 = $_GET['password1'];
$new_password2 = $_GET['password2'];

echo "<h2>Trying to add a new user " . htmlspecialchars($new_username) . "</h2>";

// Check if this username is already registered
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $new_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "The username " . htmlspecialchars($new_username) . " is already in use. Try another.";
    exit;
}

// Check if the password fields match
if ($new_password1 !== $new_password2) {
    echo "The passwords do not match. Please try again.";
    exit;
} else {
    // Add the new user
    $hashed_password = password_hash($new_password1, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (id, username, password) VALUES (null, '$new_username', '$hashed_password ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $new_username, $hashed_password);
    $result = $stmt->execute();

    if ($result) {
        echo "Registration success!";
    } else {
        echo "Something went wrong. Not registered.";
    }
}

echo "<a href='index.php'>Return to main</a>";
?>

<?php
    echo "You have been logged out<br>";
    $_SESSION = [];
    session_destroy();
?>
<a href="index.php">Return to main page</a>