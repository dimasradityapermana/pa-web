<?php
require "connect.php";
$id_stationery = $_GET['id_stationery'];

$findQuery = mysqli_query($conn, "SELECT * FROM stationery WHERE id_stationery = $id_stationery");
$stationery = [];
while ($stry = mysqli_fetch_assoc($findQuery)) {
    $stationery[] = $stry;
}

unlink('images/' . $stationery[0]['photo']);

    $query = "DELETE FROM stationery WHERE id_stationery = $id_stationery";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
            <script>
                alert('Berhasil menghapus data!');
                document.location.href = 'products.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data!');
                document.location.href = 'products.php';
            </script>
            ";
    }
