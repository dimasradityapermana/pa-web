<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimoc | StudyTwt Stationery Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="assets/logo.png">
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
        <section class="section-1" style="background-image: url(assets/welcome.png);">
            <div class="container-welcome">
                <div class="welcome-text">
                    <h6>Most Sought</h6>
                    <h2>Already in Collection</h2>
                    <a href="products.php" class="btn-welcome">View Item ></a>
                </div>
            </div>
        </section>

        <section class="section-2">
            <div class="container-opening">
                <div class="purchase-text">
                    <h2>Discover the perfect stationery to suit your needs here!</h2>
                    <p>Interested in all the hottest stationery from StudyTwt? Check out our products on the marketplace</p>
                    <a href="#" class="btn-opening">See all ></a>
                </div>
                <div class="purchase-icons">
                    <a href="https://www.shopee.com"><img src="assets/shopee.png" alt="Shopee"></a>
                    <a href="https://www.temu.com"><img src="assets/temu.png" alt="Tokopedia"></a>
                    <a href="https://www.lazada.co.id"><img src="assets/lazada.png" alt="Lazada"></a>
                    <a href="https://www.taobao.com"><img src="assets/taobao.png" alt="Blibli"></a>
                </div>
            </div>
        </section>
        
        <section class="section-3">
            <div class="container-type">
                <div class="top-category">
                    <div class="category-pen">
                        <a href="products.php?search=Alat Tulis" class="btn-type">PEN</a>
                    </div>
                    <div class="category-binder">
                        <a href="products.php?search=Kertas & Buku" class="btn-type">BINDER</a>
                    </div>
                    <div class="category-drawing">
                        <a href="products.php?search=Alat Gambar" class="btn-type">DRAWING</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-4">
            <div class="container-slider">
                <div class="container-slider-4">
                    <img class="image-source" src="assets/picture-1.jpg">
                    <img class="image-source" src="assets/picture-2.jpg">
                </div>
            </div>
        </section>

    </main>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>

</html>