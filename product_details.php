<?php
// Raghad Alyabis 2240003458

include("../includes/header.php");
include("../includes/Connection.php");

if (!isset($_GET['id'])) {
    header("Location: ../products.php");
    exit();
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM products WHERE P_ID = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<p>Product not found.</p>";
    include("../includes/footer.php");
    exit();
}

// Add review
if (isset($_POST['add_review'])) {

    $r_name = trim($_POST['r_name']);
    $r_rating = (int) $_POST['r_rating'];
    $r_comment = trim($_POST['r_comment']);

    if ($r_name === "" || $r_comment === "") {
        $review_message = "Please fill in your name and comment.";
        $review_msg_type = "error";
    } elseif ($r_rating < 1 || $r_rating > 5) {
        $review_message = "Please select a rating.";
        $review_msg_type = "error";
    } else {
        $r_name_esc = mysqli_real_escape_string($conn, $r_name);
        $r_comment_esc = mysqli_real_escape_string($conn, $r_comment);

        // تم تعديل أسماء الأعمدة لتطابق الجدول (User_Name, Rating, Review_Text)
        $query = "INSERT INTO reviews (P_ID, User_Name, Rating, Review_Text)
                  VALUES ($id, '$r_name_esc', $r_rating, '$r_comment_esc')";

        mysqli_query($conn, $query);

        header("Location: product_details.php?id=$id&review_added=1#reviews");
        exit();
    }
}

if (isset($_POST['add_to_cart'])) {

    $qty = (int) $_POST['quantity'];

    if ($qty > 0 && $qty <= $product['P_Stock']) {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $found = false;

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $new_qty = $item['quantity'] + $qty;

                if ($new_qty <= $product['P_Stock']) {
                    $item['quantity'] = $new_qty;
                    $found = true;
                    header("Location: product_details.php?id=$id&added=1");
                    exit();
                } else {
                    $message = "Sorry, you already have " . $item['quantity'] .
                               " in your cart. Only " . $product['P_Stock'] .
                               " items are available in stock.";
                    $msg_type = "error";
                    $found = true;
                }
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = array(
                'id' => $product['P_ID'],
                'name' => $product['P_Name'],
                'price' => $product['P_Price'],
                'image' => $product['P_Image'],
                'quantity' => $qty,
                'stock' => $product['P_Stock']
            );

            header("Location: product_details.php?id=$id&added=1");
            exit();
        }

    } elseif ($qty <= 0) {
        $message = "Please enter a valid quantity.";
        $msg_type = "error";
    } else {
        $message = "Sorry, only " . $product['P_Stock'] . " items available in stock.";
        $msg_type = "error";
    }
}
?>

<script>
    var productStock = <?php echo $product['P_Stock']; ?>;
</script>

<div class="product-top">
    <a href="../products.php" class="back-link">← Back</a>
</div>

