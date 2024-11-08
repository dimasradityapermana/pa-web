<?php
require "connect.php";

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Find the transaction
    $findQuery = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi");
    $transaksi = [];
    while ($trd = mysqli_fetch_assoc($findQuery)) {
        $transaksi[] = $trd;
    }

    // Delete the transaction
    $query = "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
            <script>
                alert('Berhasil menghapus data!');
                document.location.href = 'konfirmasi.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Gagal menghapus data!');
                document.location.href = 'konfirmasi.php';
            </script>
            ";
    }
} else {
    echo "
        <script>
            alert('ID Transaksi tidak ditemukan!');
            document.location.href = 'konfirmasi.php';
        </script>
        ";
}
?>