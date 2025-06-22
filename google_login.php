<?php
// Turn on error reporting for testing purposes. Delete these lines for production code.
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Keeps track of who is logged in.

// This link is required to access the Google login functionality.
// It was added when you ran composer require google/apiclient
require_once('vendor/autoload.php');

// Google API Credentials
$client_id = "4648363211867-5skeduqvshuka0rjunakplb3jct7msd1.apps.googleusercontent.com";
$client_secret = "IuC0xyg-f5LFH6dAwMe6iCWXE";
$redirect_url = "http://localhost/jokes-basic/google_login.php";

// MySQL Database Details
$db_username = "root";
$db_password = "root";
$host_name = "localhost";
$db_name = "jokes_table";
$port = 3306;

// Create a new connection to the Google login service
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_url);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

// Handle different cases based on GET values and session variables

// Case 1 - Logout the user
if (isset($_GET['logout'])) {
    $client->revokeToken($_SESSION['access_token']);
    session_destroy();
    header('Location: index.php');
    exit;
}

// Case 2 - The URL contains a code from the Google login service
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    
    // Sanitize the redirect URL
    $go_here = filter_var($redirect_url, FILTER_SANITIZE_URL);
    header('Location: ' . $go_here);
    exit;
}

// Case 3 - User is logged in
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}

// Case 4 - User is not logged in, display the login page
if (isset($authUrl)) {
    echo "<div align='center'>
            <h1>Login</h1>
            <p>You will need a Google account to use this login</p>
            <a href='{$authUrl}'>Login Here</a>
          </div>";
    exit;
}

// Case 5 - User has been logged in, retrieve data and add to MySQL database
$user = $service->userinfo->get();

// Connect to database
$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name, $port);
if ($mysqli->connect_error) {
    die('Error: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Check if user exists in users table
$stmt = $mysqli->prepare("SELECT id, username, password, google_id, google_name, google_email, google_picture_link FROM users WHERE google_id=?");
$stmt->bind_param("s", $user->id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userid, $username, $password, $google_id, $google_name, $google_email, $google_picture_link);

if ($stmt->num_rows > 0) {
    // Returning user
    echo "<h2>Welcome back " . $user->name . "!</h2>";
    echo "<p><a href='{$redirect_url}?logout=1'>Log Out</a></p>";
    echo "<p><a href='index.php'>Go to main page</a></p>";
    
    while ($stmt->fetch()) {
        echo "<p>According to database records:</p>";
        echo "<br>userid = " . $userid;
        echo "<br>username = " . $username;
        echo "<br>password = " . $password;
        echo "<br>google_id = " . $google_id;
        echo "<br>google_name = " . $google_name;
        echo "<br>google_email = " . $google_email;
        echo "<br>google_picture_link = " . $google_picture_link;
    }

    // Save session variables
    $_SESSION['username'] = $user->name;
    $_SESSION['googleuserid'] = $user->id;
    $_SESSION['useremail'] = $user->email;
    $_SESSION['userid'] = $userid;
} else {
    // New user
    echo "<h2>Welcome " . $user->name . "! Thanks for Registering!</h2>";
    
    // Insert new user into users table
    $statement = $mysqli->prepare("INSERT INTO users (google_id, google_name, google_email, google_picture_link) VALUES (?, ?, ?, ?)");
    $statement->bind_param('ssss', $user->id, $user->name, $user->email, $user->picture);
    $statement->execute();
    $newuserid = $statement->insert_id;
    echo $mysqli->error;
    
    echo "<p>Created new user:</p>";
    echo "New user id = " . $newuserid . "<br>";
    echo "<br>google_id = " . $user->id;
    echo "<br>google_name = " . $user->name;
    echo "<br>google_email = " . $user->email;
    echo "<br>google_picture_link = " . $user->picture;

    $_SESSION['userid'] = $newuserid;
    $_SESSION['username'] = $user->name;
    $_SESSION['googleuserid'] = $user->id;
    $_SESSION['useremail'] = $user->email;
}

// Display user details
echo "<p>About this user:</p>";
echo "<ul>";
echo "<img src='{$user->picture}'/>";
echo "<li>Username: " . $user->name . "</li>";
echo "<li>User ID: " . $_SESSION['userid'] . "</li>";
echo "<li>User Email: " . $user->email . "</li>";
echo "</ul>";

// Final output
echo "<p>Now go check the database to see if the new user has been inserted into the table.</p>";
echo "<a href='index.php'>Return to the main page</a>";
echo "<br>Session values:<br>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<!-- Add some simple styles -->
<style>
    body { font-family: Helvetica, Arial, sans-serif; }
    img { height: 100px; }
</style>

