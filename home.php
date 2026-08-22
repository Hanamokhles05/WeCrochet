<?php
// Zainab Ali Alfaraj 2240006683

include("includes/header.php");
include("includes/Connection.php");
?>

<img src="images/headstyle.png" class="headstyle headstyle-right" alt="Decoration">
<img src="images/headstyle.png" class="headstyle headstyle-left" alt="Decoration">

<div class="hero-section">
    <h1>🧶 Welcome to WeCrochet</h1>
    <p>Handmade crochet crafted with love</p>
    <br>
<a href="products.php" class="btn btn-primary hero-btn">Shop Now ✨</a></div>

<div class="featured-title">
    <h2>🛍️ Our Products</h2>
    <p>Check out some of our handmade pieces</p>
</div>

<div class="featured-container">
    <table width="100%" cellpadding="10">
        <tr>
            <?php
            $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <td width="25%" valign="top" class="featured-product">
<a href="pages/product_details.php?id=<?php echo $row['P_ID']; ?>">                        <img src="images/<?php echo htmlspecialchars($row['P_Image']); ?>"
                             alt="<?php echo htmlspecialchars($row['P_Name']); ?>">
                        <p class="product-name">
                            <?php echo htmlspecialchars($row['P_Name']); ?>
                        </p>
                        <p class="product-price">
                            <?php echo htmlspecialchars($row['P_Price']); ?> SAR
                        </p>
                    </a>
                </td>
            <?php } ?>
        </tr>
    </table>

    <div class="view-all">
<a href="products.php" class="btn btn-primary">View All Products →</a>    </div>
</div>

<?php
if (isset($_COOKIE['past_purchases'])) {

    $past = json_decode($_COOKIE['past_purchases'], true);

    if (!empty($past)) {
?>

        <h2 class="page-title past-title">Your Past Purchases</h2>

        <div class="products-grid past-grid">

            <?php foreach ($past as $item) { ?>

                <div class="product-card past-card">

                    <img src="images/<?php echo htmlspecialchars($item['image']); ?>"
                         alt="<?php echo htmlspecialchars($item['name']); ?>">

                    <div class="card-info past-info">

                        <h3>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h3>

                        <p class="price">
                            <?php echo htmlspecialchars($item['price']); ?> SAR
                        </p>

                    </div>

                </div>

            <?php } ?>

        </div>

<?php
    }
}
?>

<div class="why-section">
    <h2>💖 Why Choose Us?</h2>

    <table width="80%" cellpadding="15" class="why-table">
        <tr>
            <td width="33%" valign="top" class="why-card">
                <p class="why-icon">🧶</p>
                <h3>100% Handmade</h3>
                <p>Every piece is carefully crafted by hand with love and attention to detail.</p>
            </td>

            <td width="33%" valign="top" class="why-card">
                <p class="why-icon">🎁</p>
                <h3>Perfect Gifts</h3>
                <p>Unique and thoughtful gifts for your loved ones on any occasion.</p>
            </td>

            <td width="33%" valign="top" class="why-card">
                <p class="why-icon">🚚</p>
                <h3>Fast Delivery</h3>
                <p>We deliver across Saudi Arabia within 3-5 business days.</p>
            </td>
        </tr>
    </table>
</div>

<div class="admin-section">
    <div class="admin-box">
        <p class="admin-icon">🔐</p>
        <h2>Admin Panel</h2>
        <p>Authorized personnel only</p>

        <a href="pages/LogIn_Admin.php" class="admin-login-btn">
            Admin Login →
        </a>
    </div>
</div>

<?php
mysqli_close($conn);
include("includes/footer.php");
?>