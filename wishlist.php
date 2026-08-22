<?php
include("../includes/header.php");
include("../includes/Connection.php");

// إضافة أو حذف من المفضلة عبر Session
if (isset($_GET['action'])) {
    $p_id = (int)$_GET['id'];
    
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }

    if ($_GET['action'] == 'add') {
        if (!in_array($p_id, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $p_id;
        }
        header("Location: wishlist.php");
        exit();
    } elseif ($_GET['action'] == 'remove') {
        $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], array($p_id));
        header("Location: wishlist.php");
        exit();
    }
}

$wishlist_items = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : array();
?>

<div class="container" style="padding: 20px;">
    <h2>My Wishlist 💖</h2>

    <?php if (!empty($wishlist_items)) { 
        $ids = implode(',', array_map('intval', $wishlist_items));
        $query = "SELECT * FROM products WHERE P_ID IN ($ids)";
        $result = mysqli_query($conn, $query);
    ?>
        <div class="product-grid" style="display: flex; flex-wrap: wrap; gap: 20px;">
            <?php while($product = mysqli_fetch_assoc($result)) { ?>
                <div class="product-card" style="border: 1px solid #ddd; padding: 15px; width: 200px; text-align: center;">
                    <img src="../images/<?php echo htmlspecialchars($product['P_Image']); ?>" style="max-width: 100%; height: 150px; object-fit: cover;">
                    <h3><?php echo htmlspecialchars($product['P_Name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['P_Price']); ?> SAR</p>
                    <a href="product_details.php?id=<?php echo $product['P_ID']; ?>" class="btn btn-primary">View</a>
                    <a href="wishlist.php?action=remove&id=<?php echo $product['P_ID']; ?>" class="btn btn-danger" style="margin-top: 5px;">Remove</a>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Your wishlist is empty!</p>
    <?php } ?>
</div>

<?php
mysqli_close($conn);
include("../includes/footer.php");
?>