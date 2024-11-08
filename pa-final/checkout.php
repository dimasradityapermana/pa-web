<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "Anda harus login untuk melakukan checkout.";
    exit;
}

$user_id = $_SESSION['username'];
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];
$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_products']) && !empty($_POST['selected_products'])) {
    $selected_product_ids = (array)$_POST['selected_products']; 
    $product_ids = implode(',', array_map('intval', $selected_product_ids)); 
    $query = "SELECT * FROM stationery WHERE id_stationery IN ($product_ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['id_stationery'];
        $products[$product_id] = $row;
        $products[$product_id]['quantity'] = $cart_items[$product_id];
        $total_price += $row['price'] * $cart_items[$product_id];
    }

    if (empty($products)) {
        echo "Tidak ada produk yang dipilih untuk checkout.";
        exit;
    }
} else {
    echo "Tidak ada produk yang dipilih untuk checkout.";
    exit;
}

if (isset($_POST['confirm_checkout'])) {
    $payment_method = $_POST['payment_method'];

    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO transaksi (user_id, total_harga, metode_pembayaran, status_pembayaran, tanggal) VALUES (?, ?, ?, 'Pending', NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sds", $user_id, $total_price, $payment_method);
        mysqli_stmt_execute($stmt);
        $transaction_id = mysqli_insert_id($conn);

        foreach ($products as $product_id => $product) {
            $quantity = $product['quantity'];

            $query = "INSERT INTO transaksi_detail (id_transaksi, id_stationery, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iiid", $transaction_id, $product_id, $quantity, $product['price']);
            mysqli_stmt_execute($stmt);

            $query = "UPDATE stationery SET stock = stock - ? WHERE id_stationery = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $quantity, $product_id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_commit($conn);
        $_SESSION['cart'] = [];
        echo "<script>alert('Pembelian berhasil!');</script>";
        header("Location: products.php");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Terjadi kesalahan, transaksi dibatalkan: " . $e->getMessage();
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="icon" href="assets/logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/body.css">
</head>

<body>
    <div class="cart-container">
        <h1 class="cart-title">Checkout</h1>
        <form action="checkout.php" method="post">
            <table class="cart-table">
                <tr class="cart-table-header">
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($products as $product) : ?>
                    <tr class="cart-table-row">
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['price']); ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo number_format($product['price'] * $product['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="cart-total-row">
                    <td colspan="3"><strong>Total Keseluruhan</strong></td>
                    <td><strong><?php echo number_format($total_price); ?></strong></td>
                </tr>
            </table>
            <?php foreach ($products as $product_id => $product) : ?>
                <input type="hidden" name="selected_products[]" value="<?php echo $product_id; ?>">
            <?php endforeach; ?>
            <h2>Choose Payment Method</h2>
            <div class="checkout-styling">
                <div class="radio-styling">
                    <input type="radio" id="ovo" name="payment_method" value="OVO" required>
                    <label for="ovo">OVO</label>
                </div>
                <div class="radio-styling">
                    <input type="radio" id="dana" name="payment_method" value="Dana">
                    <label for="dana">DANA</label>
                </div>
                <div class="radio-styling">
                    <input type="radio" id="gopay" name="payment_method" value="GoPay">
                    <label for="gopay">GOPAY</label>
                </div>
            </div>
            <button type="submit" name="confirm_checkout" class="btn-cart">Konfirmasi Pembayaran</button>
        </form>
    </div>
</body>

</html>