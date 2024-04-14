<?php
session_start();

require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["postid"])) {
    $postid = $_GET["postid"];

    // Perform the deletion in the database
    $deleteQuery = "DELETE FROM posts WHERE postid = $postid";
    $result = mysqli_query($connection, $deleteQuery);

    if ($result) {
        // Deletion successful
        header("Location: account.php");
        exit();
    } else {
        // Error occurred during deletion
        echo "Error: " . mysqli_error($connection);
    }
} else {
    // Invalid request
    echo "Invalid request";
}
?>
