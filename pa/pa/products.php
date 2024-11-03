<?php
require 'connect.php';

session_start();
$query = "SELECT * FROM stationery";
$result = mysqli_query($conn, $query);

$stationery = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stationery[] = $row;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = mysqli_query($conn, "SELECT * FROM stationery WHERE name LIKE '%$search%' OR
merk LIKE '%$search%'");
    $stationery = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $stationery[] = $row;
    }
}


if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity; 
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
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

        <search>
            <form action="" method="GET" class="search-bar">
                <input type="text" name="search"
                    class="search-input" />
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                </button>
            </form>
        </search>

        <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) : ?>
            <div class="button-add">
                <a href="1_create.php">
                    <button class="create">
                        <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add Product
                    </button>
                </a>
            </div>
        <?php endif; ?>

        <table class="table-stationery">
            <thead>
                <tr class="table-stationery-row">
                    <th class="table-stationery-header">No</th>
                    <th class="table-stationery-header">Nama</th>
                    <th class="table-stationery-header">Merk</th>
                    <th class="table-stationery-header">Harga</th>
                    <th class="table-stationery-header">Stok</th>
                    <th class="table-stationery-header">Foto</th>
                    <th class="table-stationery-header">Tambah</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($stationery as $stry) : ?>
                    <tr class="table-stationery-row">
                        <!--  -->
                        <td class="table-stationery-data"><?php echo $i; ?></td>
                        <td class="table-stationery-data"><?php echo $stry['name'] ?></td>
                        <td class="table-stationery-data"><?php echo $stry['merk'] ?></td>
                        <td class="table-stationery-data"><?php echo $stry['price'] ?></td>
                        <td class="table-stationery-data"><?php echo $stry['stock'] ?></td>
                        <td class="table-stationery-data">
                            <img src="images/<?php echo $stry['photo'] ?>" alt="<?php echo $stry['name'] ?>" width="80px" class="imagination" height="100px" style="display:block; margin 0 auto;">
                        </td>
                        <td class="table-stationery-data">
                            <form action="products.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $stry['id_stationery']; ?>">
                                <input type="number" name="quantity" value="0" min="0">
                                <button  type="submit" name="add_to_cart">Tambah ke Keranjang</button>
                            </form>
                        </td>
                        <td class="table-stationery-data">
                            <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) : ?>
                                <div class="button-products">
                                    <a href="2_update.php?id_stationery=<?php echo $stry['id_stationery'] ?>">
                                        <button class="update">
                                            <i class="fa-solid fa-pen"></i> Update
                                        </button>
                                    </a>
                                    <a href="3_delete.php?id_stationery=<?php echo $stry['id_stationery'] ?>">
                                        <button class="delete">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
        
    </main>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>

</html>