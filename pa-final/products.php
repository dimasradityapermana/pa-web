<?php
session_start();
require 'connect.php';

if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
    $query = "SELECT * FROM stationery WHERE stock > 0";
} else {
    $query = "SELECT * FROM stationery";
}

$result = mysqli_query($conn, $query);

$stationery = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stationery[] = $row;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = mysqli_query($conn, "SELECT * FROM stationery WHERE name LIKE '%$search%' OR merk LIKE '%$search%' OR kategori LIKE '%$search%'");
    $stationery = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $stationery[] = $row;
    }
}
if (isset($_POST['add_to_cart'])) {
    foreach ($_POST['id'] as $index => $product_id) {
        $quantity = $_POST['quantity'][$index];

        if ($quantity > 0) {
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 0;
            }
            $_SESSION['cart'][$product_id] += $quantity;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="icon" href="assets/logo.png">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <main>
        <div class="section-products">
            <search>
                <form action="" method="GET" class="search-bar">
                    <input type="text" name="search"
                        class="search-input" />
                    <button type="submit" class="search-button">
                        <i class="fa-solid fa-magnifying-glass" style="color: #000000;"></i>
                    </button>
                </form>
            </search>

            <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <div class="btn-action">
                    <a class="btn-format" href="1_create.php">
                        <button class="create">
                            <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add Product
                        </button>
                    </a>
                    <a class="btn-format" href="history.php">
                        <button class="history">
                            <i class="fa-solid fa-file"></i>&nbsp;&nbsp;History
                        </button>
                    </a>
                    <a class="btn-format" href="konfirmasi.php">
                        <button class="konfirmasi">
                            <i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;Confirm Buyer
                        </button>
                    </a>
                </div>
            <?php endif; ?>

            <form action="validate_cart.php" method="POST">
                <table class="table-stationery">
                    <thead>
                        <tr class="table-stationery-row">
                            <th class="table-stationery-header">No</th>
                            <th class="table-stationery-header">Name</th>
                            <th class="table-stationery-header">Merk</th>
                            <th class="table-stationery-header">Price</th>
                            <th class="table-stationery-header">Stock</th>
                            <th class="table-stationery-header">Photo</th>
                            <th class="table-stationery-header">Category</th>
                            <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'user') : ?>
                                <th class="table-stationery-header">Add</th>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                                <th class="table-stationery-header">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($stationery as $stry) : ?>
                            <tr class="table-stationery-row">
                                <td class="table-stationery-data"><?php echo $i; ?></td>
                                <td class="table-stationery-data"><?php echo $stry['name'] ?></td>
                                <td class="table-stationery-data"><?php echo $stry['merk'] ?></td>
                                <td class="table-stationery-data"><?php echo $stry['price'] ?></td>
                                <td class="table-stationery-data"><?php echo $stry['stock'] ?></td>
                                <td class="table-stationery-data">
                                    <img src="images/<?php echo $stry['photo'] ?>" alt="<?php echo $stry['name'] ?>" width="80px" class="imagination" height="100px" style="display:block; margin 0 auto;">
                                </td>
                                <td class="table-stationery-data"><?php echo $stry['kategori'] ?></td>
                                <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'user') : ?>
                                    <td class="table-stationery-data">
                                        <input type="hidden" name="id[]" value="<?php echo $stry['id_stationery']; ?>">
                                        <input type="number" name="quantity[]" value="0" min="0">
                                    </td>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                                    <td class="table-stationery-data">
                                        <div class="btn-action">
                                            <a href="2_update.php?id_stationery=<?php echo $stry['id_stationery'] ?>" style="text-decoration:none;">
                                                <button type="button" class="update">
                                                    <i class="fa-solid fa-pen"></i>&nbsp;&nbsp; Update
                                                </button>
                                            </a>
                                            <a href="3_delete.php?id_stationery=<?php echo $stry['id_stationery'] ?>" style="text-decoration:none;">
                                                <button type="button" class="delete">
                                                    <i class="fa-solid fa-trash"></i>&nbsp;&nbsp; Delete
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] == 'user') : ?>
                    <button type="submit" name="add_to_cart" class="btn-cart">Add to Cart</button>
                <?php endif; ?>
            </form>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>