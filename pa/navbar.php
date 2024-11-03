<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<header>
    <div class="left-header">
        <img src="assets/logo.png" alt="logo">
        <h2>Dim's Stationery</h2>
    </div>
    <nav class="right-header">
        <ul>
            <button id="switch-theme">🌓</button>
            <li><a href="index.php">Home</a></li>
            <li><a href="about-us.php">About Me</a></li>
            <li><a href="products.php">Products</a></li>
            <li>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a href="logout.php" style="background-color: red; color: white; padding: 5px; border-radius: 5px; text-decoration: none;">
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

    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>