<?php
require 'connect.php';

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Update status pembayaran menjadi 'paid'
    $updateQuery = "UPDATE transaksi SET status_pembayaran = 'paid' WHERE id_transaksi = $id_transaksi";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Pindahkan data ke tabel 'history'
        $selectQuery = "SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi";
        $selectResult = mysqli_query($conn, $selectQuery);
        $transaksi = mysqli_fetch_assoc($selectResult);

        $user_id = $transaksi['user_id'];
        $tanggal = $transaksi['tanggal'];
        $total_harga = $transaksi['total_harga'];
        $metode_pembayaran = $transaksi['metode_pembayaran'];
        $status_pembayaran = $transaksi['status_pembayaran'];

        $insertQuery = "INSERT INTO history (id_transaksi, user_id, tanggal, total_harga, metode_pembayaran, status_pembayaran) VALUES ('$id_transaksi', '$user_id', '$tanggal', '$total_harga', '$metode_pembayaran', '$status_pembayaran')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Hapus data dari tabel transaksi
            $deleteQuery = "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi";
            $deleteResult = mysqli_query($conn, $deleteQuery);

            if ($deleteResult) {
                echo "
                    <script>
                        alert('Status pembayaran berhasil diubah menjadi paid, data dipindahkan ke history, dan dihapus dari transaksi!');
                        document.location.href = 'konfirmasi.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Gagal menghapus data dari transaksi!');
                        document.location.href = 'konfirmasi.php';
                    </script>
                ";
            }
        } else {
            echo "
                <script>
                    alert('Gagal memindahkan data ke history!');
                    document.location.href = 'konfirmasi.php';
                </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Gagal mengubah status pembayaran!');
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