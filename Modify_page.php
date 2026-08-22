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

    $id = $_POST['id'];

    $updates = array();

    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
        $updates[] = "P_Name='$name'";
    }

    if (!empty($_POST['price'])) {
        $price = $_POST['price'];
        $updates[] = "P_Price='$price'";
    }

    if ($_POST['stock'] !== "") {
        $stock = $_POST['stock'];
        $updates[] = "P_Stock='$stock'";
    }

    if (!empty($_POST['description'])) {
        $description = $_POST['description'];
        $updates[] = "P_Description='$description'";
    }

    if (!empty($_POST['category'])) {
        $category = $_POST['category'];
        $updates[] = "P_Category='$category'";
    }

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $folder = "../images/" . $image_name;
        move_uploaded_file($tmp_name, $folder);

        $updates[] = "P_Image='$image_name'";
    }

    if (!empty($updates)) {

        $sql = "UPDATE products SET " . implode(", ", $updates) . " WHERE P_ID='$id'";

        if (mysqli_query($conn, $sql)) {

            header("Location: AdminPage.php");
            exit();

        } else {

            $message = "Error: " . mysqli_error($conn);
            $msg_type = "error";
        }

    } else {

        $message = "Please enter at least one field to modify.";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Modify Product</title>
<link rel="stylesheet" href="../Styles/Modify_page.css">
</head>

<body>

<div class="container">

    <h3>Modify Products Here</h3>
    <p>Enter the Product ID and fill only the fields you want to change.</p>

    <?php if (!empty($message)) { ?>
        <p class="<?php echo $msg_type; ?>">
            <?php echo $message; ?>
        </p>
    <?php } ?>

    <form method="POST"
          enctype="multipart/form-data"
          id="modifyProductForm">

        <label>Product ID:</label>
        <input type="number" name="id" id="id" required>

        <label>Name:</label>
        <input type="text" name="name" id="name">

        <label>Image:</label>
        <input type="file" name="image">

        <label>Stock:</label>
        <input type="number" name="stock" id="stock">

        <label>Price:</label>
        <input type="number" step="0.01" name="price" id="price">

        <label>Description:</label>
        <textarea name="description" id="description"></textarea>

        <label>Category:</label>

<select name="category" id="category">
    <option value="">Select Category</option>
    <option value="Crochet Toys">Crochet Toys</option>
    <option value="Crochet Flowers">Crochet Flowers</option>
</select>


        <button type="submit">Modify Product</button>

    </form>

</div>

<script src="../js/modify_product.js"></script>

</body>
</html>