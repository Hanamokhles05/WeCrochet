<?php
// Zainab Ali Alfaraj 2240006683

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/header.php");
include("includes/Connection.php");

// Delete single item
if (isset($_GET['delete'])) {

    $index = (int) $_GET['delete'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit();
}

// Empty cart
if (isset($_GET['empty'])) {

    unset($_SESSION['cart']);

    header("Location: cart.php");
    exit();
}

// Update quantity
if (isset($_POST['update'])) {

    $index = (int) $_POST['index'];
    $new_qty = (int) $_POST['new_quantity'];

    if (isset($_SESSION['cart'][$index])) {

        $pid = (int) $_SESSION['cart'][$index]['id'];

        $result = mysqli_query($conn, "SELECT P_Stock FROM products WHERE P_ID = $pid");
        $product = mysqli_fetch_assoc($result);

        if ($product) {

            if ($new_qty >= 1 && $new_qty <= $product['P_Stock']) {

                $_SESSION['cart'][$index]['quantity'] = $new_qty;

                header("Location: cart.php");
                exit();

            } else {

                echo "<script>alert('Quantity must be between 1 and " . $product['P_Stock'] . "');</script>";
            }
        }
    }
}

?>

<div class="cart-top">
    <a href="products.php" class="back-link">
        ← Back
    </a>
</div>

<h2 class="page-title">Shopping Cart</h2>

<button id="help-btn" class="btn btn-warning">
    ❓ Help
</button>

<div class="cart-container">

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>

        <table class="cart-table">

            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>

            <?php
            $grand_total = 0;

            foreach ($_SESSION['cart'] as $index => $item) {

                $item_total = $item['price'] * $item['quantity'];
                $grand_total += $item_total;
            ?>

                <tr>

                    <td>
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>"
                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                             width="80">
                    </td>

                    <td>
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>

                    <td>
                        <?php echo number_format($item['price'], 2); ?> SAR
                    </td>

                    <td>
                        <form method="POST" class="inline-form update-form">

                            <input type="hidden"
                                   name="index"
                                   value="<?php echo $index; ?>">

                            <input type="number"
                                   name="new_quantity"
                                   value="<?php echo $item['quantity']; ?>"
                                   min="1"
                                   max="<?php echo $item['stock']; ?>"
                                   required
                                   class="quantity-input">

                            <button type="submit"
                                    name="update"
                                    class="btn btn-warning small-btn">
                                Update
                            </button>

                        </form>
                    </td>

                    <td>
                        <?php echo number_format($item_total, 2); ?> SAR
                    </td>

                    <td>
                        <a href="cart.php?delete=<?php echo $index; ?>"
                           class="btn btn-danger small-btn delete-btn">
                            Delete
                        </a>
                    </td>

                </tr>

            <?php } ?>

        </table>

        <p class="cart-total">
            Grand Total: <?php echo number_format($grand_total, 2); ?> SAR
        </p>

        <div class="cart-actions">

            <a href="cart.php?empty=1"
               class="btn btn-danger empty-btn">
                Empty Cart 🗑️
            </a>

            <a href="products.php" class="btn btn-warning">
                Continue Shopping 🛍️
            </a>

            <a href="checkout.php" class="btn btn-success buy-btn" id="checkout-link">
                Proceed to Checkout ✅
            </a>

        </div>

    <?php } else { ?>

        <div class="empty-cart">
            <p>Your cart is empty 🛒</p>

            <br>

            <a href="products.php" class="btn btn-primary">
                Start Shopping →
            </a>
        </div>

    <?php } ?>

</div>

<script src="js/cart.js"></script>

<?php
mysqli_close($conn);
include("includes/footer.php");
?>