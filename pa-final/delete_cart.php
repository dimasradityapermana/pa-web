<?php
session_start();

// Cek apakah ada ID produk yang akan dihapus
if (isset($_GET['product_id'])) {
    $product_id_to_remove = (int)$_GET['product_id'];

    // Pastikan produk ada di dalam keranjang sebelum menghapusnya
    if (isset($_SESSION['cart'][$product_id_to_remove])) {
        // Hapus item dari keranjang
        unset($_SESSION['cart'][$product_id_to_remove]);

        // Redirect kembali ke halaman keranjang setelah menghapus produk
        header("Location: cart.php");
        exit;
    } else {
        // Jika produk tidak ditemukan di keranjang
        echo "Produk tidak ditemukan di keranjang.";
    }
} else {
    // Jika tidak ada ID produk yang diberikan
    echo "ID produk tidak valid.";
}
?>
