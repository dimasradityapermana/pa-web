<?php
session_start();
require 'connect.php';

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart_items = $_SESSION['cart'];
    $products = [];
    $product_ids = implode(',', array_map('intval', array_keys($cart_items)));
    $query = "SELECT * FROM stationery WHERE id_stationery IN ($product_ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['id_stationery'];
        $products[$product_id] = $row;
        $products[$product_id]['quantity'] = $cart_items[$product_id];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        $_SESSION['cart'][$product_id] = max(0, (int)$quantity);
        if ($_SESSION['cart'][$product_id] === 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Cart</title>
    <link rel="icon" href="assets/logo.png">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/body.css">
</head>

<body>
    <div class="cart-container">
        <h1>Update Cart Shopping</h1>
        <form action="update_cart.php" method="POST">
            <table class="cart-table">
                <tr class="cart-table-header">
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                <?php foreach ($products as $product) : ?>
                    <tr class="cart-table-row">
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo number_format($product['price']); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $product['id_stationery']; ?>]" value="<?php echo $product['quantity']; ?>" min="1">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit" class="btn-cart">Update</button>
        </form>
    </div>
</body>

</html>