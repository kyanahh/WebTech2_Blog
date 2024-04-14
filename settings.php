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

$oldpassword = $newpassword = $stored_password = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION["email"];
    $oldpassword = $_POST["oldpassword"];
    $newpassword = $_POST["newpassword"];
    $result = $connection->query("SELECT password FROM users WHERE email = '$email'");
    $record = $result->fetch_assoc();
    $stored_password = $record["password"];
    if ($oldpassword == $stored_password) {
      $connection->query("UPDATE users SET password = '$newpassword' WHERE email = '$email'");
      $errorMessage = "Password changed successfully";
    } else {
      $errorMessage = "Old password does not match";
    }
  }

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
                                <a class="nav-link active fw-bold fs-5" aria-current="page">Settings</a>
                            </li>

                        </ul>

                    </div>
                </div>
            </nav>

            <div class="px-3 pt-4">
                <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">
                    <h2 class="fs-5">Account Information</h2>
                    <div class="col-sm-6 mt-4">
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
                    </div>
                    <div class="row g-3 align-items-center mt-2">
                        <div class="col-auto">
                            <label for="email" class="col-form-label">Email</label>
                        </div>
                        <div class="col-sm-4 ms-5">
                            <input type="email" id="email" class="form-control ms-5" value="<?php echo $email; ?>" disabled readonly>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mt-2">
                        <div class="col-auto">
                            <label for="oldpass" class="col-form-label">Old Password</label>
                        </div>
                        <div class="col-sm-4" style="margin-left: 29px;">
                            <input type="password" id="oldpassword" name="oldpassword" class="form-control ms-2" value="<?php echo $oldpassword; ?>" required>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mt-2">
                        <div class="col-auto">
                            <label for="newpassword" class="col-form-label">New Password</label>
                        </div>
                        <div class="col-sm-4" style="margin-left: 30px;">
                            <input type="password" id="newpassword" name="newpassword" class="form-control" value="<?php echo $newpassword; ?>" required>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-sm-4 d-grid gap-2" style="margin-left: 148px;">
                            <button type="submit" class="btn btn-light fw-bold">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
