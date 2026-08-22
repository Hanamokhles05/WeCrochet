<?php
// Maryam Shahin 2240001335

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: LogIn_Admin.php");
    exit();
}

include("../includes/Connection.php");

$message = "";
$msg_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $folder = "../images/" . $image_name;

    move_uploaded_file($tmp_name, $folder);

    $sql = "INSERT INTO products
            (P_Name, P_Price, P_Stock, P_Image, P_Description, P_Category)
            VALUES
            ('$name', '$price', '$stock', '$image_name', '$description', '$category')";

    if (mysqli_query($conn, $sql)) {

        header("Location: AdminPage.php");
        exit();

    } else {

        $message = "Error: " . mysqli_error($conn);
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Add Product</title>

<link rel="stylesheet" href="../Styles/addproducts_page.css">

</head>

<body>

<div class="container">

    <h3>Add Products Here</h3>

    <?php if (!empty($message)) { ?>

        <p class="<?php echo $msg_type; ?>">
            <?php echo $message; ?>
        </p>

    <?php } ?>

    <form method="POST"
          enctype="multipart/form-data"
          id="addProductForm">

        <label>Name:</label>

        <input type="text"
               name="name"
               id="name"
               required>

        <label>Image:</label>

        <input type="file"
               name="image"
               id="image"
               required>

        <label>Stock:</label>

        <input type="number"
               name="stock"
               id="stock"
               required>

        <label>Price:</label>

        <input type="number"
               step="0.01"
               name="price"
               id="price"
               required>

        <label>Description:</label>

        <textarea name="description"
                  id="description"
                  required></textarea>

        <label>Category:</label>

        <select name="category"
                id="category"
                required>

            <option value="">Select Category</option>

            <option value="Crochet Toys">
    Crochet Toys
</option>

<option value="Crochet Flowers">
    Crochet Flowers
</option>

        </select>

        <button type="submit">
            Add Product
        </button>

    </form>

</div>

<script src="../js/add_product.js"></script>

</body>
</html>