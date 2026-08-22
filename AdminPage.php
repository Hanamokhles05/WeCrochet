<?php
// Hana Mokhles 2240009110

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: LogIn_Admin.php");
    exit();
}

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: LogIn_Admin.php");
    exit();
}

include("../includes/Connection.php");

// Delete Product
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $delete_sql = "DELETE FROM products WHERE P_ID = $id";

    if ($conn->query($delete_sql) === TRUE) {

        header("Location: AdminPage.php");
        exit();

    } else {

        echo "Error deleting product";
    }
}

// Search
$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (!empty($search)) {

    $sql = "SELECT * FROM products
            WHERE P_Name LIKE '%$search%'
            OR P_Category LIKE '%$search%'
            OR P_Description LIKE '%$search%'";

} else {

    $sql = "SELECT * FROM products";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Products</title>

    <link rel="stylesheet"
          href="../Styles/AdminPage.css">

</head>

<body>

<header class="header">

    <div class="header-left">

        <h1>Admin Product Management</h1>

        <p>
            Manage all products in the WeCrochet store
        </p>

    </div>

    <div class="header-center">

        <form method="GET" class="search-form">

            <input type="text"
                   name="search"
                   placeholder="Search..."
                   value="<?php if (isset($_GET['search'])) echo htmlspecialchars($_GET['search']); ?>">

            <button type="submit">
                Search
            </button>

        </form>

    </div>

    <div class="header-right">

        <a href="addproducts_page.php"
           class="btn add-btn">

            Add Product

        </a>

        <a href="?logout=1"
           class="btn logout-btn">

            Logout

        </a>

    </div>

</header>

<div class="table-container">

    <h2>Products Table</h2>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Description</th>
                <th>Category</th>
                <th>Delete</th>
                <th>Modify</th>

            </tr>

        </thead>

        <tbody>

        <?php if ($result && $result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row['P_ID']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['P_Name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['P_Price']); ?> R.S
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['P_Stock']); ?>
                    </td>

                    <td>

                        <img src="../images/<?php echo htmlspecialchars($row['P_Image']); ?>"
                             width="80"
                             alt="Product Image">

                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['P_Description']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['P_Category']); ?>
                    </td>

                    <td>

                        <a class="table-btn delete-btn"
                           href="AdminPage.php?delete=<?php echo $row['P_ID']; ?>">

                            Delete

                        </a>

                    </td>

                    <td>

                        <a class="table-btn modify-btn"
                           href="Modify_page.php?id=<?php echo $row['P_ID']; ?>">

                            Modify

                        </a>

                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td colspan="9">
                    No products found.
                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<script src="../js/admin.js"></script>

</body>
</html>