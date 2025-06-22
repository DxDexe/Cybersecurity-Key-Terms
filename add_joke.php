<?php
// add_joke.php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $joke_question = $_POST['Joke_question'];
    $joke_answer = $_POST['Joke_answer'];

    $stmt = $mysqli->prepare("INSERT INTO jokes (Joke_question, Joke_answer) VALUES (?, ?)");
    $stmt->bind_param("ss", $joke_question, $joke_answer);

    if ($stmt->execute()) {
        echo "New joke added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Invalid request.";
}
?>

