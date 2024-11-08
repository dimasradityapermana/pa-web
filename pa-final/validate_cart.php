<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $errors = [];

    $ids = $_POST['id'];  
    $quantities = $_POST['quantity']; 

    foreach ($ids as $index => $product_id) {
        $quantity = $quantities[$index];
        
        $query = "SELECT stock FROM stationery WHERE id_stationery = $product_id";
        $result = mysqli_query($conn, $query);
        $product = mysqli_fetch_assoc($result);

        if ($product['stock'] < $quantity) {
            $errors[] = "Stok untuk produk ID $product_id tidak cukup. Tersedia: " . $product['stock'] . " unit.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: products.php");
        exit();
    }
    foreach ($ids as $index => $product_id) {
        $quantity = $quantities[$index];

        if ($quantity > 0) {
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 0;
            }
            $_SESSION['cart'][$product_id] += $quantity;
        }
    }

    header("Location: cart.php");
    exit();
}
?>
