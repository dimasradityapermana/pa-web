<?php
require 'connect.php';

session_start();
$query = "SELECT * FROM history";
$result = mysqli_query($conn, $query);

$history = [];
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = mysqli_query($conn, "SELECT * FROM history WHERE name LIKE '%$search%' OR merk LIKE '%$search%'");
    $history = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $history[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>History</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="icon" href="assets/logo.png">
    <link rel="stylesheet" href="css/footer-etc.css">
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
        <!-- <search>
            <form action="" method="GET" class="search-bar">
                <input type="text" name="search"
                    class="search-input" />
                <button type="submit" class="search-button">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                </button>
            </form>
        </search> -->

        <div style="margin-top: 10px;" class="section-products">
            <a href="products.php">
                <button type="button" class="back">
                    <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp; Back to Products
                </button>
            </a>
            <table class="table-stationery">
                <thead>
                    <tr class="table-stationery-row">
                        <th class="table-stationery-header">No</th>
                        <th class="table-stationery-header">History ID </th>
                        <th class="table-stationery-header">Buyer Name</th>
                        <th class="table-stationery-header">Date</th>
                        <th class="table-stationery-header">Total</th>
                        <th class="table-stationery-header">Payment Method</th>
                        <th class="table-stationery-header">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($history as $hst) : ?>
                        <tr class="table-stationery-row">
                            <td class="table-stationery-data"><?php echo $i ?></td>
                            <td class="table-stationery-data"><?php echo $hst['id_transaksi'] ?></td>
                            <td class="table-stationery-data"><?php echo $hst['user_id'] ?></td>
                            <td class="table-stationery-data"><?php echo $hst['tanggal'] ?></td>
                            <td class="table-stationery-data"><?php echo $hst['total_harga'] ?></td>
                            <td class="table-stationery-data"><?php echo $hst['metode_pembayaran'] ?></td>
                            <td class="table-stationery-data"><?php echo $hst['status_pembayaran'] ?></td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>