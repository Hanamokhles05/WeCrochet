<?php
// Zainab Ali Alfaraj 2240006683
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



$cart_count = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WeCrochet</title>

    <link rel="stylesheet" href="/WeCrochet/Styles/style.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/home.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/cart.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/contact.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/footer.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/reviews.css">
    <link rel="stylesheet" href="/WeCrochet/Styles/checkout.css">
</head>

<body>

<nav class="navbar">

    <a href="/WeCrochet/home.php" class="logo">
        🧶 WeCrochet
    </a>

    <form method="GET"
          action="/WeCrochet/products.php"
          class="search-form">

        <input type="text"
               name="search"
               placeholder="Search products..."
               class="search-input">

        <button type="submit" class="search-btn">
            🔍
        </button>

    </form>

    <ul class="nav-links">

        <li>
            <a href="/WeCrochet/home.php">Home</a>
        </li>

        <li>
            <a href="/WeCrochet/products.php">Products</a>
        </li>

        <li>
            <a href="/WeCrochet/pages/categories.php">Categories</a>
        </li>

        <li>
            <a href="/WeCrochet/pages/wishlist.php">Wishlist</a>
        </li>

        <li>
            <a href="/WeCrochet/pages/contact.php">Contact Us</a>
        </li>

    </ul>

    <a href="/WeCrochet/cart.php" class="cart-icon">

        🛒

        <span class="cart-count">
            <?php echo $cart_count; ?>
        </span>

    </a>

</nav>