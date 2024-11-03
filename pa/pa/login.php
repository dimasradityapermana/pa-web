<?php
session_start();
require "connect.php";
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            echo "
            <script>
            alert('Login berhasil!');
            document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Password salah!');
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Username tidak ditemukan!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div> -->

            <p>Belum punya akun? Registrasi di <a href="regist.php"
                    style="color: blue">sini</a></p>

            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </div>


    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>

</html>