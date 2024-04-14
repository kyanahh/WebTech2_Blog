<?php

session_start();

require("connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];
    }else{
        $email = "Account";
    }
}else{
    $email = "Account";
}

// Handle post submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["postdesc"]) && !empty(trim($_POST["postdesc"]))) {
        $postdesc = mysqli_real_escape_string($connection, $_POST["postdesc"]);
        $userid = $_SESSION["userid"];

        $insertQuery = "INSERT INTO posts (userid, postdesc) VALUES ($userid, '$postdesc')";
        if (mysqli_query($connection, $insertQuery)) {
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to refresh the page after posting
            exit();
        } else {
            $errorMessage = "Error posting the content.";
        }
    } else {
        $errorMessage = "Please enter something before posting.";
    }
}

// Fetch posts from the database
$query = "SELECT * FROM posts ORDER BY postid DESC";
$result = mysqli_query($connection, $query);

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
                                <a class="nav-link active fw-bold fs-5" aria-current="page">For you</a>
                            </li>

                        </ul>

                    </div>
                </div>
            </nav>    

            <!-- Content -->
            <div class="mx-3" style="height: 540px; overflow-y: auto; overflow-x: hidden;">

                <!-- Post -->
                <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="post">
                <?php
                    if (!empty($errorMessage)) {
                        echo "
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>$errorMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                            ";
                    }
                ?>
                <div class="row p-3">
                    <div class="col-sm-1">
                        <img src="img/blank.jpg" alt="Anonymous" style="height: 50px;" class="rounded">
                    </div>
                    <div class="col-sm-11 mb-3">
                        <textarea class="form-control" id="postdesc" name="postdesc" rows="3" placeholder="What's on your mind?" required></textarea>
                        <div class="d-flex justify-content-end pt-3">
                            <button class="btn btn-light px-3" type="submit">Post</button>
                        </div>
                    </div>
                </div>
                </form>
                <!-- End of Post -->

                <?php
                    // Loop through the posts and display them
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="row border p-3">
                        <div class="col-sm-1">
                            <img src="img/blank.jpg" alt="Anonymous" style="height: 50px;" class="rounded">
                        </div>
                        <div class="col-sm-11">
                            <div class="row">
                                <p class="fw-bold">Anonymous</p>
                            </div>
                            <div class="row">
                                <p><?= $row['postdesc'] ?></p>
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

</body>
</html>
