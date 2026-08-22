<?php
// Checkout page

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("includes/header.php");
include("includes/Connection.php");

$order_placed = isset($_GET['success']) && isset($_GET['order_id']);

// ===== Show order confirmation =====
if ($order_placed) {

    $order_id = (int) $_GET['order_id'];

    $order_result = mysqli_query($conn, "SELECT * FROM orders WHERE O_ID = $order_id");
    $order = mysqli_fetch_assoc($order_result);

    $items_result = mysqli_query($conn, "SELECT * FROM order_items WHERE O_ID = $order_id");

    if (!$order) {
        header("Location: products.php");
        exit();
    }
?>

    <div class="checkout-container">

        <div class="order-success">

            <h2 class="page-title">✅ Order Confirmed!</h2>

            <p class="order-thanks">
                Thank you, <?php echo htmlspecialchars($order['O_Name']); ?>! Your order has been placed successfully.
            </p>

            <p class="order-number">
                Order Number: <strong>#WC-<?php echo $order_id; ?></strong>
            </p>

            <table class="cart-table order-summary-table">

                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>

                <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>

                    <tr>
                        <td><?php echo htmlspecialchars($item['OI_Name']); ?></td>
                        <td><?php echo number_format($item['OI_Price'], 2); ?> SAR</td>
                        <td><?php echo (int) $item['OI_Quantity']; ?></td>
                        <td><?php echo number_format($item['OI_Price'] * $item['OI_Quantity'], 2); ?> SAR</td>
                    </tr>

                <?php } ?>

            </table>

            <p class="cart-total">
                Grand Total: <?php echo number_format($order['O_Total'], 2); ?> SAR
            </p>

            <div class="checkout-info-box">
                <p><strong>Shipping to:</strong> <?php echo htmlspecialchars($order['O_Address']); ?>, <?php echo htmlspecialchars($order['O_City']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['O_Phone']); ?></p>
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['O_PaymentMethod']); ?></p>
            </div>

            <a href="products.php" class="btn btn-primary">Continue Shopping 🛍️</a>

        </div>

    </div>

<?php
    mysqli_close($conn);
    include("includes/footer.php");
    exit();
}

// ===== No items to check out =====
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$grand_total = 0;

foreach ($_SESSION['cart'] as $item) {
    $grand_total += $item['price'] * $item['quantity'];
}

$errors = array();

// ===== Place order =====
if (isset($_POST['place_order'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : "";

    if ($name === "") {
        $errors[] = "Full name is required.";
    }

    if ($phone === "") {
        $errors[] = "Phone number is required.";
    }

    if ($address === "") {
        $errors[] = "Address is required.";
    }

    if ($city === "") {
        $errors[] = "City is required.";
    }

    if ($payment_method !== "cod" && $payment_method !== "card") {
        $errors[] = "Please choose a payment method.";
    }

    // Re-check stock is still available for every item
    if (empty($errors)) {

        foreach ($_SESSION['cart'] as $item) {

            $pid = (int) $item['id'];

            $stock_result = mysqli_query($conn, "SELECT P_Stock FROM products WHERE P_ID = $pid");
            $stock_row = mysqli_fetch_assoc($stock_result);

            if (!$stock_row || $stock_row['P_Stock'] < $item['quantity']) {
                $errors[] = "Sorry, \"" . $item['name'] . "\" no longer has enough stock.";
            }
        }
    }

    if (empty($errors)) {

        $name_esc = mysqli_real_escape_string($conn, $name);
        $phone_esc = mysqli_real_escape_string($conn, $phone);
        $address_esc = mysqli_real_escape_string($conn, $address);
        $city_esc = mysqli_real_escape_string($conn, $city);
        $payment_label = $payment_method === "cod" ? "Cash on Delivery" : "Credit / Debit Card";

        $query = "INSERT INTO orders (O_Name, O_Phone, O_Address, O_City, O_PaymentMethod, O_Total)
                  VALUES ('$name_esc', '$phone_esc', '$address_esc', '$city_esc', '$payment_label', $grand_total)";

        mysqli_query($conn, $query);

        $order_id = mysqli_insert_id($conn);

        $past = array();

        if (isset($_COOKIE['past_purchases'])) {
            $decoded = json_decode($_COOKIE['past_purchases'], true);

            if (is_array($decoded)) {
                $past = $decoded;
            }
        }

        foreach ($_SESSION['cart'] as $item) {

            $pid = (int) $item['id'];
            $qty = (int) $item['quantity'];
            $item_name_esc = mysqli_real_escape_string($conn, $item['name']);

            mysqli_query($conn, "INSERT INTO order_items (O_ID, P_ID, OI_Name, OI_Price, OI_Quantity)
                                  VALUES ($order_id, $pid, '$item_name_esc', {$item['price']}, $qty)");

            mysqli_query($conn, "UPDATE products SET P_Stock = P_Stock - $qty WHERE P_ID = $pid");

            $past[] = array(
                'name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image']
            );
        }

        setcookie('past_purchases', json_encode($past), time() + (86400 * 30), "/");

        unset($_SESSION['cart']);

        header("Location: checkout.php?success=1&order_id=$order_id");
        exit();
    }
}
?>

<div class="checkout-top">
    <a href="cart.php" class="back-link">← Back to Cart</a>
</div>

<h2 class="page-title">Checkout</h2>

<div class="checkout-container">

    <div class="checkout-grid">

        <div class="checkout-form-box">

            <h3>Shipping & Payment Details</h3>

            <?php if (!empty($errors)) { ?>

                <div class="error-message checkout-errors">
                    <?php foreach ($errors as $error) { ?>
                        <p>• <?php echo htmlspecialchars($error); ?></p>
                    <?php } ?>
                </div>

            <?php } ?>

            <form method="POST" id="checkoutForm">

                <div class="form-group">
                    <label class="field-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name" required
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ""; ?>">
                </div>

                <div class="form-group">
                    <label class="field-label" for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ""; ?>">
                </div>

                <div class="form-group">
                    <label class="field-label" for="address">Address</label>
                    <input type="text" id="address" name="address" required
                           value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ""; ?>">
                </div>

                <div class="form-group">
                    <label class="field-label" for="city">City</label>
                    <input type="text" id="city" name="city" required
                           value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ""; ?>">
                </div>

                <div class="form-group">

                    <label class="field-label">Payment Method</label>

                    <div class="payment-options">

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod"
                                <?php echo (!isset($_POST['payment_method']) || $_POST['payment_method'] === "cod") ? "checked" : ""; ?>>
                            💵 Cash on Delivery
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card"
                                <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] === "card") ? "checked" : ""; ?>>
                            💳 Credit / Debit Card
                        </label>

                    </div>

                </div>

                <button type="submit" name="place_order" class="btn btn-success place-order-btn">
                    Place Order ✅
                </button>

            </form>

        </div>

        <div class="checkout-summary-box">

            <h3>Order Summary</h3>

            <table class="cart-table order-summary-table">

                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

                <?php foreach ($_SESSION['cart'] as $item) { ?>

                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo (int) $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?> SAR</td>
                    </tr>

                <?php } ?>

            </table>

            <p class="cart-total">
                Grand Total: <?php echo number_format($grand_total, 2); ?> SAR
            </p>

        </div>

    </div>

</div>

<script src="js/checkout.js"></script>

<?php
mysqli_close($conn);
include("includes/footer.php");
?>
