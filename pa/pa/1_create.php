<?php
require "connect.php";

if (isset($_POST['tambah'])) {
    $name = $_POST['name'];
    $merk = $_POST['merk'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $tmp_name = $_FILES['foto']['tmp_name'];
    $file_name = $_FILES['foto']['name'];

    $validExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    $fileExtension = explode('.', $file_name);
    $fileExtension = strtolower(end($fileExtension));


    if (!in_array($fileExtension, $validExtensions)) {
        echo "
            <script>
                alert('File yang diupload bukan gambar!');
                document.location.href = '1_create.php';
            </script>
        ";
    } 

    else if ($_FILES['foto']['size'] > 2000000) {
        echo "
            <script>
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                document.location.href = '1_create.php';
            </script>
        ";
    }

    else {
        date_default_timezone_set('Asia/Makassar');
        $newFileName = date('Y-m-d H.i.s') . '.' . $fileExtension;
        $file_name = $newFileName;

        if (move_uploaded_file($tmp_name, 'images/' . $file_name)) {
            $query = "INSERT into stationery values ('', '$name', '$merk', '$price', '$stock', '$file_name')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "
                <script>
                    alert('Berhasil menambah data!');
                    document.location.href = 'products.php';  
                </script>  
                ";
            } else {
                echo "
                <script>
                    alert('Gagal menambah data!');
                    document.location.href = 'products.php'; 
                </script>   
                ";
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
    <title>Insert Stationery</title>
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
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <main>
        <div class="login-container">
            <h2>Insert Stationery</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="label-field">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="merk" class="label-field">Merk</label>
                    <input type="text" name="merk" id="merk" required>
                </div>
                <div class="form-group">
                    <label for="price" class="label-field">Price</label>
                    <input type="number" name="price" id="price" required>
                </div>
                <div class="form-group">
                    <label for="stock" class="label-field">Stock</label>
                    <input type="number" name="stock" id="stock" required>
                </div>
                <div class="form-group">
                    <label for="foto" class="label-field">Foto</label>
                    <input type="file" name="foto" id="foto" style="border: 1px solid rgba(0,0,0,0,6); border-radius: 9px; padding: 7 px 10px; font-size: 16px;" required>
                </div>
                <input type="submit" value="Add" name="tambah" class="button-crud">
            </form>
        </div>
    </main>
</body>

</html>