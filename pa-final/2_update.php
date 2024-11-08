<?php
require "connect.php";

$id_stationery = $_GET['id_stationery'];
$query = "SELECT * FROM stationery WHERE id_stationery = $id_stationery";
$result = mysqli_query($conn, $query);

$stationery = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stationery[] = $row;
}

$stationery = $stationery[0];

if (isset($_POST['ubah'])) {
    $name = $_POST['name'];
    $merk = $_POST['merk'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $kategori = $_POST['kategori'];

    $oldimg = $_POST['oldimg'];

    if ($stock <= 0) {
        echo "
            <script>
                alert('Stock tidak boleh kurang dari atau sama dengan 0');
                document.location.href = 'products.php';
            </script>
        ";
        exit;
    }
    if ($_FILES['foto']['error'] === 4) {
        $file_name = $oldimg;
    } 
    else {
        $tmp_name = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];

        $validExtension = ['jpg', 'jpeg', 'png', 'webp'];
        $fileExtension = explode('.', $file_name);
        $fileExtension = strtolower(end($fileExtension));

        if (!in_array($fileExtension, $validExtension)) {
            echo "
                <script>
                    alert('File yang diupload bukan gambar');
                    document.location.href = 'products.php';
                </script>
            ";
            exit;
        }

        if ($_FILES['foto']['size'] > 2000000) {
            echo "
        <script>
        alert('Ukuran gambar lebih dari 2MB, silakan upload gambar lain.');
        document.location.href = 'products.php';
        </script>
        ";
            exit;
        } else {
            date_default_timezone_set('Asia/Makassar');
            $newFileName = date('Y-m-d H.i.s') . '.' . $fileExtension;
            $file_name = $newFileName;
            move_uploaded_file($tmp_name, 'images/' . $file_name);
            unlink('images/' . $oldimg);
        }
    }

    $query = "UPDATE stationery SET name = '$name', merk = '$merk', price = '$price', stock = '$stock', photo= '$file_name', kategori = '$kategori' WHERE id_stationery = $id_stationery";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
                <script>
                    alert('Berhasil mengubah data!');
                    document.location.href = 'products.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('Gagal mengubah data!');
                    document.location.href = 'products.php';
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
    <title>Update Stationery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="assets/logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="btn-back">
        <a href="products.php">
            <button type="button" class="back">
                <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp; Back to Products
            </button>
        </a>
    </div>

    <section class="section-update">
        <div class="update-container">
            <h2>Update Stationery</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="label-field" name="name" value="<?php echo $stationery['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" id="merk" class="label-field" name="merk" value="<?php echo $stationery['merk']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" class="label-field" name="price" value="<?php echo $stationery['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" class="label-field" name="stock" value="<?php echo $stationery['stock']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Category</label>
                    <select name="kategori" id="kategori" required>
                        <option value="kosong" <?php echo $stationery['kategori'] == 'kosong' ? 'selected' : ''; ?>>-</option>
                        <option value="Kertas & Buku" <?php echo $stationery['kategori'] == 'Kertas & Buku' ? 'selected' : ''; ?>>Kertas & Buku</option>
                        <option value="Alat Tulis" <?php echo $stationery['kategori'] == 'Alat Tulis' ? 'selected' : ''; ?>>Alat Tulis</option>
                        <option value="Alat Gambar" <?php echo $stationery['kategori'] == 'Alat Gambar' ? 'selected' : ''; ?>>Alat Gambar</option>
                        <option value="Peralatan Kantor" <?php echo $stationery['kategori'] == 'Peralatan Kantor' ? 'selected' : ''; ?>>Peralatan Kantor</option>
                    </select>
                </div>
                <div class="form-group" style="border: 1px solid rgba(0,0,0,0.6); border-radius:9px; padding: 7px 10px; font-size: 16px;">
                    <label for="foto" class="label-field">Photo</label>
                    <input type="file" name="foto" id="foto">
                    <br>
                    <img src="images/<?php echo $stationery['photo']; ?>" alt="<?php echo $stationery['photo'] ?>" style="width: 80px; height: 100px;">
                </div>
                <input type="hidden" name="oldimg" value="<?php echo $stationery['photo']; ?>">
                <button type="submit" class="btn-crud" name="ubah">Update</button>
            </form>
        </div>
    </section>
</body>

</html>