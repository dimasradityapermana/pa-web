<?php
session_start();
require 'connect.php';

$total_price = 0;

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$products = [];
if (!empty($cart_items)) {
    $product_ids = implode(',', array_keys($cart_items));
    $query = "SELECT * FROM stationery WHERE id_stationery IN ($product_ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_products']) && !empty($_POST['selected_products'])) {
        $selected_products = $_POST['selected_products'];

        // Proses checkout untuk setiap produk yang dipilih
        foreach ($selected_products as $product_id) {
            echo "Proses checkout untuk produk ID: " . htmlspecialchars($product_id) . "<br>";
        }
    } else {
        echo "Tidak ada produk yang dipilih untuk checkout.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="cart-container">
        <h1 class="cart-title">Keranjang Belanja</h1>

        <?php if (!empty($products)) : ?>
            <form action="checkout.php" method="POST">
                <table class="cart-table">
                    <tr class="cart-table-header">
                        <th>Pilih</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($products as $product) :
                        $product_id = $product['id_stationery'];
                        $quantity = $cart_items[$product_id];
                        $price = $product['price'];
                        $subtotal = $price * $quantity;
                        $total_price += $subtotal;
                    ?>
                        <tr class="cart-table-row">
                            <td><input type="checkbox" name="selected_products[]" value="<?php echo $product_id; ?>" <?php if ($quantity < 1) echo 'disabled'; ?>></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($price); ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo number_format($subtotal); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="cart-total-row">
                        <td colspan="3"><strong>Total Keseluruhan</strong></td>
                        <td><strong><?php echo number_format($total_price); ?></strong></td>
                        <td></td>
                    </tr>
                </table>
                <div class="cart-actions">
                    <button type="submit" class="cart-button checkout">Checkout</button>
                </div>
            </form>
        <?php else : ?>
            <p class="cart-message">Keranjang Anda kosong.</p>
        <?php endif; ?>
    </div>
</body>

</html>
