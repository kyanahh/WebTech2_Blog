<?php

include("connection.php");

$errorMessage = $successMessage = "";

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $record = $result->fetch_assoc();
        $_SESSION["name"] = $record["fullname"];
        $_SESSION["email"] = $record["email"];
        $_SESSION["userid"] = $record["userid"];
        $_SESSION["logged_in"] = true;
        $_SESSION["profilepic"] = $record["profilepic"];

        header('Location: index.php');
        exit();
    } else {
        $errorMessage = "Incorrect email or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Diaries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body class="bg-black">

    <div class="container">
        <div class="row">
            <div class="col">
                <img src="img/BD.png" alt="BD LOGO" class="mt-5">
            </div>
            <div class="col-sm-5">
                <div class="border rounded p-4" style="margin-top: 90px;">
                    <!-- Sign in -->
                    <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">
                        <h3 class="text-white fw-bold">Sign in to BD</h3>
                        <div class="mb-3">
                            <label for="email" class="form-label text-white fw-bold">Email</label>
                            <input type="email" class="form-control bg-black text-white" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-white fw-bold">Password</label>
                            <input type="password" class="form-control bg-black text-white" id="password" name="password" placeholder="Enter password" required>
                            <?php
                                if (!empty($errorMessage)) {
                                    echo "
                                    <div>
                                        <p class='text-danger mt-1 ms-1'>$errorMessage</p>
                                    </div>
                                    ";
                                }
                            ?>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-secondary text-black fw-bold" type="submit">Sign in</button>
                        </div>
                    </form>
                    <!-- Or -->
                    <div class="row">
                        <div class="col">
                            <hr class="text-white">
                        </div>
                        <div class="col-sm-1">
                            <h6 class="text-white mt-1">or</h6>
                        </div>
                        <div class="col">
                            <hr class="text-white">
                        </div>
                    </div>
                    <!-- Sign up directory -->
                    <div class="d-grid gap-2">
                        <h6 class="text-white fw-bold text-center">Don't have an account yet?</h6>
                        <a class="btn btn-outline-light fw-bold" href="signup.php">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>