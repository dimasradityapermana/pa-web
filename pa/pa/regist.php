<?php
require "connect.php";
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "
        <script>
        alert('Username sudah digunakan! Silakan gunakan username lain.');
        document.location.href = 'regist.php';
        </script>
        ";
    } else {
        $query = "INSERT INTO users (username, password) VALUES ('$username',
        '$password')";
        if (mysqli_query($conn, $query)) {
            echo "
            <script>
            alert('Registrasi berhasil!');
            document.location.href = 'login.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Registrasi gagal!');
            document.location.href = 'index.php';
            </script>
            ";
        }
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
    <title>Registrasi</title>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="login-container">
        <h2>Registrasi Akun</h2>
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

            <p>Sudah punya akun? Login di <a href="login.php"
                    style="color: blue">sini</a></p>

            <div class="form-group">
                <button type="submit" name="submit">Registrasi</button>
            </div>
        </form>
    </div>


    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>

</html>