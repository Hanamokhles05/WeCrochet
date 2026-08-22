<?php
include("../includes/header.php");
include("../includes/Connection.php");

// جلب التصنيفات المتاحة
$cat_query = "SELECT DISTINCT P_Category FROM products WHERE P_Category IS NOT NULL AND P_Category != ''";
$cat_result = mysqli_query($conn, $cat_query);

$selected_cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

// جلب المنتجات حسب التصنيف المحدد
if (!empty($selected_cat)) {
    $prod_query = "SELECT * FROM products WHERE P_Category = '$selected_cat'";
} else {
    $prod_query = "SELECT * FROM products";
}
$prod_result = mysqli_query($conn, $prod_query);
?>

<div class="container" style="padding: 20px;">
    <h2>Categories</h2>
    
    <!-- قائمة التصنيفات -->
    <div class="category-list" style="margin-bottom: 20px;">
        <a href="categories.php" class="btn <?php echo empty($selected_cat) ? 'btn-primary' : 'btn-secondary'; ?>">All</a>
        <?php while($cat = mysqli_fetch_assoc($cat_result)) { ?>
            <a href="categories.php?cat=<?php echo urlencode($cat['P_Category']); ?>" 
               class="btn <?php echo ($selected_cat == $cat['P_Category']) ? 'btn-primary' : 'btn-secondary'; ?>">
                <?php echo htmlspecialchars($cat['P_Category']); ?>
            </a>
        <?php } ?>
    </div>

    <!-- عرض المنتجات -->
    <div class="product-grid" style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php if(mysqli_num_rows($prod_result) > 0) { 
            while($product = mysqli_fetch_assoc($prod_result)) { ?>
                <div class="product-card" style="border: 1px solid #ddd; padding: 15px; width: 200px; text-align: center;">
                    <img src="../images/<?php echo htmlspecialchars($product['P_Image']); ?>" style="max-width: 100%; height: 150px; object-fit: cover;">
                    <h3><?php echo htmlspecialchars($product['P_Name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['P_Price']); ?> SAR</p>
                    <a href="product_details.php?id=<?php echo $product['P_ID']; ?>" class="btn btn-primary">View Details</a>
                </div>
            <?php } 
        } else { ?>
            <p>No products found in this category.</p>
        <?php } ?>
    </div>
</div>

<?php
mysqli_close($conn);
include("../includes/footer.php");
?>