<div class="product-detail">
    <img src="../images/<?php echo htmlspecialchars($product['P_Image']); ?>"
         alt="<?php echo htmlspecialchars($product['P_Name']); ?>">

    <div class="info">
        <h1><?php echo htmlspecialchars($product['P_Name']); ?></h1>
        <p class="price"><?php echo htmlspecialchars($product['P_Price']); ?> SAR</p>
        <p class="stock">In Stock: <?php echo htmlspecialchars($product['P_Stock']); ?> items</p>
        <p class="description"><?php echo htmlspecialchars($product['P_Description']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['P_Category']); ?></p>

        <br>

        <?php if (isset($_GET['added'])) { ?>
            <p class="success-message">Product added to cart successfully!</p>
        <?php } ?>

        <?php if (isset($message) && $msg_type == "error") { ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST" id="cartForm">
            <input type="number"
                   required
                   name="quantity"
                   id="quantity"
                   class="quantity-input"
                   min="1"
                   max="<?php echo $product['P_Stock']; ?>"
                   placeholder="Qty">

            <button type="submit" name="add_to_cart" class="btn btn-primary">
                Add to Cart 🛒
            </button>

            <button type="button" id="helpBtn" class="btn btn-warning">
                Help ❓
            </button>
        </form>

        <br>
        <a href="../cart.php" class="btn btn-success">Go to Checkout →</a>
    </div>
</div>

<?php
// تم تعديل الاستعلام لاستخدام Created_At بدلاً من R_Date
$reviews_result = mysqli_query($conn, "SELECT * FROM reviews WHERE P_ID = $id ORDER BY Created_At DESC");
$reviews = array();
$total_rating = 0;

if ($reviews_result) {
    while ($row = mysqli_fetch_assoc($reviews_result)) {
        $reviews[] = $row;
        $total_rating += $row['Rating'];
    }
}

$review_count = count($reviews);
$avg_rating = $review_count > 0 ? round($total_rating / $review_count, 1) : 0;
?>

<div class="reviews-section" id="reviews">
    <h2 class="reviews-title">⭐ Customer Reviews</h2>

    <div class="reviews-summary">
        <?php if ($review_count > 0) { ?>
            <span class="avg-score"><?php echo $avg_rating; ?></span>
            <span class="stars">
                <?php echo str_repeat("★", round($avg_rating)) . str_repeat("☆", 5 - round($avg_rating)); ?>
            </span>
            <span class="review-count">
                (<?php echo $review_count; ?> review<?php echo $review_count > 1 ? "s" : ""; ?>)
            </span>
        <?php } else { ?>
            <span class="review-count">No ratings yet</span>
        <?php } ?>
    </div>

    <?php if ($review_count > 0) { ?>
        <div class="review-list">
            <?php foreach ($reviews as $review) { ?>
                <div class="review-card">
                    <div class="review-head">
                        <span class="review-name">
                            <?php echo htmlspecialchars($review['User_Name']); ?>
                        </span>
                        <span class="review-stars">
                            <?php echo str_repeat("★", $review['Rating']) . str_repeat("☆", 5 - $review['Rating']); ?>
                        </span>
                        <span class="review-date">
                            <?php echo date("d M Y", strtotime($review['Created_At'])); ?>
                        </span>
                    </div>
                    <p class="review-comment">
                        <?php echo nl2br(htmlspecialchars($review['Review_Text'])); ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="no-reviews">Be the first to review this product!</p>
    <?php } ?>

    <div class="review-form-box">
        <h3>Write a Review</h3>

        <?php if (isset($_GET['review_added'])) { ?>
            <p class="success-message">Thank you! Your review has been added.</p>
        <?php } ?>

        <?php if (isset($review_message) && $review_msg_type == "error") { ?>
            <p class="error-message"><?php echo $review_message; ?></p>
        <?php } ?>

        <form method="POST" id="reviewForm">
            <div class="form-group">
                <label class="field-label">Your Rating</label>
                <div class="star-rating-input">
                    <input type="radio" name="r_rating" id="star5" value="5"><label for="star5">★</label>
                    <input type="radio" name="r_rating" id="star4" value="4"><label for="star4">★</label>
                    <input type="radio" name="r_rating" id="star3" value="3"><label for="star3">★</label>
                    <input type="radio" name="r_rating" id="star2" value="2"><label for="star2">★</label>
                    <input type="radio" name="r_rating" id="star1" value="1"><label for="star1">★</label>
                </div>
            </div>

            <div class="form-group">
                <label class="field-label" for="r_name">Your Name</label>
                <input type="text" id="r_name" name="r_name" placeholder="Enter your name" maxlength="100" required>
            </div>

            <div class="form-group">
                <label class="field-label" for="r_comment">Your Review</label>
                <textarea id="r_comment" name="r_comment" placeholder="Share your thoughts about this product..." required></textarea>
            </div>

            <button type="submit" name="add_review" class="btn btn-primary">
                Submit Review
            </button>
        </form>
    </div>
</div>

<script src="../js/product_details.js"></script>
<script src="../js/reviews.js"></script>

<?php
mysqli_close($conn);
include("../includes/footer.php");
?>