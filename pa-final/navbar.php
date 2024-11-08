<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <div class="navbar-container">
        <div class="left-header">
            <img src="assets/logo.png" alt="logo">
            <h3>Dimoc Stationery</h3>
        </div>
        <nav class="right-header">
            <ul>
                <button id="switch-theme-desktop" style="background: none; border: none;">🌓</button>
                <li><a href="index.php">Home</a></li>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="products.php">Products</a></li>
                <li>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <a href="logout.php" style="color: red;">
                            Logout
                        </a>
                    <?php else : ?>
                        <a href="login.php">
                            Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
    <div class="hamburger-menu">
        <input type="checkbox" id="menu-toggle" style="display: none;">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <div class="menu">
            <ul>
                <li><button id="switch-theme-mobile" style="background: none; border: none;">🌓</button></li>
                <li><a href="index.php" style="font-family: 'Poppins', sans-serif;">Home</a></li>
                <li><a href="about-us.php" style="font-family: 'Poppins', sans-serif;">About Us</a></li>
                <li><a href="products.php" style="font-family: 'Poppins', sans-serif;">Products</a></li>
                <li>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <a href="logout.php" style="color: red; font-family: 'Poppins', sans-serif;">
                            Logout
                        </a>
                    <?php else : ?>
                        <a href="login.php" style="font-family: 'Poppins', sans-serif;">
                            Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</header>