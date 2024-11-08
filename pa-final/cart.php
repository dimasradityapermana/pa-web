    <?php
    session_start();
    require 'connect.php';
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $products = [];
    $total_price = 0;

    if (!empty($cart_items)) {
        $product_ids = implode(',', array_map('intval', array_keys($cart_items)));

        if (!empty($product_ids)) {
            $query = "SELECT * FROM stationery WHERE id_stationery IN ($product_ids)";
            $result = mysqli_query($conn, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['id_stationery'];
                    if (isset($cart_items[$product_id])) { 
                        $products[$product_id] = $row;
                        $products[$product_id]['quantity'] = $cart_items[$product_id];
                        $total_price += $row['price'] * $cart_items[$product_id];
                    }
                }
            } else {
                echo "Terjadi kesalahan pada pengambilan data produk dari database.";
                exit;
            }
        } else {
            echo "<script>alert('Keranjang belanja kosong.'); window.location.href='products.php';</script>";
            exit;
        }
    }else {
            echo "<script>alert('Keranjang belanja kosong.'); window.location.href='products.php';</script>";
            exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Shopping</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="icon" href="assets/logo.png">
    <link rel="stylesheet" href="style.css">    <link rel="stylesheet" href="css/body.css">
    </head>

    <body>
        <div class="cart-container">
            <h1 class="cart-title">Cart Shopping</h1>
            <?php if (!empty($products)) : ?>
                <form action="checkout.php" method="POST">
                    <table class="cart-table">
                        <div class="cart-button">
                            <a href="update_cart.php" class="btn-cart">Update Cart</a>
                        </div>
                        <tr class="cart-table-header">
                            <th>Choose</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>    
                        </tr>
                        <?php foreach ($products as $product) :
                            $product_id = $product['id_stationery'];
                            $quantity = $cart_items[$product_id];
                            $price = $product['price'];
                            $subtotal = $price * $quantity;
                        ?>
                            <tr class="cart-table-row">
                                <td><input type="checkbox" name="selected_products[]" value="<?php echo $product_id; ?>"></td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo number_format($price); ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo number_format($subtotal); ?></td>
                                <td><a href="delete_cart.php?product_id=<?php echo $product_id; ?>" class="btn-cart-delete">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="cart-total-row">
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong><?php echo number_format($total_price); ?></strong></td>
                            <td></td>
                        </tr>
                    </table>
                    <button type="submit" class="btn-cart">Checkout</button>
                </form>
            <?php else : ?>
                <p class="cart-message">Keranjang Anda kosong.</p>
            <?php endif; ?>
        </div>
    </body>

    </html>