<?php
session_start();
require 'connect.php';

$total_price = 0;
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];

// Ambil produk dari database jika keranjang tidak kosong
if (!empty($cart_items)) {
    $product_ids = implode(',', array_keys($cart_items));
    $query = "SELECT * FROM stationery WHERE id_stationery IN ($product_ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $products[$row['id_stationery']] = $row; // Simpan produk dalam array dengan ID sebagai key
    }
}

// Proses jika form checkout disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_products']) && !empty($_POST['selected_products'])) {
        $selected_products = $_POST['selected_products'];

        // Menghitung total harga dari produk yang dipilih
        foreach ($selected_products as $product_id) {
            if (isset($products[$product_id])) {
                $product = $products[$product_id];
                $quantity = $cart_items[$product_id];
                $price = $product['price'];
                $subtotal = $price * $quantity;

                // Hitung total keseluruhan
                $total_price += $subtotal;
            }
        }
    } else {
        echo "Tidak ada produk yang dipilih untuk checkout.";
        exit; // Hentikan eksekusi jika tidak ada produk yang dipilih
    }
} else {
    echo "Halaman ini hanya dapat diakses melalui form checkout.";
    exit; // Hentikan eksekusi jika halaman tidak diakses dengan benar
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="cart-container">
        <h1 class="cart-title">Checkout</h1>

        <table class="cart-table">
            <tr class="cart-table-header">
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kuantitas</th>
                <th>Total</th>
            </tr>
            <?php foreach ($selected_products as $product_id) :
                if (isset($products[$product_id])) {
                    $product = $products[$product_id];
                    $quantity = $cart_items[$product_id];
                    $price = $product['price'];
                    $subtotal = $price * $quantity;
            ?>
                    <tr class="cart-table-row">
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($price); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($subtotal); ?></td>
                    </tr>
            <?php
                }
            endforeach; ?>
            <tr class="cart-total-row">
                <td colspan="3"><strong>Total Keseluruhan</strong></td>
                <td><strong><?php echo number_format($total_price); ?></strong></td>
            </tr>
        </table>

        <h2>Pilih Metode Pembayaran</h2>
        <form action="process_payment.php" method="POST">
            <label for="payment_method">Metode Pembayaran:</label>
            <select name="payment_method" required>
                <option value="credit_card">OVO</option>
                <option value="bank_transfer">DANA</option>
                <option value="paypal">GOPAY</option>
            </select>

            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <input type="hidden" name="selected_products" value="<?php echo implode(',', $selected_products); ?>">
            <button type="submit" class="cart-button checkout">Bayar</button>
        </form>
    </div>
</body>

</html>
