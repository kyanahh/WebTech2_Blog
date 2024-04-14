<?php
session_start();

require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["postid"])) {
    $postid = $_POST["postid"];

    // Display a confirmation alert using JavaScript
    echo "<script>
            var confirmation = confirm('Are you sure you want to delete this post?');
            if (confirmation) {
                // If the user confirms, proceed with the deletion
                window.location.href = 'delete_post_confirm.php?postid=$postid';
            } else {
                // If the user cancels, redirect back to the account page
                window.location.href = 'account.php';
            }
         </script>";
} else {
    // Invalid request
    echo "Invalid request";
}
?>
