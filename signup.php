<?php

include("connection.php");

$name = $email = $password = $errorMessage = $successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        $errorMessage = "All fields are required";
    } else {
        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = $connection->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            $errorMessage = "Email already exists";
        } else {
            // Insert the new user into the database
            $insertQuery = "INSERT INTO users (fullname, email, password) VALUES('$name', '$email', '$password')";
            $result = $connection->query($insertQuery);

            if (!$result) {
                $errorMessage = "Invalid query " . $connection->error;
            } else {
                header("location: signupconfirm.html");
                exit;
            }
        }
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
                <div class="border rounded p-4" style="margin-top: 60px;">
                    <!-- Sign Up -->
                    <form action="<?php htmlspecialchars("SELF_PHP"); ?>" method="POST">
                        <h3 class="fw-bold text-white">Create your account</h3>
                        <div class="mb-3">
                            <label for="name" class="form-label text-white fw-bold">Name</label>
                            <input type="text" class="form-control bg-black text-white" id="name" name="name" value="<?php echo $name ?>" placeholder="Enter name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-white fw-bold">Email</label>
                            <input type="email" class="form-control bg-black text-white" id="email" name="email" value="<?php echo $email ?>" placeholder="Enter email" required>
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
                        <div class="mb-3">
                            <label for="password" class="form-label text-white fw-bold">Password</label>
                            <input type="password" class="form-control bg-black text-white" id="password" name="password" value="<?php echo $password ?>" placeholder="Enter password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-secondary text-black fw-bold" type="submit">Sign up</button>
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
                    <!-- Login directory -->
                    <div class="d-grid gap-2">
                        <h6 class="text-white fw-bold text-center">Already have an account?</h6>
                        <a class="btn btn-outline-light fw-bold" href="signin.php">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>