<?php
require 'function.php';
// Proses Login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cekdatabase = mysqli_query($conn, "SELECT * FROM `login` WHERE  email='$email' and password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);
	// Hasil Login
    if ($hitung > 0) {
        $_SESSION['log'] = 'true';
        header('location:index.php');
    } else {
        header('location:login.php');
    }
};
if (!isset($_SESSION['log'])) {
} else {
    header('location:index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="web_inventaris/CSS/styles.css" rel="stylesheet" />
    <script src="web_inventaris/js/scripts.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card-header h3 {
            color: #333;
        }

        .btn-primary {
            background-color: #667eea;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a67d8;
        }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center" style="background-color: #ffffff; border-radius: 10px 10px 0 0;">
                                    <h3 class="font-weight-light my-4" style="color: #333;">Login</h3>
                                </div>
                                <div class="card-body" style="background-color: #f9f9f9;">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress" style="color: #333;">Email</label>
                                            <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword" style="color: #333;">Password</label>
                                            <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary btn-block" name="login" type="submit" style="background-color: #007bff; border: none;">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>