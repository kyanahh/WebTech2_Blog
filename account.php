<?php

session_start();

require("connection.php");

$errorMessage = "";

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["email"]) && isset($_SESSION["name"])){
        $email = $_SESSION["email"];
        $fullname = $_SESSION["name"];
        $userid = $_SESSION["userid"];

        // Fetch posts for the specific user from the database
        $query = "SELECT * FROM posts WHERE userid = $userid ORDER BY postid DESC";
        $result = mysqli_query($connection, $query);

        // Count the number of posts
        $postCount = mysqli_num_rows($result);

        // File upload handling
        if(isset($_FILES["profilepic"])) {
            $targetDirectory = "profile_pictures/";
            $targetFile = $targetDirectory . basename($_FILES["profilepic"]["name"]);

            // Check if the uploaded file is an image
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $targetFile)) {
                    // Update the profile picture path in the database
                    $updateQuery = "UPDATE users SET profilepic = '$targetFile' WHERE email = '$email'";
                    $connection->query($updateQuery);
                    $_SESSION["profilepic"] = $targetFile;
                    // Redirect to the profile page or wherever you want
                    header("Location: account.php");
                } else {
                    $errorMessage = "Failed to upload file.";
                }
            } else {
                $errorMessage = "Invalid file format. Please upload an image (jpg, jpeg, png, or gif).";
            }
        }
    } else {
        $email = "Account";
    }
} else {
    $email = "Account";
}


// Fetch user information including the profile picture path
$userQuery = "SELECT profilepic FROM users WHERE email = '$email'";
$userResult = mysqli_query($connection, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$profilepic = $userData['profilepic'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"> 
  <link rel="stylesheet" href="index.css">
  <title>Blog Diaries</title>
</head>
<body class="bg-black text-white">

<div class="main-container container d-flex">
        <div class="sidebar" id="side_nav">
            <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
                <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-2 me-2">BD</span> <span
                        class="text-white">Blog Diaries</span></h1>
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i
                        class="fal fa-stream"></i></button>
            </div>

            <ul class="list-unstyled px-2">

                <li>
                    <a href="index.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="bi bi-house-door-fill me-2"></i> Home
                    </a>
                </li>

                <li>
                    <a href="account.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="bi bi-person-fill me-2"></i> My Account
                    </a>
                </li>

                <li>
                    <a href="profilepic.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-person-square me-2"></i> Edit Profile
                    </a>
                </li>

                <li>
                    <a href="settings.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="bi bi-gear-fill me-2"></i> Settings
                    </a>
                </li>

                <li>
                    <a href="logout.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </li>

            </ul>

        </div>
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-dark bg-black mt-2">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between d-md-none d-block">
                     <button class="btn px-1 py-0 open-btn me-2"><i class="fal fa-stream"></i></button>
                        <a class="navbar-brand fs-4" href="#"><span class="bg-dark rounded px-2 py-0 text-white">CL</span></a>
                       
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fal fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold fs-5" aria-current="page"><?php echo $fullname; ?></a>
                                <p class="ps-2"><?= $postCount ?> posts</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>

            <div style="height: 500px; overflow-y: auto; overflow-x: hidden;">
                <!-- Profile Picture -->
                <div class="ms-3 mb-3" style="width: 300px;">                
                    <img src="<?php echo $profilepic; ?>" class="rounded mt-3" alt="Profile Picture" style="height: 25vh;">
                    <h5 class="pt-3 fw-bold"><?php echo $fullname; ?></h5>
                </div>
                <!-- End of Profile Pic -->

                <div>
                    <hr>
                    <p class="ms-2">Posts</p>
                </div>

                <!-- Content -->
                <div>
                    
                    <?php
                        // Loop through the posts and display them
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="row border p-3">
                            <div class="col-sm-1">
                                <img src="<?php echo $profilepic; ?>" alt="Anonymous" style="height: 50px;" class="rounded">
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                        <p class="fw-bold"><?php echo $fullname; ?></p>
                                </div>
                                <div class="row">
                                    <p><?= $row['postdesc'] ?></p>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-end">
                                        <form action="delete_post.php" method="post">
                                        <!-- Form for Delete -->
                                            <input type="hidden" name="postid" value="<?php echo $row['postid']; ?>">
                                            <button type="submit" class="btn"><i class="bi bi-trash text-danger"></i></button>
                                        </form>
                                        <!-- End of Form -->
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    <?php
                        }
                    ?>

                </div>
                <!-- End of Content -->
            </div>
        </div>
    </div>

</body>
</html>
